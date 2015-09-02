<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ActiveTask extends Model  {

    protected $table = 'activetask';
    
    protected $fillable = ['name','startdate','stopdate','task_id','activity_id'];

    public function task(){
            return $this->belongsTo('App\Task','task_id');
    }
    public function activity(){
            return $this->belongsTo('App\Activity','activity_id');
    }
    public function project(){
            return $this->belongsTo('App\Project');
    }
}