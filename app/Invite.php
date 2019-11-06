<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    //
    protected $fillable = [
        'email', 'token','project_id','role'
    ];

    /**
 * A user has a referrer.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function project()
{
    return $this->belongsTo(Project::class, 'project_id', 'id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

}
