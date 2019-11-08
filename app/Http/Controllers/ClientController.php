<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\State;
use App\Client;
use App\Project;
use App\Country;
use App\Estimate;
Use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


class ClientController extends Controller {

    public function show() {
        $countries = Country::all('id', 'name');
        $states = State::all('id', 'name');
        return view('clients.add')->withCountries($countries)->withStates($states);
    }

    public function getClientName($client_id)
    {
        $clientName = Client::where('id',$client_id)->get();
        if($clientName != null){return response()->json($clientName->toArray());}else{return response()->json("");}

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
        } else {
            $emailcontact = null;
        }

        try {
            // $client = new Client;
            // $client->user_id = Auth::user()->id;
            // $client->name = $request->name;
            // $client->email = $emailcontact;
            // $client->street = $request->street;
            // $client->street_number = $request->street_number;
            // $client->city = $request->city;
            // $client->country_id = $request->country_id;
            // $client->state_id = $request->state_id;
            // $client->zipcode = $request->zipcode;
            // if (gettype($contacts) == 'string') {
            //     $client->contacts = $contacts;
            // };

            $client = Auth::user()->clients()->create(['name' => $request->name, 'email' => $emailcontact, 'street' => $request->street, 'street_number' => $request->street_number, 'city' => $request->city, 'country_id' => $request->country_id, 'state_id' => $request->state_id, 'zipcode' => $request->zipcode, 'contacts' => $contacts]);

            if ($client) {
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

            return redirect('/clients')->with('success', 'Client deleted');
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
            return view('clients.client-info')->with('clientData',$clientData);
            //return $clientData;
        } else {
            $error = "User not found";
            $clientData += compact("error");
            return view('clients.client-info')->with('clientData',$clientData);
        }
    }

    public function edit($client)
    {
        $client = Client::findOrFail($client);
        $countries = Country::all('id', 'name');

        $states = State::where("country_id",$client->country_id)->get();
        //dd($client);

        return view('clients.edit')->with(['client'=> $client,'countries'=>$countries,'states'=>$states]);

    }


    public function update(Request $request) {
        $image = $request->file('profileimage');

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

        $storedImageStatus = null;
        //upload image and return to invoices.

        if($image != null)
        {


            $imageStatus = $this->updateImage($request,$client->id);

            $storedImageStatus = $imageStatus;

              //check image return value and act accordingly
            if($storedImageStatus == false)
            {

            //return back with error if any error
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', "Error uploading image, Please Try again ");
            return back();
            }
        }



        $contacts = [];
        if ($request->contact) {
            foreach ($request->contact as $contact) {
                array_push($contacts, ["name" => $contact["name"], "email" => $contact["email"]]);
            }
        }
        if (!empty($contacts[0]['email'])) {
            $emailcontact = $contacts[0]['email'];
            $inputs['email'] = $emailcontact;


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

            $clientUpdate = $client->update($to_save);

            return back()->with('success', 'Client details updated');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

    }




       //UPLOAD IMAGE CODE
        // @author: @Bits_and_Bytes
        function ImageValidation(array $array)
        {
            return Validator::make($array, [
                'profileimage'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
        }

        /**
         * @description receive user upload photo and update picture
         * @param Request $request
         * @author: @Bits_and_Bytes
         */
        // CHANGE ALL DB TABLE SAVES TO THE CORRECT ONE WITH INVOICE...
        // @author: @Bits_and_Bytes
        function updateImage($request,$clientId)
        {
            $imageValidate = $this->ImageValidation(['profileimage' => $request->file('profileimage')]);

            if(!$imageValidate->fails())
            {
              //check if user has image
              $clientProfileData = Client::where('id',$clientId)->first();

              if($clientProfileData != null)
              {
                  //cast collection result to array
                  $collectionResult = $clientProfileData->toArray();

                  if(sizeof($collectionResult) != 0)
                  {  //upload image and update image field only

                      //get profile image
                        $oldImage = $collectionResult['profile_picture'];
                        //dd($oldImage);
                        if($oldImage != null)
                        {
                            // check if user has image and unlink
                            if(file_exists(public_path($oldImage)))
                            {
                                unlink(public_path($oldImage));
                            }

                        }


                        $imagePathString = $this->uploadImageToFile($request->file('profileimage'));
                        //store in DB

                        $clientProfileData->profile_picture = $imagePathString;
                        $clientProfileData->save();

                        if($clientProfileData->profile_picture == $imagePathString)
                        {

                            return true;
                        }
                        else{
                            return false;
                        }

                 }else{
                    return false;
                 }


              }
              else
              {
                return false;
            }


            }
            else{
               return false;
            }
        }




        public function uploadImageToFile(UploadedFile $uploadedFile,  $Imagefilename = null, $folderName = null, $appDiskStorage = null)
        {
            $folderName = (!is_null($folderName)) ? $folderName : 'images/ClientImages';
            $appDiskStorage = (!is_null($appDiskStorage)) ? $appDiskStorage : 'public';
            $imageName = (!is_null($Imagefilename)) ? $Imagefilename : md5(auth()->user()->id.now());

            $filePath = $uploadedFile->storeAs($folderName, $imageName.'.'.$uploadedFile->getClientOriginalExtension(), $appDiskStorage);

            return $filePath;
        }

        //Search functionality for clients
         // $posts = Client::where('','', $search)-->paginate();
            // State::where("country_id",$client->country_id)->get();
        public function search (Request $request) {
            $user = Auth::user()->id;
            $search = $request->get('search');
        //    $clients = DB::table('clients')->where('name','created_at', '%'.$search.'%')->paginate(5);
           
            $clients['data'] = Client::whereUser_id($user)->with(["projects"])->get();
            $clientSearch= array();
            $count=0;
                foreach ($clients['data'] as $client) {
                    if ($client['name'] == $search) {
                        // dd($client['name'],$search);
                        // dd($client);
                        $count+=1;
                        // dd($count);
                        // $clientSearch = $client;
                        if($count==1){
                            // $clients['data'][0] = $client;
                            $clientSearch[0]= $client;
                        }else{
                            array_push($clientSearch, $client);
                            // dd($clientSearch);
                        }
                        
                      
                } if ($client['project']) {
                    foreach ($client['project'] as $project){
                        if ($project['title'] == $search){
                            // dd($project['title'], $search);
                        // dd($project);
                        // dd($clients);
                        // $clients['data'] = $client;
                        if($count==1){
                            $clientSearch[0]= $client;
                        }else{
                            array_push($clientSearch, $client);
                        }
                        }
                    };
                }
                //  else {
                //     $emailcontact = null;
                // }
            };
           

        // dd($clients[0]['name']);
        // dd($clients);
        // dd($clients[0]['project'][0]['title']);
        // dd($search);
        // dd($count);
        //    return view('clients.list', ['clients'=>$clients]);
           return view('clients.list', ['clients'=>$clientSearch]);
            }



}
