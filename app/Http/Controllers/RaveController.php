<?php

namespace App\Http\Controllers;

use App\Traits\VerifyandStoreTransactions;
use App\Invoice;
use App\Notifications\UserNotification;
use App\User;
use Illuminate\Http\Request;
//use the Rave Facade
use Rave;

class RaveController extends Controller {

    use VerifyandStoreTransactions;

    /**
     * Initialize Rave payment process
     * @return void
     */
    public function initialize() {
        //This initializes payment and redirects to the payment gateway
        //The initialize method takes the parameter of the redirect URL
        Rave::initialize(route('callback'));
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback() {

        $data = Rave::verifyTransaction(request()->txref);

        $action = $data->data->meta[0]->metavalue;

        $txref = $data->data->txref;
        $this->verifyTransaction($txref);
        switch ($action) {
            case 'invoice':
                if ($data->status == 'success') {
                    $invoice = Invoice::find($data->data->meta[1]->metavalue);
                    $invoice->update(['status' => 'paid']);
                    $project_name = $invoice->estimate->project->title;

                    $user = User::find($invoice->estimate->project->user_id);
                    $user->notify(new UserNotification([
                        "subject" => "Invoice paid",
                        "body" => "This is to notify you that the invoice for the project " . $project_name . " in the amount NGN" . $invoice->amount . " has been paid",
                        "action" => [
                            "text" => "View invoices",
                            "url" => "/invoices"
                        ]
                    ]));
                    $encoded = base64_encode(base64_encode($invoice->estimate->project->client->email));

                    $url = "/clients/" . $encoded . "/invoices/" . strtotime($invoice->created_at);
                    session()->flash('message.alert', 'success');
                    session()->flash('message.content', "Thanks, " . $user->name . " has successfully recived the payment ");
                    return redirect($url);
                } else {
                    session()->flash('message.alert', 'danger');
                    session()->flash('message.content', "Payment Failed , Try another Card ");
                    return redirect($url);
                }
                break;
        }
    }

}
