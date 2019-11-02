<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\State;
use App\Client;
use App\Project;
use App\Country;
use App\Estimate;
use Illuminate\Http\Request;

class ClientController extends Controller {

    public function show() {
        $countries = Country::all('id', 'name');
        $states = State::all('id', 'name');
        return view('clients.add')->withCountries($countries)->withStates($states);
    }

    public function store(Request $request) {
        $contacts = [];

        // dd($request->contact);
        if ($request->contact) {
            foreach ($request->contact as $contact) {
                array_push($contacts, ["name" => $contact["name"], "email" => $contact["email"]]);
            }
        }
        if (!empty($contacts[0]['email'])) {
            $emailcontact = $contacts[0]['email'];
            $contacts = json_encode($contacts);
        } else {
            $emailcontact = null;
        }

        try {
            $client = new Client;
            $client->user_id = Auth::user()->id;
            $client->name = $request->name;
            $client->email = $emailcontact;
            $client->street = $request->street;
            $client->street_number = $request->street_number;
            $client->city = $request->city;
            $client->country_id = $request->country_id;
            $client->state_id = $request->state_id;
            $client->zipcode = $request->zipcode;
            if (gettype($contacts) == 'string') {
                $client->contacts = $contacts;
            };

            if ($client->save()) {
                return back()->with('success', 'New client created');
                // return $this->SUCCESS('New client created', $data);
            }
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
            // return $this->ERROR('Client creation failed');
        }
    }


    public function delete($client) {
        $client = Client::findOrFail($client);

        $user_id = auth()->id();

        if($client->user_id !== $user_id){
            return back()->with('error', 'You are not authorized to delete this client');
        }else{
            $client->delete();

            return back()->with('success', 'Client deleted');
        }
    }

    public function listGet(Request $request) {
        $user = Auth::user()->id;
        if ($request->filter == 'pending') {
            $data['clients'] = Client::whereUser_id($user)->with(["projects" => function($q) {
                            $q->where('projects.status', '=', 'pending');
                        }])->orderBy('created_at', 'DESC')->get();
        } elseif ($request->filter == 'completed') {
            $data['clients'] = Client::whereUser_id($user)->with(["projects" => function($q) {
                            $q->where('projects.status', '=', 'completed');
                        }])->orderBy('created_at', 'DESC')->get();
        } else {
            $data['clients'] = Client::whereUser_id($user)->with('projects')->orderBy('created_at', 'DESC')->get();
        }
		//dd($data);
        return view('clients.list', $data);
    }

    
    public function view($client_id) {
        $client = Client::where(['id' => $client_id, 'user_id' => Auth::user()->id])->first();
        return $client !== null ? $this->SUCCESS('Client retrieved', $client) : $this->SUCCESS('No client found');
    }
    
    public function viewClient($client_id) {
        $clientData = [];
        if(Client::where(['id' => $client_id, 'user_id' => Auth::user()->id])->first()){
            $clientData = Client::where(['id' => $client_id, 'user_id' => Auth::user()->id])->first()->toArray();
            if(isset($clientData['country_id'])){
                $country_id = $clientData['country_id'];
                $country = Country::where('id',$country_id)->get('name')->toArray();
                $clientCountry = $country[0]['name'];
                $clientData += compact("clientCountry");
            }
            
            if(isset($clientData['state_id'])){
                $state_id = $clientData['state_id'];
                $state = State::where(['id'=>$state_id,'country_id'=>$country_id])->get('name');
                $clientState = $state[0]['name'];
                $clientData += compact("clientState");
                
            }
            return view('client-info')->with('clientData',$clientData);
            //return $clientData;
        } else {
            $error = "User not found";
            $clientData += compact("error");
            return view('client-info')->with('clientData',$clientData);
        }
    }

    public function edit($client)
    {
        $client = Client::findOrFail($client);


        return view('clients.edit')->with('client', $client);
    }

    public function update(Request $request) {

        $this->validate($request, [
            'client_id' => 'numeric|required',
            'name' => 'required|string',
            'street' => 'nullable|string',
            'street_number' => 'nullable|numeric',
            'city' => 'nullable|string',
            'country_id' => 'nullable|numeric',
            'state_id' => 'nullable|numeric',
            'zipcode' => 'nullable|numeric',
            'contact' => 'required|array',
            'contact.0.email' => 'required|email',
            'contact.0.name' => 'required|string',
        ]);

        $client = Client::findOrFail($request->client_id);

        $inputs = $request->input();

        $contacts = [];
        if ($request->contact) {
            foreach ($request->contact as $contact) {
                array_push($contacts, ["name" => $contact["name"], "email" => $contact["email"]]);
            }
        }
        if (!empty($contacts[0]['email'])) {
            $emailcontact = $contacts[0]['email'];
            $inputs['email'] = $emailcontact;

            $contacts = json_encode($contacts);
            $inputs['contacts'] = $contacts;
        } else {
            $emailcontact = null;
        }


        $data = ['name', 'email', 'street', 'street_number', 'city', 'country_id', 'state_id', 'zipcode', 'contacts'];

        $to_save = [];

        foreach ($data as $value) {
            if(isset($inputs[$value]) && !empty($inputs[$value])){
                $to_save[$value] = $inputs[$value];
            }
        }

        try {

            $client->update($to_save);
            return back()->with('success', 'Client details updated');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

    }

}
