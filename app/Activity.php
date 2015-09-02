<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model  {

    protected $table = 'activity';

    protected $fillable = [
        'name','responsible', 'start_time', 'end_time', 
        'status','approve','task_id','completed_at'
        ];

    public function task(){
            return $this->hasMany('App\Task','activity_id');
    }
    public function activetask(){
            return $this->hasMany('App\ActiveTask','activity_id');
    }
     public function task_approve(){
            return $this->hasMany('App\Task','activity_id')->where('approve','like','%อนุมัติแล้ว%');
    }
    public function project(){
        return $this->belongsTo('App\Project');
    }
            function responsible_user(){
        return   $this->belongsTo('App\User','responsible');
    }
   
}
