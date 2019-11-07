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
                ->select( 'c.id','c.role', 'c.created_at', 'users.profile_picture', 'users.name', 'projects.title AS project_title')
                ->orderBy('c.created_at', 'DESC')
                ->get();
                // dd($collaborators);
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

    public function view($id){

        $collaborator = Collaborator::where('id',$id)->first();

        
        return view('projects.collaborator')->withCollabo($collaborator);

    }

    public function edit($id){

        $collaborator = Collaborator::where('id',$id)->first();



        $projects = Project::where('user_id', Auth::user()->id)->get(['id', 'title']);
        $users = User::all(['id', 'name']);

        return view('projects.collaborator-edit')->withCollabo($collaborator)->withProjects($projects)->withUsers($users);

    }


    public function update(Request $request, $id){
        $request->validate([
            'role' => 'required|string',
            'user_id' => 'required|numeric',
            'project_id' => 'required|numeric',
        ]);

        $query = Collaborator::whereId($id)->FirstOrFail();
        $query->user_id = $request->user_id;
        $query->project_id = $request->project_id;
        $query->role =  $request->role;
        if ($query->save()) {
            // $request->session()->flash('success', 'Collaborator Added!');
            return back()->withSuccess('Update Successful');
        }else{
            // $request->session()->flash('errors', 'Collaborator addtion failed!');
            return back()->withInputs()->withError('Unable to save your input');
        }
    }


    public function delete($id){

        $object = Collaborator::whereId($id)->first();
       if($object){
        $object->delete();
        return redirect()->back()->with('success','Collaborator have been removed');
       }
       else{
        return redirect()->back()->with('error','An error occur');
       }    

    }

    

}
