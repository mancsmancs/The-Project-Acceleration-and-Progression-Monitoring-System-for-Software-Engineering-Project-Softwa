<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class Task extends Model  {

    protected $table = 'task';

    protected $fillable = [
        'name', 'start_time', 'end_time', 'status','approve',
        'timefortask','activity_id','completed_at','updated_at','LinkItem','newtimefortask','timeoftask','work_status','newdeadline','approve_newtime','project_id','houroftask'];

    public function activity(){
            return $this->belongsTo('App\Activity','activity_id');
    }
       public function responsible(){
            return $this->belongsTo('App\User','responsible');
    }
    public function extendtask(){
         return $this->hasMany('App\Extendtask','task_id');
    }
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
    public function project(){
            return $this->belongsTo('App\Project');
    }
}
