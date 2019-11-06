<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    protected $guarded= ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}



