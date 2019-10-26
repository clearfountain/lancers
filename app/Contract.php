<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //

    protected $fillable = ["project_id", "issue_date", "status", "filename", 'id', 'title', 'client_id'];

    public function project(){
        return $this->belongsTo('App\Project');
    }
    
}
