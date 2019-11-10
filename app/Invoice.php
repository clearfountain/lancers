<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;
use App\Currency;
use App\Project;
class Invoice extends Model
{
    protected $guarded = ['id'];

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
