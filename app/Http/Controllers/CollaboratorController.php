<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collaborator;
use Auth;
use App\User;
use App\Project;

class CollaboratorController extends Controller
{
    
    public function getAllCollaborators(){
        $projects = Project::where('user_id', Auth::user()->id)->get(['id', 'title']);
        $users = User::all(['id', 'name']);

        $collaborators = Project::where('projects.user_id', Auth::user()->id)
                ->join('collaborators AS c', 'c.project_id', 'projects.id')
                ->join('users', 'users.id', 'c.user_id')
                ->select( 'c.role', 'c.created_at', 'users.profile_picture', 'users.name', 'projects.title AS project_title')
                ->orderBy('c.created_at', 'DESC')
                ->get();
        return view('projects.collaborators')->withCollabo($collaborators)->withProjects($projects)->withUsers($users);
    }

    public function store(Request $request){
        $request->validate([
            'role' => 'required|string',
            'user_id' => 'required|numeric',
            'project_id' => 'required|numeric',
        ]);

        $query = Collaborator::updateOrCreate(
            ['user_id'=>$request->user_id, 'role'=>$request->role, 'project_id'=>$request->project_id], 
            $request->all()
        );

        if ($query) {
            // $request->session()->flash('success', 'Collaborator Added!');
            return back()->withSuccess('Collaborator Added Successful');
        }else{
            // $request->session()->flash('errors', 'Collaborator addtion failed!');
            return back()->withInputs()->withError('Collaborator added failed');
        }
    }

}
