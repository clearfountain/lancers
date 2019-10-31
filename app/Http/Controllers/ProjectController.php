<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Project;
use App\Client;
use App\Country;
use App\State;
use App\Estimate;
use App\Rules\IsUser;
use PDF;
use Illuminate\Http\Request;
use App\Currency;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller {

    /**
     * NEW PROJECT IMPLEMENTATION STARTS
     */
    public function listGet() {
        $filter = Request()->filter;
        if ($filter == 'pending') {
            $data['projects'] = Project::whereUser_id(Auth::user()->id)->whereStatus('pending')->with('user')->get();
        } elseif ($filter == 'active') {
            $data['projects'] = Project::whereUser_id(Auth::user()->id)->whereStatus('active')->with('user')->get();
        } elseif ($filter == 'completed') {
            $data['projects'] = Project::whereUser_id(Auth::user()->id)->whereStatus('completed')->with('user')->get();
        } else {
            $data['projects'] = Project::whereUser_id(Auth::user()->id)->with('user')->get();
        }

        //dd($data);
        return view('projects.list', $data);
    }

    public function edit($id) {
        $data['currencies'] = Currency::all('id', 'code');
        $data['clients'] = Client::all();
        $data['countries'] = Country::all('id', 'name');
        $data['states'] = State::all();
        $data['projects'] = Project::whereUser_id(Auth::user()->id)->with('user')->find($id);
        return view('projects.edit', $data);
    }

    public function view($id) {

        $data['projects'] = Project::whereUser_id(Auth::user()->id)->with('user')->find($id);
        return view('projects.view', $data);
    }

    public function complete($id) {
        $project = Project::whereUser_id(Auth::user()->id)->with('user')->find($id);
        $project->update([
            'status' => 'completed'
        ]);

        session()->flash('message.alert', 'success');
        session()->flash('message.content', "Project Successfully Completed");
        return back();
    }

    public function pending($id) {
        $project = Project::whereUser_id(Auth::user()->id)->with('user')->find($id);
        $project->update([
            'status' => 'pending'
        ]);

        session()->flash('message.alert', 'success');
        session()->flash('message.content', "Project Successfully Put to Pending");
        return back();
    }

    public function delete($id) {
        $project = Project::whereUser_id(Auth::user()->id)->with('user')->find($id);
        $estimate = Estimate::find($project->estimate_id);
        $estimate->delete();
        session()->flash('message.alert', 'success');
        session()->flash('message.content', "Project Successfully Deleted");
        return back();
    }

    /**
     * NEW PROJECT IMPLEMENTATION ENDS
     */
    public function index() {
        $user = Auth::user();

        $projects = $user->projects()->select('id', 'title', 'status', 'created_at')->with(['estimate:project_id,start,end,estimate', 'invoice:project_id,amount,amount_paid'])->get();

        // return $projects, and not json verified by @BlinShine
        if ($projects) {
            return $this->SUCCESS("Projects retrieved", $projects);
        }
        return $this->ERROR('no Project Found');
    }

    public function userProjects() {
        $user = Auth::user();

        $projects = $user->projects()->select('id', 'title')->get()->toArray();

        // return $projects, instead of json verified by @BlinShine
        if ($projects) {
            return $this->SUCCESS("Projects retrieved", $projects);
        }
        return $this->ERROR('no project Found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $user = Auth::user();

        $data = [
            'title' => $request->title,
            'tracking_code' => Project::generateTrackingCode()
        ];

        if (isset($request->description)) {
            $data['description'] = $request->description;
        }

        $project = $user->projects()->create($data);

        return $this->success("project created", $project, $code = 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        $user_id = Auth::id();

        if ($project->user_id == $user_id) {
            return $this->success("Projects retrieved", $project, 201);
        } else {
            return $this->error("Project not found", [], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $project = Project::whereUser_id(Auth::user()->id)->with('user')->find($id);
        $project->update([
            'title' => $request->title,
            'client_id' => $request->client
        ]);
        $estimate = Estimate::find($project->estimate_id);

        $workmanship = $request->time;
        $equipment_cost = $request->equipment_cost;
        $sub_contractors_cost = $request->sub_contractors_cost;
        $total = $workmanship + $equipment_cost + $sub_contractors_cost;

        $estimate->update([
            'time' => $request->time,
            'currency_id' => $request->currency_id,
            'equipment_cost' => $request->equipment_cost,
            'sub_contractors' => $request->sub_contractors,
            'sub_contractors_cost' => $request->sub_contractors_cost,
            'similar_projects' => $request->similar_projects,
            'rating' => $request->rating,
            'estimate' => $total,
            'start' => $request->start,
            'end' => $request->end
        ]);
        session()->flash('message.alert', 'success');
        session()->flash('message.content', "Project Updated");
        return redirect('project/status');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($project) {
        if ($project = Project::find($project)) {
            $user = Auth::user();

            if ($project->user_id == $user->id) {
                $project->delete();
            }

            return $this->SUCCESS("project deleted", null, $code = 204);
        } else {
            return $this->error("project not found");
        }
    }

    public function collaborators(Project $project) {
        $user_id = Auth::id();

        if ($user_id == $project->user_id) {
            $team = $project->collaborators ?? [];

            // fetch all the team mates as users with profile_picture, name
            $people = array_column($team, "user_id");
            $people = User::whereIn('id', $people)->select('id', 'name', 'profile_picture')->get()->toArray();

            // add profile profile_picture name to main data
            foreach ($people as $key => $person) {

                $people[$key]["designation"] = $team[$key]["designation"];
            }

            return $this->success("collaborators retrieved", $people);
        } else {
            return $this->error("You are not authorized to view this collaborators", [], 401);
        }
    }

    public function allCollaborators() {
        $user = Auth::user();

        $team = $user->projects()->select('title', 'collaborators')->get()->map(function($val) {
            $people = array_column($val->collaborators, "user_id");
            $people = User::whereIn('id', $people)->select('id', 'name', 'profile_picture')->get()->toArray();

            foreach ($people as $key => $person) {
                $people[$key]['designation'] = $val->collaborators[$key]['designation'];
                $people[$key]['project'] = $val->title;
            }

            return $people;
        });

        return $this->success("collaborators retrieved", $team);
    }

    public function addCollaborator(Request $request, Project $project) {
        $user_id = Auth::id();

        if ($user_id == $project->user_id) {
            $team = $project->collaborators ?? [];
            $request->validate([
                'user_id' => ['required', 'integer', new IsUser],
                'designation' => 'required|string',
            ]);

            $user = Auth::user();
            // dd($user->subscription);
            $max_collaborators = $user->subscription->subscriptionPlan->features['collaborators'];

            if (count($team) >= $max_collaborators) {
                return $this->ERROR("You can only add $max_collaborators collaborators", $code = 412);
            }

            if (in_array($request->user_id, array_column($team, "user_id"))) {
                return $this->error("collaborator already exists", []);
            }

            array_push($team, [
                'user_id' => $request->input('user_id'),
                'designation' => $request->input('designation')
            ]);


            $project = $project->update(['collaborators' => $team]);
            // this wont work due to json to array cast
            // $project->collaborators = $team;
            // $project->save();

            return $this->SUCCESS("collaborator added", $project);
        } else {
            return $this->error("Not authorized", [], 401);
        }
    }

    public function deleteCollaborator(Project $project, $user) {
        $user_id = Auth::id();

        if ($user_id == $project->user_id) {
            $collaborators = $project->collaborators ?? [];

            if (in_array($user, array_column($collaborators, "user_id"))) {
                // return "here x";
                $place = array_search($user, array_column($collaborators, "user_id"));

                unset($collaborators[$place]);

                $collaborators = array_values($collaborators);

                $project->update(['collaborators' => $collaborators]);

                return $this->success("collaborator removed", null, 204);

                // return $this->success("collaborator removed", [] , 204);
            } else {
                return $this->error("collaborator not found", [], 404);
            }
        } else {
            return $this->error("Not authorized", [], 401);
        }
    }
    
    /* Track Project */
    
    public function acceptproject(){ 
        return view('trackproject');
    }
    
    public function selectproject(Request $request){
        $projectid = $request->input('projectid');
        return redirect('guest/track/'.$projectid);
    }
    
    public function showproject($trackCode){
        
        if(is_numeric($trackCode) ) {
          if(Project::where('tracking_code',$trackCode)->first()){
            $docData = [];
            //$projectData = Project::where('tracking_code',$pid)->get();
            $projectData = Project::where('tracking_code',$trackCode)->with('user','client','profile')->get();
            
            if(isset($projectData[0]->client->country_id)){
                $country_id = $projectData[0]->client->country_id;
                $cCountry = Country::where('id',$country_id)->get('name');
                $clientCountry = $cCountry[0]->name;
                $docData += compact("clientCountry");
            }
            
            if(isset($projectData[0]->client->state_id)){
                $state_id = $projectData[0]->client->state_id;
                $cState = State::where(['id'=>$state_id,'country_id'=>$country_id])->get('name');
                $clientState = $cState[0]->name;
                $docData += compact("clientState");
                
            }
            
            if(isset($projectData[0]->profile->country_id)){
                $country_id = $projectData[0]->profile->country_id;
                $lCountry = Country::where('id',$country_id)->get('name');
                $lancerCountry = $lCountry[0]->name;
                $docData += compact("lancerCountry");
                
            }
            
            if(isset($projectData[0]->profile->state_id)){
                $state_id = $projectData[0]->profile->state_id;
                $lState = State::where(['id'=>$state_id,'country_id'=>$country_id])->get('name');
                $lancerState = $lState[0]->name;
                $docData += compact("lancerState");
                
            }
            
            $currencySymbol = ($projectData[0]->estimate->invoice->currency['symbol']);
            //$currencySymbol = $projectData[0]->estimate[0]->invoice['currency']['symbol'];
            //$docData = compact("clientCountry","clientState","lancerCountry","lancerState");
            //$projectData = Project::with('user')->get();
            //$clientId = $projectData[0]->client_id;
        //$clientName = $projectData[0]->client->contacts[0]->name;
        //$clientName = dd($projectData[0]->client->contacts[0]['name']);
            //$estimateId = $projectData[0]->estimate_id;
            //return $projectData.'<br>'.$userId.'<br>'.$clientId.'<br>'.$estimateId.'<br>';
            //return $projectData;
            //return $clientName;
            $projectName = $projectData[0]->title;
            
            $lancerName = $projectData[0]->user->name;
            $lancerMail = $projectData[0]->user->email;
               
            if(isset($projectData[0]->description)){
                $projectDescription = $projectData[0]->description;
                $docData += compact("projectDescription");
            }
              
            if(isset($projectData[0]->profile->company_address)){
                $lancerAddress = $projectData[0]->profile->company_address;
                $docData += compact("lancerAddress");
            }
              
            if(isset($projectData[0]->profile->street_number)){
                $lancerStreetNum = $projectData[0]->profile->street_number;
                $docData += compact("lancerStreetNum");
            }
              
            if(isset($projectData[0]->profile->street)){
                $lancerStreet = $projectData[0]->profile->street;
                $docData += compact("lancerStreet");
            }
              
            if(isset($projectData[0]->profile->city)){
                $lancerCity = $projectData[0]->profile->city;
                $docData += compact("lancerCity");
            }
              
            if(isset($projectData[0]->client->street_number)){
                $clientStreetNum = $projectData[0]->client->street_number;
                $docData += compact("clientStreetNum");
            }
              
            if(isset($projectData[0]->client->street)){
                $clientStreet = $projectData[0]->client->street;
                $docData += compact("clientStreet");
            }
            if(isset($projectData[0]->client->city)){
                $clientCity = $projectData[0]->client->city;
                $docData += compact("clientCity");
            }
            
            if(isset($projectData[0]->client->name)){
                $clientName = $projectData[0]->client->name;
                $docData += compact("clientName");
            }
              
            if(isset($projectData[0]->client->email)){
                $clientMail = $projectData[0]->client->email;
                $docData += compact("clientMail");
            }
              
            if(isset($projectData[0]->estimate->start)){
                $issueDate = $projectData[0]->estimate->start;
                $docData += compact("issueDate");
            }
              
            if(isset($projectData[0]->estimate->end)){
                $dueDate = $projectData[0]->estimate->end;
                $docData += compact("dueDate");
            }
              
            if(isset($projectData[0]->estimate->time)){
                $time = $projectData[0]->estimate->time;
                $docData += compact("time");
            }
              
            if(isset($projectData[0]->estimate->price_per_hour)){
                $pricePerHour = $projectData[0]->estimate->price_per_hour;
                $docData += compact("pricePerHour");
            }
              
            if(isset($projectData[0]->estimate->equipment_cost)){
                $equipmentCost = $projectData[0]->estimate->equipment_cost;
                $docData += compact("equipmentCost");
            }
              
            if(isset($projectData[0]->estimate->sub_contractors_cost)){
                $subContractorCost = $projectData[0]->estimate->sub_contractors_cost;
                $docData += compact("subContractorCost");
            }
              
            if(isset($projectData[0]->estimate['estimate'])){
                $amount = $projectData[0]->estimate['estimate'];
                $docData += compact("amount");
            }
            //$issueDate = dd($projectData[0]->estimate->start);
            //$dueDate = $projectData[0]->estimate[0]->end;
            $docData += compact("currencySymbol","projectName","lancerName","lancerMail","trackCode");
            //$data += [$category => $question];
            //$docData += $dData;
            //array_push($docData,$dData);
            //return $docData;
            return view('client-doc-view')->with('docData',$docData);
          } else {
            return view('errors.404');
        }
        } else {
            return view('errors.404');
        }
        //return view('client-doc-view');
    }
    
    public function dynamicPDF($trackCode) {
        if(is_numeric($trackCode) ) {
          if(Project::where('tracking_code',$trackCode)->first()){
            $docData = [];
            
            $projectData = Project::where('tracking_code',$trackCode)->with('user','client','profile')->get();
            
            if(isset($projectData[0]->client->country_id)){
                $country_id = $projectData[0]->client->country_id;
                $cCountry = Country::where('id',$country_id)->get('name');
                $clientCountry = $cCountry[0]->name;
                $docData += compact("clientCountry");
            }
            
            if(isset($projectData[0]->client->state_id)){
                $state_id = $projectData[0]->client->state_id;
                $cState = State::where(['id'=>$state_id,'country_id'=>$country_id])->get('name');
                $clientState = $cState[0]->name;
                $docData += compact("clientState");
                
            }
            
            if(isset($projectData[0]->profile->country_id)){
                $country_id = $projectData[0]->profile->country_id;
                $lCountry = Country::where('id',$country_id)->get('name');
                $lancerCountry = $lCountry[0]->name;
                $docData += compact("lancerCountry");
                
            }
            
            if(isset($projectData[0]->profile->state_id)){
                $state_id = $projectData[0]->profile->state_id;
                $lState = State::where(['id'=>$state_id,'country_id'=>$country_id])->get('name');
                $lancerState = $lState[0]->name;
                $docData += compact("lancerState");
                
            }
              
            $currencySymbol = ($projectData[0]->estimate->invoice->currency['symbol']);
            //$currencySymbol = $projectData[0]->estimate[0]->invoice['currency']['symbol'];
            //$docData = compact("clientCountry","clientState","lancerCountry","lancerState");
            //$projectData = Project::with('user')->get();
            //$clientId = $projectData[0]->client_id;
        //$clientName = $projectData[0]->client->contacts[0]->name;
        //$clientName = dd($projectData[0]->client->contacts[0]['name']);
            //$estimateId = $projectData[0]->estimate_id;
            //return $projectData.'<br>'.$userId.'<br>'.$clientId.'<br>'.$estimateId.'<br>';
            //return $projectData;
            //return $clientName;
            $projectName = $projectData[0]->title;
            
            $lancerName = $projectData[0]->user->name;
            $lancerMail = $projectData[0]->user->email;
               
            if(isset($projectData[0]->description)){
                $projectDescription = $projectData[0]->description;
                $docData += compact("projectDescription");
            }
              
            if(isset($projectData[0]->profile->company_address)){
                $lancerAddress = $projectData[0]->profile->company_address;
                $docData += compact("lancerAddress");
            }
              
            if(isset($projectData[0]->profile->street_number)){
                $lancerStreetNum = $projectData[0]->profile->street_number;
                $docData += compact("lancerStreetNum");
            }
              
            if(isset($projectData[0]->profile->street)){
                $lancerStreet = $projectData[0]->profile->street;
                $docData += compact("lancerStreet");
            }
              
            if(isset($projectData[0]->profile->city)){
                $lancerCity = $projectData[0]->profile->city;
                $docData += compact("lancerCity");
            }
              
            if(isset($projectData[0]->client->street_number)){
                $clientStreetNum = $projectData[0]->client->street_number;
                $docData += compact("clientStreetNum");
            }
              
            if(isset($projectData[0]->client->street)){
                $clientStreet = $projectData[0]->client->street;
                $docData += compact("clientStreet");
            }
            if(isset($projectData[0]->client->city)){
                $clientCity = $projectData[0]->client->city;
                $docData += compact("clientCity");
            }
            
            if(isset($projectData[0]->client->name)){
                $clientName = $projectData[0]->client->name;
                $docData += compact("clientName");
            }
              
            if(isset($projectData[0]->client->email)){
                $clientMail = $projectData[0]->client->email;
                $docData += compact("clientMail");
            }
              
            if(isset($projectData[0]->estimate->start)){
                $issueDate = $projectData[0]->estimate->start;
                $docData += compact("issueDate");
            }
              
            if(isset($projectData[0]->estimate->end)){
                $dueDate = $projectData[0]->estimate->end;
                $docData += compact("dueDate");
            }
              
            if(isset($projectData[0]->estimate->time)){
                $time = $projectData[0]->estimate->time;
                $docData += compact("time");
            }
              
            if(isset($projectData[0]->estimate->price_per_hour)){
                $pricePerHour = $projectData[0]->estimate->price_per_hour;
                $docData += compact("pricePerHour");
            }
              
            if(isset($projectData[0]->estimate->equipment_cost)){
                $equipmentCost = $projectData[0]->estimate->equipment_cost;
                $docData += compact("equipmentCost");
            }
              
            if(isset($projectData[0]->estimate->sub_contractors_cost)){
                $subContractorCost = $projectData[0]->estimate->sub_contractors_cost;
                $docData += compact("subContractorCost");
            }
              
            if(isset($projectData[0]->estimate['estimate'])){
                $amount = $projectData[0]->estimate['estimate'];
                $docData += compact("amount");
            }
            //$issueDate = dd($projectData[0]->estimate->start);
            //$dueDate = $projectData[0]->estimate[0]->end;
            $docData += compact("currencySymbol","projectName","lancerName","lancerMail","trackCode");
            
            
        // Fetch all customers from database
        //$data = Customer::get();
    
        // Send data to the view using loadView function of PDF facade
        //$pdf = PDF::loadView('pdf.customers', $data);
        $pdf = PDF::loadView('pdf.trackproject',$docData);
        
        // If you want to store the generated pdf to the server then you can use the store function
        //$pdf->save(storage_path().'_filename.pdf');
    
        // Finally, you can download the file using download function
        return $pdf->download('Invoice.pdf');
    }else {
            return view('errors.404');
        }
            
  } else {
      return view('errors.404');
    }
 } 

}
