<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;
use App\Invoice;
class Project extends Model
{
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->with('estimate');
    }
    
   
     public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

   

    public function estimate()
    {
        return $this->belongsTo('App\Estimate');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public static function generateTrackingCode()
    {
        return "LNCR_PTRCK_".time(); 
    }

    protected $casts = [
        'collaborators' => 'array'
    ];
}
