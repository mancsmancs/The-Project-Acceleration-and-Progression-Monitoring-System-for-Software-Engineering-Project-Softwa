<?php namespace App;
use Illuminate\Database\Eloquent\Model;
/**
* 
*/
class Notification extends Model
{
    protected $fillable   = ['sender_id', 'type', 'subject', 'body', 'reciver_id'];
 
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
 
    public function sender()
    {
        return $this->belongsTo('App\User','sender_id');
    }
     public function reciver()
    {
        return $this->belongsTo('App\User','reciver_id');
    }
}