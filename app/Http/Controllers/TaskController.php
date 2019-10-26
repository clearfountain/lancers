<?php

namespace App\Http\Controllers;

use Auth;
use App\Task;
use App\User;
use App\Project;
use App\Collaborator;
use App\Rules\IsUser;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getAllTasks(){
        $filter = Request()->filter ?? false;
        if($filter && !in_array($filter, ['all', 'pending', 'completed', 'in-progress'])) $filter = false;

        $projects = Project::where('user_id', Auth::user()->id)->get(['id', 'title']);
        $users = Project::where('projects.user_id', Auth::user()->id)
        ->join('collaborators AS c', 'c.project_id', 'projects.id')
        ->join('users', 'users.id', 'c.user_id')
        ->select( 'users.profile_picture', 'users.name', 'users.id')
        ->orderBy('c.created_at', 'DESC')
        ->get();

        $tasks = Project::where('projects.user_id', Auth::user()->id)
                ->join('tasks', 'tasks.project_id', 'projects.id');
    
        if($filter && $filter !== 'all') $tasks = $tasks->where('tasks.status', $filter);
        
        $tasks = $tasks->select( 'tasks.title AS task_title', 'tasks.*', 'projects.title AS project_title')
                ->orderBy('created_at', 'DESC')
                ->get();
        return view('projects.tasks')->withTasks($tasks)->withProjects($projects)->withUsers($users);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string',
            'user_id' => 'required|numeric',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'project_id' => 'required|numeric',
        ]);

        $task = Task::create($request->all());

        if ($task) {
            $request->session()->flash('success', 'Task Created!');
            return back()->withSuccess('Task Creation Successful');
        }else{
            $request->session()->flash('errors', 'Task creation failed!');
            return back()->withInputs()->withError('Task creation failed');
        }
    }

    public function addTeam(Task $task, Request $request) {
        $team = $task->team ?? [];
        $request->validate([
            'user_id' => ['required', 'integer', new IsUser],
            'designation' => 'required|string',
        ]);

        array_push($team, [
            'user_id' => $request->input('user_id'),
            'designation' => $request->input('designation')
        ]);


        $task = $task->update(['team' => $team]);

        return $this->SUCCESS("team added", $task);
    }

    public function team(Task $task){
        $team = $task->team ?? [];
        
        // fetch all the team mates as users with profile_picture, name
        $members_id = array_column($team, "user_id");
        $members = User::whereIn('id', $members_id)->select('id', 'name', 'profile_picture')->get();

        // add profile profile_picture name to main data
        foreach ($members as $key => $person) {
            $members[$key]["designation"] = $team[$key]["designation"];
        }

        return $this->SUCCESS("members retrieved", $members);
    }
    
    public function index(Project $project){
        $user = Auth::user();

        $projects = $user->projects->pluck('id')->toArray();

        $tasks = Task::whereIn('project_id', $projects )->select('name', 'project_id', 'status', 'progress', 'team')->with('project:id,title')->get();

        if($tasks){
            return $this->SUCCESS("tasks retrieved", $tasks);
        }
        return $this->ERROR('no Task Found');
    }

    public function projectTasks(Project $project){
        $tasks = Task::where('project_id', $project->id)->get();
        if($tasks){
            return $this->SUCCESS("tasks retrieved", $tasks);
        }
        return $this->ERROR('no Task Found');
    }


    
    public function show(Task $task){
        if($task){
            return $this->SUCCESS($task);
        }
        return $this->ERROR('Task not Found');
    }

    public function update(Request $request, Task $task){
        $request->validate([
            'name' => 'required|string',
            'progress' => 'nullable|numeric',
            'team' => 'nullable|string',
            'due_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'project_id' => 'required|numeric',
            'status' => 'nullable|string'
        ]);

        $task = Task::where('project_id', $request->input('project_id'))->first();

        if ($task) {
            $task->update($request->all());
            return $this->SUCCESS("task updated",$task);
        }

        return $this->ERROR('Task not found');
    }
    
    public function destroy(Request $request, Task $task){
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}