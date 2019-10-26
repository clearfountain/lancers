<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\MailSubscription;


class MailSubscriptionController extends Controller
{
    public function mailStore(Request $request){
    
        $inputMail = $request->input('subEmail');
        $inputMail = strtolower($inputMail);
        $inputMail = trim($inputMail);
        $inputMail = stripslashes($inputMail);
        $inputMail = htmlspecialchars($inputMail);
    
        if(empty($inputMail)){
            
            session(['subMessageBad' => 'Please input email to subscribe']);
            
        }
        else if(! filter_var($inputMail,FILTER_VALIDATE_EMAIL)){
            
            session(['subMessageBad' => 'Wrong email format']);
            
        }
        
        else if(MailSubscription::where('email', $inputMail)->first()){
            
            session(['subMessageGood' => 'You have already subscribed to our mailing list!']);
            
        }
        else if(!MailSubscription::where('email', $inputMail)->first()){
            
            $userMail = new MailSubscription;
            $userMail->email = $inputMail;
            $userMail->subscribed = 1;
            $userMail->save();
            
            session(['subMessageGood' => 'Suscription to mailing list successful!']);
            
        }
        //return redirect('/pricing');
        return redirect()->back();
        
    
    }
    
}
