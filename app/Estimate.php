<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
class Estimate extends Model
{
    // protected $fillable = [
    //     'project_id',
    //     'time',
    //     'price_per_hour',
    //     'equipment_cost',
    //     'sub_contractors',
    //     'sub_contractors_cost',
    //     'similar_projects',
    //     'rating',
    //     'currency_id',
    //     'start',
    //     'end',
    // ];

    protected $guarded = ['id'];
    
    public function projects()
    {
        return $this->belongsTo('App\Project');
    }
     public function project()
    {
        return $this->hasOne(Project::class, 'estimate_id')->with('client');
    }
    

    public function invoice()
    {
        return $this->hasOne('App\Invoice')->with('currency');
    }

}
