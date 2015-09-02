<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model  {
    
    protected $table = 'project';
    
    protected $fillable = ['name', 'detail', 'start','status','finish',
    'primary_adviser_id','secondary_adviser_id'];
   
    public function setStartAttribute($value)
    {
        $this->attributes['start'] = \DateTime::createFromFormat('Y-m-d',$value);
    } 
    public function setFinishAttribute($value)
    {
        $this->attributes['finish'] = \DateTime::createFromFormat('Y-m-d',$value);
    }
    public function student(){
        return $this->hasMany('App\User','project_id')->where('role','student'); 
    }
    public function secondary_adviser(){
        return $this->hasMany('App\User','id','secondary_adviser_id');
    }
    public function primary_adviser(){
        return $this->hasMany('App\User','id','primary_adviser_id');
    }
    public function activity(){
        return $this->hasMany('App\Activity','project_id');
    }
     public function appointment(){
        return $this->hasMany('App\Appointment','project_id');
    }
    public function task(){
        return $this->hasMany('App\Task');
    }

    public function activetask(){
        return $this->hasMany('App\ActiveTask');
    }
    public function user(){
         return $this->belongsTo('App\Project','project_id');
    }
    
}
