<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Auth\Events\Registered;
use App\User;
use App\Project;
use App\Estimate;
use App\Invoice;
use Response;
use Hash;
Use Validator;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Client;
use App\State;
use App\Country;
use App\Currency;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Estimate as EstimateResource;
use App\Http\Resources\EstimateCollection;
use App\Profile;
use App\Subscription;
use Illuminate\Foundation\Auth\RegistersUsers;

class GuestController extends Controller {

    // public $project;

    public function step1(Request $request) {
        $project = $request->session()->get('project');
        session(["path" => url('/')]);
        if (!$project) {
            return view('guests/step1');
        }

        // return view('guests/step1',compact('project', $project));
        return view('guests/step1');
    }

    public function createstep1(Request $request) {

        $validator = Validator::make($request->all(), [
                    'project_name' => 'required|string|max:255',
                    'description' => 'nullable|string'
        ]);





        if ($validator->fails()) {
            $message = implode("<br/>", $validator->messages()->all());
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', $message);
            return back();
        } else {

            $data = ["project_name" => $request->project_name,
                "description" => $request->description,
                'tracking_code' => Project::generateTrackingCode()
            ];

            if (empty($request->session()->get('project'))) {
                $request->session()->put('project', $data);
            } else {
                $project = $request->session()->get('project');
                $request->session()->put('project', $data);
            }

            return redirect('guest/create/step2/');
        }
    }

    public function createstep2(Request $request) {
        $data = session('project');
        $currencies = Currency::all('id', 'code');

        if ($data) {
            $project = Session::get('project');
            $request->session()->put('project', $project);
            return view('guests/step2')->with(['project' => $project, 'currencies' => $currencies]);
        }

        return redirect('guest/create/step1/')->with("error", "You need to create a project first");
    }

    public function savestep2(Request $request) {

        $project = Session::get('project');
        $request->session()->put('project', $project);

        // $validator = Validator::make($request->all(), [
        //     // 'project_id' => 'required|numeric',
        //     'time' => 'required|numeric',
        //     'price_per_hour' => 'required|numeric',
        //     'equipment_cost' => 'nullable|numeric',
        //     'sub_contractors' => 'nullable|string',
        //     'sub_contractors_cost' => 'nullable|numeric',
        //     'similar_projects' => 'required|numeric',
        //     'rating' => 'required|numeric',
        //     'currency_id' => 'required',
        //     'start' => 'required|date',
        //     'end' => 'required|date'
        // ]);
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // } else {
        $data = [
            'time' => $request->time,
            'price_per_hour' => $request->cost_per_hour,
            'equipment_cost' => $request->equipment_cost,
            'sub_contractors' => $request->sub_contractors,
            'sub_contractors_cost' => $request->sub_contractors_cost,
            'similar_projects' => $request->similar_projects,
            'rating' => $request->rating,
            'currency_id' => $request->currency_id,
            'start' => $request->start,
            'end' => $request->end
        ];


        $request->session()->put('guestestmate', $data);


        // $ddata = Session::all();
        //  dd($data);
        return redirect('guest/create/step3');
        // }
    }

    public function createstep3(Request $request) {
        $data = session('project');
        $countries = Country::all('id', 'name');
        $states = State::all('id', 'name');

        if ($data) {
            $estimate = Session::get('guestestmate');
            $project = Session::get('project');
            $request->session()->put('project', $project);
            $request->session()->put('guestestmate', $estimate);
            return view('guests/step4')->with(['project' => $project, 'guestestmate' => $estimate,
                        'countries' => $countries, 'states' => $states]);
        }

        return redirect('guest/create/step1/')->with("error", "You need to create a project first");
    }

    public function savestep3(Request $request) {
        $contacts = [];
        if ($request->contact) {
            foreach ($request->contact as $contact) {
                array_push($contacts, ["name" => $contact["'name'"], "email" => $contact["'email'"]]);
            }
            $contacts = $contact;
        }
        if (empty($contact["'email'"])) {
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', "Client Contact Email Can Not Be Empty.. Please Check Contact Information");
            return back();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'street' => $request->street,
            'street_number' => $request->street_number,
            'city' => $request->city,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'zipcode' => $request->zipcode,
        ];

        $project = Session::get('project');
        $estimate = Session::get('guestestmate');
        // session::put(['estimate' =>  $data]);
        $request->session()->put('guestestmate', $estimate);
        $request->session()->put('project', $project);
        $request->session()->put('client', $data);
        $request->session()->put('contacts', $contacts);

        return redirect('guest/create/step4');
    }

    public function createstep4(Request $request) {

        return view('guests/register');
    }

    public function savestep4(Request $request) {
        $data = [];
        $session_project = $request->session()->get('project');

        $session_contacts = $request->session()->get('contacts');
        $session_contactsq = $request->session()->get('contacts');


        if (!empty($session_contactsq["'email'"])) {
            $emailcontact = $session_contactsq["'email'"];
        } else {
            $emailcontact = null;
        }
        $data['workmanship'] = session('guestestmate')['price_per_hour'] * session('guestestmate')['time'];
        $data['equipment_cost'] = session('guestestmate')['equipment_cost'];
        $data['sub_contractors_cost'] = session('guestestmate')['sub_contractors_cost'];
        $data['total'] = $data['workmanship'] + $data['equipment_cost'] + $data['sub_contractors_cost'];
        $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            $message = implode("<br/>", $validator->messages()->all());
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', $message);
            return back();
        }
        $password = Hash::make($request->password);
        $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password
        ]);
        Auth::login($user);


        $clients = new Client;
        $clients->user_id = $user->id;
        $clients->name = session('client')['name'];
        $clients->email = $emailcontact;
        $clients->street = session('client')['street'];
        $clients->street_number = session('client')['street_number'];
        $clients->city = session('client')['city'];
        $clients->country_id = session('client')['country_id'];
        $clients->state_id = session('client')['state_id'];
        $clients->zipcode = session('client')['zipcode'];
        $clients->contacts = $session_contacts;
        $clients->save();

        $estimate = Estimate::create(array_merge(session('guestestmate'), ['estimate' => $data['total'], 'user_id' => $user->id]));

        $project = Project::create([
                    'title' => $session_project['project_name'],
					'estimate_id'=>$estimate->id,
                    'user_id' => $user->id,
                    'client_id' => $clients->id,
                    'tracking_code' => random_int(10, 100000),
                    'progress' => 0,
                    //'collaborators' => session('estimate')['sub_contractors'],
                    'status' => 'pending'
        ]);
        $project->save();



        return view('addclients')->with('estimate', $estimate->id);
    }

}
