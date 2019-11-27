<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Client;
use App\State;
use App\Country;
use App\Project;
use App\Invoice;
use App\Estimate;
use App\Currency;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\Estimate as EstimateResource;
use App\Http\Resources\EstimateCollection;
use Illuminate\Support\Facades\Auth;


class EstimateController extends Controller {

    public function step1(Request $request) {
        $projects = Project::where('user_id', Auth::user()->id)->select('id', 'title')->get();
        return view('estimate.step1')->withProjects($projects);
    }

    public function step2(Request $request) {
        $project = '';
        $currencies = Currency::all('id', 'code');

        if ($request->old_project && $request->new_project)
            return back()->with('error', 'Please specify either an old or new project');
        elseif ($request->old_project)
            $project = ['type' => 'old', 'project' => $request->old_project];
        elseif ($request->new_project)
            $project = ['type' => 'new', 'project' => $request->new_project];

        if ($project == '')
            return back()->with('error', 'Please specify either an old or new project');
        if ($project['type'] == 'old')
            $project['project'] = Project::whereId($project['project'])->first()->title;

        session(['project' => $project]);
        return view('estimate.step2')->withProject($project['project'])->withCurrencies($currencies);
    }

    public function step3(Request $request) {

        //Check if 'sub_contractors' or 'sub_contractors_cost' input field is filled
        $sub_contractors_flag = isset($request->sub_contractors) || !empty($request->sub_contractors);
        $sub_contractors_cost_flag = isset($request->sub_contractors_cost) || !empty($request->sub_contractors_cost);

        if(($request->time >= 0) && ($request->price_per_hour >= 0) && ($request->equipment_cost >= 0) && ($request->sub_contractors_cost >= 0) && ($request->similar_projects >= 0) && (($request->rating >= 0) && ($request->rating <= 5)) && (!$sub_contractors_flag == !$sub_contractors_cost_flag)  )
        {
        $estimate = $request->except(['next_btn', 'next_page']);

        // $estimate = $request->all();
        $clients = Client::where('user_id', Auth::user()->id)->select('id', 'name')->get();
        session(['estimate' => $estimate]);

        return view('estimate.step3')->withClients($clients);
        }
        else
        {   $currencies = Currency::all('id', 'code');
            $project = session('project')['project'];
            $errorArray = [];

                if($request->time < 0) $errorArray[] = "Duration for project completion cannot be a negative value";

                if($request->price_per_hour < 0) $errorArray[] = "Amount collected per hour cannot be a negative value";

                if($request->equipment_cost < 0) $errorArray[] = "Equipment cost cannot be a negative value";

                //Check and generate error messages if either but not both 'sub_contractors' and 'sub_contractors_cost' fields are empty
                $sub_contractors_flag = isset($request->sub_contractors) || !empty($request->sub_contractors);
                $sub_contractors_cost_flag = isset($request->sub_contractors_cost) || !empty($request->sub_contractors_cost);
                if( !$sub_contractors_flag != !$sub_contractors_cost_flag) {
                    if($sub_contactors_flag) $errorArray += "Enter subcontractor cost";
                    if($sub_contactors_cost_flag) $errorArray += "Enter subcontractor name";
                }

                if($request->sub_contractors_cost < 0) $errorArray[] = "Number of sub contractors value cannot be a negative value";

                if($request->similar_projects < 0) $errorArray[] = "Similar projects value cannot be a negative value";

                if(($request->rating < 0)  && ($request->rating > 5)) $errorArray[] = "The rating for your experience level must be greater than -1 and less than or equal to 5";

               // default: $errorArray[] = "All numeric inputs must be greater than zero and rating must not be greater than 5";


            return view('estimate.step2')->with(['errors' => $errorArray, 'project' => $project, 'currencies' => $currencies]);
            //return redirect('/estimate/create/step2')->withProject($project['project'])->withCurrencies($currencies);
        }
    }

    public function step4(Request $request) {
        // dd(session()->all());
        $data['countries'] = Country::all('id', 'name');
        $data['states'] = State::all();
        $client = Client::whereId($request->client)->first();
        if (is_object($client)) {
            $data['project'] = session('project')['project'];
            $data['company'] = session('client')['name'];
            //  $data['company_address'] = session('client')['street'] . session('client')['city'];
            //  $data['company_country'] = Country::find(session('client')['country_id'])->name;
            $data['issued_date'] = Carbon::now();
            $data['due'] = session('estimate')['end'];
            $data['currency'] = Currency::find(session('estimate')['currency_id'])->code;
            $data['currency_symbol'] = Currency::find(session('estimate')['currency_id'])->symbol;
            $data['lancer_name'] = Auth::user()->name;
            $data['workmanship'] = (session('estimate')['price_per_hour'] ?? 2000) * session('estimate')['time'];
            $data['equipment_cost'] = session('estimate')['equipment_cost'];
            $data['sub_contractors_cost'] = session('estimate')['sub_contractors_cost'];
            $data['total'] = $data['workmanship'] + $data['equipment_cost'] + $data['sub_contractors_cost'];

            $estimate = Estimate::create(array_merge(session('estimate'), ['estimate' => $data['total'], 'user_id' => Auth::user()->id]));
			//dd($estimate->id);
            $project = Project::create([
                        'title' => $data['project'],
                        'user_id' => Auth::user()->id,
                        'estimate_id' => $estimate->id,
                        'client_id' => $request->client,
                        'tracking_code' => random_int(10, 100000),
                        'progress' => 0,
                        //'sub_contractors' => session('estimate')['sub_contractors'],
                        'status' => 'pending'
            ]);
            $project->save();

            // $request->session()->flush();

            $request->session()->put('new_estimate_id', $estimate->id);
            session(["projectObject" => $project]);
            return redirect('invoice/review');
            // return view('addclients')->with('estimate', $estimate->id);
        }
        return view('estimate.step4',$data);
    }

    public function step5(Request $request) {
        $data = [];
        $client = $request->all();
        $contacts = [];

        if ($request->contact) {
            foreach ($request->contact as $contact) {
                array_push($contacts, ["name" => $contact["'name'"], "email" => $contact["'email'"]]);
            }
            $contacts = $contacts;
        }
        if(empty($contacts[0]['email'])){
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', "Client Contact Email Can Not Be Empty.. Please Check Contact Information");
            return back();
        }

        $client['contacts'] = $contacts;
        session(['client' => $client]);

        DB::beginTransaction();
        try {
            // $client = new Client;
            // $estimate = new Estimate;
            if(!empty($contacts[0]['email'])){
                $emailcontact = $contacts[0]['email'];
            }
            else{
                $emailcontact = null;
            }


            $data['project'] = session('project')['project'];
            $data['company'] = session('client')['name'];
            $data['company_address'] = session('client')['street'] . session('client')['city'];
            $data['company_country'] = Country::find(session('client')['country_id'])->name;
            $data['issued_date'] = Carbon::now();
            $data['due'] = session('estimate')['end'];
            $data['currency'] = Currency::find(session('estimate')['currency_id'])->code;
            $data['currency_symbol'] = Currency::find(session('estimate')['currency_id'])->symbol;
            $data['lancer_name'] = Auth::user()->name;
            $data['workmanship'] = session('estimate')['price_per_hour'] * session('estimate')['time'];
            $data['equipment_cost'] = session('estimate')['equipment_cost'];
            $data['sub_contractors_cost'] = session('estimate')['sub_contractors_cost'];
            $data['total'] = $data['workmanship'] + $data['equipment_cost'] + $data['sub_contractors_cost'];

            $clients = new Client;
            $clients->user_id = Auth::user()->id;
            $clients->name = session('client')['name'];
            $clients->email = $emailcontact;
            $clients->street = session('client')['street'];
            $clients->street_number = session('client')['street_number'];
            $clients->city = session('client')['city'];
            $clients->country_id = session('client')['country_id'];
            $clients->state_id = session('client')['state_id'];
            $clients->zipcode = session('client')['zipcode'];
            $clients->contacts = session('client')['contacts'];
            $clients->save();

            // Estimate ID set to 1 because an estimate must not have a project
            $estimate = Estimate::create(array_merge(session('estimate'), ['estimate' => $data['total'], 'user_id' => Auth::user()->id]));

            $project = Project::create([
                        'title' => $data['project'],
                        'user_id' => Auth::user()->id,
                        'estimate_id' => $estimate->id,
                        'client_id' => $clients->id,
                        'tracking_code' => random_int(10, 100000),
                        'progress' => 0,
                        //'sub_contractors' => session('estimate')['sub_contractors'],
                        'status' => 'pending'
            ]);
            $project->save();
            // $client = Client::create(array_merge(session('client'), ['user_id'=>Auth::user()->id]) );
            // $invoice = Invoice::create([
            //     'project_id' => $project->id,
            //     'issue_date' => $data['issued_date'],
            //     'due_date' => $data['due'],
            //     'amount' => $data['total'],
            //     'estimate_id' =>  $estimate->id,
            //     'amount_paid' =>  0,
            //     'currency_id' => session('estimate')['currency_id'],
            //     'status' => 'unpaid'
            // ]);
            // $data['invoice_no'] = $invoice->id;
            // $invoice->save();
            DB::commit();

            // $request->session()->flush();
            $request->session()->put('new_estimate_id', $estimate->id);
            session(["projectObject" => $project]);
            return redirect('invoice/review');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
            DB::rollback();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'project_id' => 'required|numeric',
            'time' => 'required|numeric',
            'price_per_hour' => 'required|numeric',
            'equipment_cost' => 'nullable|numeric',
            'sub_contractors' => 'nullable|string',
            'sub_contractors_cost' => 'nullable|numeric',
            'similar_projects' => 'required|numeric',
            'rating' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        $estimateCost = ($request->input('price_per_hour') * $request->input('time')) + $request->equipment_cost + $request->sub_contractors_cost;

        $estimate = Estimate::create($request->all() + ['estimate' => $estimateCost]);

        if ($estimate) {
            return $this->SUCCESS("estimate created", $estimate);
        }

        return $this->ERROR('Estimate creation failed');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estimate $estimate) {

        $request->validate([
            'project_id' => 'required|numeric',
            'time' => 'required|numeric',
            'price_per_hour' => 'required|numeric',
            'equipment_cost' => 'nullable|numeric',
            'sub_contractors' => 'nullable|string',
            'sub_contractors_cost' => 'nullable|numeric',
            'similar_projects' => 'required|numeric',
            'rating' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        $estimate = Estimate::where('project_id', $request->input('project_id'))->first();

        if ($estimate) {
            $estimateCost = $request->input('price_per_hour') * $request->input('time');
            $estimate->update($request->all() + ['estimate' => $estimateCost]);
            return $this->SUCCESS($estimate);
        }

        return $this->ERROR('Estimate not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estimate $estimate) {
        if ($estimate = Estimate::find($estimate->id)) {
            $estimate->delete();
            return $this->SUCCESS('Estimate Deleted');
        }
        return $this->ERROR('Estimate deletion failed');
    }

}
