<?php

namespace App\Http\Controllers;

use App\User;
use App\Invite;
use App\Mail\InviteCreated;
use App\Mail\NotifyCreator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Auth\Events\Registered;
use App\Project;
use App\Estimate;
use App\Invoice;
use App\Collaborator;
// use App\Profile;
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
use App\Notifications\UserNotification;

class InviteController extends Controller {

public function invite()
{

    $projects = Project::where('user_id', Auth::user()->id)->get(['id', 'title']);
    $invites = Invite::where('user_id', Auth::user()->id)->get();
    // show the user a form with an email field to invite a new user
    // dd($invites);
    return view('projects.invite')->withProjects($projects)->withInvites($invites);
}

public function process(Request $request)
{
    // validate the incoming request data

    do {
        //generate a random string using Laravel's str_random helper
        $token = str_random();
    } //check if the token already exists and if it does, try again
    while (Invite::where('token', $token)->first());

    $request->validate([
        'role' => 'required|string',
        'email' => 'required|string',
        'project' => 'required|numeric',
    ]);

    $inviter = Invite::where('email', $request->get('email'))->where('project_id', $request->project)->first();
    if ($inviter){
        return redirect()->back()->with('error','The invitation have already been sent ');
    }

    $collaborator = User::where('email', $request->get('email'))->first();
    if ($collaborator){
        $collaborator->notify(new UserNotification([
            "subject" => auth()->user()->name." wants to add you as a collaborator",
            "body" => auth()->user()->name." has requested to add you as a collaborator on the project, ".Project::find($invite->project_id)->title.".",
            "action" => [
                "text" => "View projects",
                "url" => '/projects'
            ]
        ]));
        return redirect()->back()->with('error','The user already exists ');
    }

    $user = Auth::user();


    //create a new invite record
    // $invite = Invite::create([
    //     'user_id' => $user->id,
    //     'email' => $request->get('email'),
    //     'project_id' => $request->get('project'),
    //     'role' => $request->get('role'),
    //     'status' => 'pending',
    //     'token' => $token
    // ]);

    $invite = new Invite;
    $invite->email = $request->get('email') ;
    $invite->user_id = $user->id;
    $invite->project_id = $request->project;
    $invite->role = $request->get('role');
    $invite->status = 'pending';
    $invite->token = $token;
    
    
    if($invite->save()){
        // now we will send the email to the invitee
    Mail::to( $invite->email)->send(new InviteCreated($invite));
    }


    

    // redirect back where we came from
    return redirect()->back()->with('success','Invitation have been sent');
}

public function register($token){

    $invite = Invite::where('token', $token)->where('status','pending')->first();
    // Look up the invite
    if (!$invite ) {
        //if the invite doesn't exist do something more graceful than this
        abort(404);
    }

    return view('projects/register')->withInvite($invite);
}

public function accept( Request $request, $token)
{
    $invite = Invite::where('token', $token)->where('status','pending')->first();
    // Look up the invite
    if (!$invite ) {
        //if the invite doesn't exist do something more graceful than this
        abort(404);
    }
    

    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
                    'email' => $invite->email,
                    'password' => $password
        ]);

        // change  the invite status so it can't be used again
        $invite->status = 'completed';
        $invite->save();

         

        //create the collaborator and add the user as a collaborator

        $collaborator = Collaborator::Create([
            'user_id'=>$user->id,
             'role'=>$invite->role, 
             'project_id'=> $invite->project_id
             ]);

        //send email notification to the Inviter
            $invite->user->notify(new UserNotification([
                "subject" => "Your invite was accepted",
                "body" => $request->name." has accepted your invitation to collaborate on the project, ".Project::find($request->$invite->project_id)->title.".",
                "action" => [
                    "text" => "View collaborators",
                    "url" => '/project/collaborators'
                ]
            ]));
        // Mail::to($invite->user->email)->send(new NotifyCreator($collaborator));
        // Mail::to('$invite->user->email')->send(new InviteCreated($invite));

        // Lets log the user in and show them the dashboard
        Auth::login($user);

    



    return redirect('/dashboard');

   

    // return 'Invite accepted!';
}
}