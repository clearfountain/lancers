<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Client;
use App\Project;
use App\Invoice;
use App\Estimate;
use Carbon\Carbon;
use App\Mail\SendInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\UserNotification;
use App\Traits\VerifyandStoreTransactions;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller {

    use VerifyandStoreTransactions;

    public function view($id)
    {
        $invoice = Invoice::where('id', $id)->first();

        return view('invoice')->withInvoice($invoice);
    }
    public function edit($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $projects = Project::where('user_id', Auth::user()->id)->get(['id', 'title']);
        $users = User::all(['id', 'name']);
        return view('invoices.reviewinvoice')->withInvoice($invoice)->withProjects($projects)->withUsers($users);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string',
            'user_id' => 'required|numeric',
            'project_id' => 'required|numeric',
        ]);
        $query = Invoice::whereId($id)->FirstOrFail();
        $query->user_id = $request->user_id;
        $query->project_id = $request->project_id;
        $query->role =  $request->role;
        if ($query->save()) {
            // $request->session()->flash('success', 'Invoice Added!');
            return back()->withSuccess('Update Successful');
        } else {
            // $request->session()->flash('errors', 'Invoice addtion failed!');
            return back()->withInputs()->withError('Unable to save your input');
        }
    }
    public function delete($id)
    {
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
        }else{

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

        $invoice = Project::where('invoice_id', $invoice->id)->select('id', 'title', 'estimate_id', 'invoice_id','client_id')->with(['estimate', 'invoice', 'client'])->first();

        $pdf = PDF::loadView('invoices.pdf', ['invoice' => $invoice]);

        return $pdf->download($filename);
    }

    public function sendinvoice(Request $request) {
        $invoice_id = $request->invoice;


        $invoice = Invoice::with('estimate')->findOrFail($invoice_id);

        $project_name = $invoice->estimate->project->title;

        $client = $invoice->estimate->project->client;

        $client_email = $client->email;

        $encoded = base64_encode(base64_encode($client_email));

        $url = "/clients/" . $encoded . "/invoices/" . strtotime($invoice->created_at);
        $name = Auth::user()->name;
        try {
            Mail::to($client_email)
                    ->send(new SendInvoice([
                        'user' => $name,
                        'name' => $client->name,
                        'amount' => $invoice->amount,
                        'invoice_url' => $url,
                        'project' => $project_name
            ]));
        } catch (\Throwable $e) {
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', "Error We Are Unable to Send This Invoice Now, Please Try Back Later ");
            return back();
        }

        
        return view('invoices.invoicesent');
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

}
