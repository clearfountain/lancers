<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Client;
use App\Project;
use App\Invoice;
use App\Estimate;
use App\Country;
use App\State;
use Carbon\Carbon;
use App\Mail\SendInvoice;
use App\Mail\TrackingCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Storage;
use App\Traits\VerifyandStoreTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
Use Validator;

class InvoiceController extends Controller {

    use VerifyandStoreTransactions;

    public function view($id) {
        $invoice = Invoice::where('id', $id)->first();

        return view('invoice')->withInvoice($invoice);
    }

    public function edit($id) {
        $invoice = Invoice::where('id', $id)->first();
        $projects = Project::where('user_id', Auth::user()->id)->get(['id', 'title']);

        $users = User::all(['id', 'name']);
        return view('invoices.reviewinvoice')->withInvoice($invoice)->withProjects($projects)->withUsers($users);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'role' => 'required|string',
            'user_id' => 'required|numeric',
            'project_id' => 'required|numeric',
        ]);
        $query = Invoice::whereId($id)->FirstOrFail();
        $query->user_id = $request->user_id;
        $query->project_id = $request->project_id;
        $query->role = $request->role;
        if ($query->save()) {
            // $request->session()->flash('success', 'Invoice Added!');
            return back()->withSuccess('Update Successful');
        } else {
            // $request->session()->flash('errors', 'Invoice addtion failed!');
            return back()->withInputs()->withError('Unable to save your input');
        }
    }

    public function delete($id) {
        $object = Invoice::whereId($id)->first();
        if ($object) {
            $object->delete();
            return redirect()->back()->with('success', 'Invoice has been deleted');
        } else {
            return redirect()->back()->with('error', 'An error occur');
        }
    }

    public function __construct() {
        $this->middleware('auth');
    }

    public function review(Request $request) {
        $estimate_id = session('new_estimate_id');
        $projectObject = session("projectObject");


        if ($estimate_id && is_int($estimate_id)) {
            $estimate = Estimate::find($estimate_id);

            if ($estimate) {
                if ($estimate->invoice !== null) {
                    // $pre_invoice->update(['amount' => $estimate->estimate]);
                    $invoice = $estimate->invoice;
                } else {
                    $createinvoice = Invoice::create(['user_id' => Auth::user()->id, 'issue_date' => $estimate->start, 'due_date' => $estimate->end, 'estimate_id' => $estimate->id, 'amount' => $estimate->estimate, 'currency_id' => $estimate->currency_id]);
                    $invoice = Invoice::whereId($createinvoice->id)->with('estimate')->first();
                    $projectObject->invoice_id = $createinvoice->id;
                    $projectObject->save();
                }

                return view('invoices.reviewinvoice')->with('invoice', $invoice);
            } else
                return redirect('estimate/create');
        }else {
            return redirect('estimate/create');
        }

        return redirect('estimate/create');
    }

    public function send($id) {
        return view('invoice_sent');
    }

    public function index() {
        $user = Auth::user();

        // return $user->projects;

        $invoices = $user->projects()->select('id', 'title', 'client_id')->with(['client:id,name', 'invoice:id,project_id,amount,status,issue_date,created_at'])->get();

        foreach ($invoices as $key => $invoice) {
            if ($invoice->invoice == null) {
                unset($invoices[$key]);
            }

            if ($invoice->client_id == null) {
                unset($invoices[$key]);
            }
        }

        return view('invoices.invoicelist')->with('invoices', $invoices);
    }

    /**
     * Creates new record in the invoice table
     */
    public function store(Request $request) {

        $this->validate($request, [
            'estimate_id' => 'required|numeric'
        ]);

        $estimate = Estimate::find($request->estimate_id);

        $pre_invoice = Invoice::where('estimate_id', $request->estimate_id)->first();

        if (is_object($pre_invoice)) {
            $pre_invoice->update(['amount' => $estimate->estimate]);
            $invoice = $pre_invoice;
        } else {

            $createinvoice = Invoice::create(['user_id' => Auth::user()->id, 'issue_date' => $estimate->start, 'due_date' => $estimate->end, 'estimate_id' => $estimate->id, 'amount' => $estimate->estimate, 'currency_id' => $estimate->currency_id]);

            $invoice = $createinvoice;

            // $estimate->update(['invoice_id' => $createinvoice->id]);
            $estimate->project->update(['invoice_id' => $createinvoice->id]);
        }
        $createinvoice = Invoice::create(['user_id' => Auth::user()->id, 'issue_date' => $estimate->start, 'due_date' => $estimate->end, 'estimate_id' => $estimate->id, 'amount' => $estimate->estimate, 'currency_id' => $estimate->currency_id]);
        $invoice = Invoice::whereId($createinvoice->id)->with('estimate')->first();



        $invoice->estimate;
        // return $invoice;

        return view('invoices.reviewinvoice')->with('invoice', $invoice);
    }

    // public function delete(Request $request, $invoice) {
    //     $invoice = Invoice::findOrFail($invoice);
    //     $user = Auth::user();
    //     if ($invoice->project->user_id !== $user->id) {
    //         $request->session()->flash('error', "You're unauthorized to delete this invoice");
    //         return redirect()->back();
    //     } else {
    //         $request->session()->flash('status', 'Deleted');
    //         return redirect()->back();
    //     }
    // }

    public function show($invoice) {
        $pre_invoice = Invoice::findOrFail($invoice);
        // dd($invoice);

        $invoice = Project::where('invoice_id', $invoice)->select('id', 'title', 'estimate_id', 'client_id', 'invoice_id')->with(['estimate', 'invoice', 'client'])->first();

        // return $invoice;

        return view('invoices.viewinvoice')->with('invoice', $invoice);
    }

    public function listGet(Request $request) {
        if ($request->filter == 'paid') {
            $data['invoices'] = Invoice::whereUser_id(Auth::user()->id)->whereStatus('paid')->with('estimate')->with('currency')->get();
        } elseif ($request->filter == 'unpaid') {
            $data['invoices'] = Invoice::whereUser_id(Auth::user()->id)->whereStatus('unpaid')->with('estimate')->with('currency')->get();
        } else {
            $data['invoices'] = Invoice::whereUser_id(Auth::user()->id)->with('estimate')->with('currency')->get();
        }
        //dd($data);
        return view('invoices.list', $data);
    }

    public function getPdf($invoice) {
        $invoice = Invoice::findOrFail($invoice);

        $filename = "invoice#" . strtotime($invoice->created_at) . ".pdf";

        /* Retrieve, store and send data */
        $projectData = Project::where('invoice_id', $invoice->id)->with('user', 'client', 'profile')->get();

        $docData = [];

        if (isset($projectData[0]->client->country_id)) {
            $country_id = $projectData[0]->client->country_id;
            $cCountry = Country::where('id', $country_id)->get('name');
            $clientCountry = $cCountry[0]->name;
            $docData += compact("clientCountry");
        }

        if (isset($projectData[0]->client->state_id)) {
            $state_id = $projectData[0]->client->state_id;
            $cState = State::where(['id' => $state_id, 'country_id' => $country_id])->get('name');
            $clientState = $cState[0]->name;
            $docData += compact("clientState");
        }

        if (isset($projectData[0]->profile->country_id)) {
            $country_id = $projectData[0]->profile->country_id;
            $lCountry = Country::where('id', $country_id)->get('name');
            $lancerCountry = $lCountry[0]->name;
            $docData += compact("lancerCountry");
        }

        if (isset($projectData[0]->profile->state_id)) {
            $state_id = $projectData[0]->profile->state_id;
            $lState = State::where(['id' => $state_id, 'country_id' => $country_id])->get('name');
            $lancerState = $lState[0]->name;
            $docData += compact("lancerState");
        }

        $currencySymbol = ($projectData[0]->estimate->invoice->currency['symbol']);
        $invoiceColor = $projectData[0]->estimate->invoice->invoice_color;
        $projectName = $projectData[0]->title;
        $lancerName = $projectData[0]->user->name;
        $lancerMail = $projectData[0]->user->email;

        if (isset($projectData[0]->description)) {
            $projectDescription = $projectData[0]->description;
            $docData += compact("projectDescription");
        }

        if (isset($projectData[0]->profile->company_address)) {
            $lancerAddress = $projectData[0]->profile->company_address;
            $docData += compact("lancerAddress");
        }

        if (isset($projectData[0]->profile->street_number)) {
            $lancerStreetNum = $projectData[0]->profile->street_number;
            $docData += compact("lancerStreetNum");
        }

        if (isset($projectData[0]->profile->street)) {
            $lancerStreet = $projectData[0]->profile->street;
            $docData += compact("lancerStreet");
        }

        if (isset($projectData[0]->profile->city)) {
            $lancerCity = $projectData[0]->profile->city;
            $docData += compact("lancerCity");
        }

        if (isset($projectData[0]->client->street_number)) {
            $clientStreetNum = $projectData[0]->client->street_number;
            $docData += compact("clientStreetNum");
        }

        if (isset($projectData[0]->client->profile_picture)) {
            $profile_picture = $projectData[0]->client->profile_picture;
            $docData += compact("profile_picture");
        }

        if (isset($projectData[0]->client->street)) {
            $clientStreet = $projectData[0]->client->street;
            $docData += compact("clientStreet");
        }
        if (isset($projectData[0]->client->city)) {
            $clientCity = $projectData[0]->client->city;
            $docData += compact("clientCity");
        }

        if (isset($projectData[0]->client->name)) {
            $clientName = $projectData[0]->client->name;
            $docData += compact("clientName");
        }

        if (isset($projectData[0]->client->email)) {
            $clientMail = $projectData[0]->client->email;
            $docData += compact("clientMail");
        }

        if (isset($projectData[0]->estimate->start)) {
            $issueDate = $projectData[0]->estimate->start;
            $docData += compact("issueDate");
        }

        if (isset($projectData[0]->estimate->end)) {
            $dueDate = $projectData[0]->estimate->end;
            $docData += compact("dueDate");
        }

        if (isset($projectData[0]->estimate->time)) {
            $time = $projectData[0]->estimate->time;
            $docData += compact("time");
        }

        if (isset($projectData[0]->estimate->price_per_hour)) {
            $pricePerHour = $projectData[0]->estimate->price_per_hour;
            $docData += compact("pricePerHour");
        }

        if (isset($projectData[0]->estimate->equipment_cost)) {
            $equipmentCost = $projectData[0]->estimate->equipment_cost;
            $docData += compact("equipmentCost");
        }

        if (isset($projectData[0]->estimate->sub_contractors_cost)) {
            $subContractorCost = $projectData[0]->estimate->sub_contractors_cost;
            $docData += compact("subContractorCost");
        }

        if (isset($projectData[0]->estimate['estimate'])) {
            $amount = $projectData[0]->estimate['estimate'];
            $docData += compact("amount");
        }

        $docData += compact("currencySymbol", "invoiceColor", "projectName", "lancerName", "lancerMail");
        //   dd($docData);
        /* Send retieved data to view that will be used to generate PDF file, generate PDF file */
        $pdf = PDF::loadView('pdf.trackproject', $docData);

        /* Download PDF file */
        return $pdf->download('Invoice.pdf');
    }

    public function sendinvoice(Request $request) {
        $invoice_id = $request->invoice;
        $invoiceChecker = $request->invoiceChecker;
        $image = $request->file('profileimage');

        $invoiceVal = Invoice::findOrFail($invoice_id);
        $invoiceVal->invoice_color = $request->invoiceClr;
        $invoiceVal->save();

        if ($invoiceChecker == null) {

            session()->flash('message.alert', 'danger');
            session()->flash('message.content', "Error handling invoice, Please Try again ");
            return back();
        }

        if ($invoiceChecker == "saveInvoice") {
            $invoice = Invoice::with('estimate')->findOrFail($invoice_id);

            if ($image != null) {
                $invoice = Invoice::with('estimate')->findOrFail($invoice_id);
                //saveInvoice
                $project_name = $invoice->estimate->project->title;

                $client = $invoice->estimate->project->client;

                $client_id = $client->id;

                $storedImageStatus = "null";
                //upload image and return to invoices.

                $imageStatus = $this->updateImage($request, $client_id);

                $storedImageStatus = $imageStatus;

                //check image return value and act accordingly
                if ($storedImageStatus == false) {

                    //return back with error if any error
                    session()->flash('message.alert', 'danger');
                    session()->flash('message.content', "Error uploading image, Please Try again ");
                    return back();
                }

                //return to invoices with success or error
                return redirect("/invoices");
            }

            if ($image == null) {
                return redirect("/invoices");
            }
        }




        if ($invoiceChecker == "sendInvoice") {

            $invoice = Invoice::with('estimate')->findOrFail($invoice_id);
            //saveInvoice
            $project_name = $invoice->estimate->project->title;

            $client = $invoice->estimate->project->client;

            $client_email = $client->email;
            $client_id = $client->id;

            $storedImageStatus = "null";

            if ($image != null) {
                //upload image and return to invoices.
                $imageStatus = $this->updateImage($request, $client_id);

                $storedImageStatus = $imageStatus;
            }

            //check image return value and act accordingly
            if ($storedImageStatus == false) {

                //return back with error if any error
                session()->flash('message.alert', 'danger');
                session()->flash('message.content', "Error uploading image, Please Try again ");
                return back();
            }

            $encoded = base64_encode(base64_encode($client_email));

            $url = "/clients/" . $encoded . "/invoices/" . strtotime($invoice->created_at);
            $name = Auth::user()->name;
            try {
                Mail::to($client_email)
                        ->send(new SendInvoice([
                            'user' => $name,
                            'name' => $client->name,
                            'amount' => $invoice->amount,
                            'trackingcode' => $invoice->estimate->project->tracking_code,
                            'invoice_url' => $url,
                            'project' => $project_name
                ]));
            } catch (\Throwable $e) {
                // dd($e->getMessage());
                session()->flash('message.alert', 'danger');
                session()->flash('message.content', "Error We Are Unable to Send This Invoice Now, Please Try Back Later ");
                return redirect("/invoices");
            }

            return view('invoices.invoicesent');
        }
    }

    //UPLOAD IMAGE CODE
    // @author: @Bits_and_Bytes
    function ImageValidation(array $array) {
        return Validator::make($array, [
                    'profileimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    }

    /**
     * @description receive user upload photo and update picture
     * @param Request $request
     * @author: @Bits_and_Bytes
     */
    // CHANGE ALL DB TABLE SAVES TO THE CORRECT ONE WITH INVOICE...
    // @author: @Bits_and_Bytes
    function updateImage($request, $clientId) {
        $imageValidate = $this->ImageValidation(['profileimage' => $request->file('profileimage')]);

        if (!$imageValidate->fails()) {
            //check if user has image
            $clientProfileData = Client::where('id', $clientId)->first();

            if ($clientProfileData != null) {
                //cast collection result to array
                $collectionResult = $clientProfileData->toArray();

                if (sizeof($collectionResult) != 0) {  //upload image and update image field only
                    //get profile image
                    $oldImage = $collectionResult['profile_picture'];
                    //dd($oldImage);
                    if ($oldImage != null) {
                        // check if user has image and unlink
                        if (file_exists(public_path($oldImage))) {
                            unlink(public_path($oldImage));
                        }
                    }


                    $imagePathString = $this->uploadImageToFile($request->file('profileimage'));
                    //store in DB

                    $clientProfileData->profile_picture = $imagePathString;
                    $clientProfileData->save();

                    if ($clientProfileData->profile_picture == $imagePathString) {

                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadImageToFile(UploadedFile $uploadedFile, $Imagefilename = null, $folderName = null, $appDiskStorage = null) {
        $folderName = (!is_null($folderName)) ? $folderName : 'images/ClientImages';
        $appDiskStorage = (!is_null($appDiskStorage)) ? $appDiskStorage : 'public';
        $imageName = (!is_null($Imagefilename)) ? $Imagefilename : md5(auth()->user()->id . now());

        $filePath = $uploadedFile->storeAs($folderName, $imageName . '.' . $uploadedFile->getClientOriginalExtension(), $appDiskStorage);

        return $filePath;
    }

    public function clientInvoice($client, $invoice) {
        $data['invoice'] = Invoice::with('estimate')->where('created_at', Carbon::createFromTimestamp($invoice))->first();
        return view('invoices.clientinvoice', $data);
    }

    public function pay($txref) {
        $data = $this->verifyTransaction($txref);
        // dd($data);
        if ($data['success']) {
            $invoice = Invoice::find($data['invoice_id']);
            $invoice->update(['status' => 'paid']);
            $project_name = $invoice->project->title;
            $user = User::find($invoice->project->user_id);
            $user->notify(new UserNotification([
                "subject" => "Invoice paid",
                "body" => "This is to notify you that the invoice for the project " . $project_name . " in the amount NGN" . $invoice->amount . " has been paid",
                "action" => [
                    "text" => "View invoices",
                    "url" => "/invoices"
                ]
            ]));
            return "Thanks, " . $user->name . " has successfully recived the payment";
        } else {
            return $data['reason'];
        }
    }

    // public function view($invoice_id) {
    //     $invoice = Invoice::where(['id' => $invoice_id, 'project_id' => Auth::user()->id])->first();
    //     return $invoice->count() > 0 ? $this->SUCCESS('Invoice retrieved', $invoice) : $this->SUCCESS('No invoice found');
    // }

    public function addLogo(Request $request) {
        // $this->validate($request, [
        //     'logo_image_file' => 'required|image',
        //     'invoice' => 'required|numeric'
        // ]);

        $user_id = Auth::id();
        // dd($request);
        // dd($request->invoice);

        $invoice = Invoice::where('id', $request->invoice)->where('user_id', $user_id)->first();

        if ($file = $request->file('logo_image_file')) {
            $name = 'invoice_logo_' . time() . "." . $file->getClientOriginalExtension();

            // Storage::disk('public')->put("/storage/logos/".$name , $file);
            $file->move(public_path('storage/logos/'), $name);

            $invoice->update(['logo' => $name]);

            request()->session()->flash('message.content', 'Logo successfully saved.');
            request()->session()->flash('message.alert', 'success');
            return redirect()->back();
        } else {
            request()->session()->flash('message.content', 'Please select a valid image.');
            request()->session()->flash('message.alert', 'danger');

            return redirect()->back();
        }
    }


    //Search functionality
            public function search (Request $request) {
                $user = Auth::user()->id;
                $search = $request->get('search');

                $invoices['data'] = Invoice::whereUser_id($user)->with(["projects"])->get();
                $invoiceSearch= array();
                $count=0;
                    foreach ($invoices['data'] as $invoice) {
                        if ($invoice['name'] == $search) {
                            // dd($client['name'],$search);
                            $count+=1;
                        if($count==1){
                            $invoiceSearch[0]= $invoice;
                        }else{
                            array_push($invoiceSearch, $invoice);
                        }

                    } if ($invoice['project']) {
                        foreach ($invoice['project'] as $project){
                            if ($project['title'] == $search){
                            // dd($clients); $invoices['data'] = $invoice;
                            $count+=1;
                            if($count==1){
                                $invoiceSearch[0]= $invoice;
                            }else{
                                array_push($invoiceSearch, $invoice);
                            }
                            }
                        };
                    }
                };
               return view('invoices.list', ['invoices'=>$invoiceSearch]);
                }

}
