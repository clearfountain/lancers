<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Client;
use App\Project;
use Illuminate\Http\Request;
use App\Contract;
use App\Traits\VerifyandStoreTransactions;

class ContractControler extends Controller
{
  
public function index() {
    $user = Auth::user();

    // return $user->projects;

    $contracts = $user->projects()->select('id', 'title', 'client_id')->with(['client:id,name', 'contract:id,project_id,status,issue_date,created_at'])->get();

    foreach ($contracts as $key => $contract) {
        if ($contract->contract == null) {
            unset($contracts[$key]);
        }

        if ($contract->client_id == null) {
            unset($contracts[$key]);
        }
    }
    // return $contracts;
}

/**
 * Creates new record in the contract table
 */
public function store(Request $request) {

    $this->validate($request, [
        'project_id' => 'required|numeric'
    ]);

    $project = Project::findOrFail($request->project_id);

    $pre_contract = contract::where('project_id', $request->project_id)->first();

    if ($pre_contract !== null) {

        $pre_contract->update(['issue_date' => $project->project]);

        $contract = $pre_contract;
    } 
    else {

        $contract = contract::create(['issue_date' => $project->start,'project_id' => $project->id])->with('project');
    }

    return view('contracts.reviewcontract')->with('contract', $contract);
}

public function delete(Request $request, $contract) {
    $contract = contract::findOrFail($contract);

    $user = Auth::user();

    if ($contract->project->user_id !== $user->id) {
        $request->session()->flash('error', "You're unauthorized to delete this contract");
        return redirect()->back();
    } else {
        $request->session()->flash('status', 'Deleted');
        return redirect()->back();
    }
    }

    public function show($contract) {
        $contract = contract::findOrFail($contract);

        // dd($contract);
        $project_id = $contract->project_id;

        $contract = Project::where('id', $project_id)->select('id', 'title', 'project_id', 'client_id')->with(['project', 'contract', 'client'])->first();

        // return $contract;
        return view('contracts.viewcontract')->with('contract', $contract);
    }

    public function view($contract_id) {
        $contract = contract::where(['id' => $contract_id, 'project_id' => Auth::user()->id])->first();
        return $contract->count() > 0 ? $this->SUCCESS('contract retrieved', $contract) : $this->SUCCESS('No contract found');
    }

}