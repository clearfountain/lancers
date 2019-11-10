<?php

namespace App\Http\Controllers;

use App\Traits\VerifyandStoreTransactions;
use App\Invoice;
use App\Subscription;
use App\Notifications\UserNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use the Rave Facade
use Rave;
use App\SubscriptionPlan;

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
    public function callback(SubscriptionPlan $plan, Subscription $Subscriber) {

        $data = Rave::verifyTransaction(request()->txref);
        $action = $data->data->meta[0]->metavalue;
        $checkdata = $data;
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
            case 'sub':
                if ($txref !== null) {
                    $data = $this->verifyTransaction($txref);
                } else {
                    $data = [
                        'success' => true,
                        'plan_id' => 1,
                        'months' => 12
                    ];
                }
                if (!$checkdata->status == "success") {
                    return $this->error($data['reason']);
                } else {
                    $planId = $checkdata->data->meta[1]->metavalue;
                    $months = $checkdata->data->paymentplan;


                    $planDetails = $plan->checkPlan($planId);
                    //dd($planDetails['status']);
                    if ($planDetails['status']) {
                        //subscribe user to plan selected
                        //main logic present in Subscription model
                        $subscribeUserToPlan = $Subscriber->subscribeToPlan($planDetails['data']['id'], Auth::id(), $months);

                        // if($subscribeUserToPlan === true){
                        //     return $this->success("Subscribed sucessfully", str_replace("_"," " ,ucfirst($planDetails['data']['name'])));
                        // }else {
                        //     return $this->error("Subscription failed");
                        // }

                        if (($subscribeUserToPlan['status'] == false) && ($subscribeUserToPlan['payload'] != null)) {
                            return redirect('/users/subscriptions')->with(['editErrors' => $subscribeUserToPlan['payload']]);
                        }

                        if ($subscribeUserToPlan['status'] == true) {
                            session()->flash('message.alert', 'success');
                            session()->flash('message.content', "Your subscription to " . ucfirst($planDetails['data']['name'] . " plan was sucessful"));
                            return redirect('/users/subscriptions')->with('plan', Subscription::planData());
                        }

                        if (($subscribeUserToPlan['status'] == false) && ($subscribeUserToPlan['payload'] == null)) {
                            session()->flash('message.alert', 'danger');
                            session()->flash('message.content', $subscribeUserToPlan['payload']);
                            return redirect('/users/subscriptions')->with('plan', Subscription::planData());
                        }
                    } else {
                        session()->flash('message.alert', 'danger');
                        session()->flash('message.content', "Plan subscription not successful");
                        return redirect('/users/subscriptions')->with('plan', Subscription::planData());
                    }
                }
        }
    }

}
