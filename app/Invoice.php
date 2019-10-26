<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;
use App\Currency;
class Invoice extends Model
{
    protected $fillable = ["user_id","issue_date", "due_date", "amount", "estimate_id", "amount_paid", "status", "currency_id", "filename"];

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function estimate(){
    	return $this->belongsTo(Estimate::class, 'estimate_id')->with('project');
    }
    
     public function currency(){
    	return $this->belongsTo(Currency::class, 'currency_id');
    }
    
}
