<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {
     public function _construct()
    {
     \DB::enableQueryLog();
    }
	use DispatchesCommands, ValidatesRequests;

   
    public function notification($type, $subject, $reciver_id, $body = null) {
        $notification = new \App\Notification;
        $notification->sender_id = \Auth::user()->id;
        $notification->type = $type;
        $notification->body = $body;
        $notification->subject = $subject;
        $notification->reciver_id = $reciver_id;
        $notification->save();
        
        $data = ['title'=>$notification->subject,'from'=>$notification->sender->first_name,'detail'=>$body];
        \Mail::send('emails.notification',$data,function($message) use ($notification) {
                $message->to($notification->reciver->email,$notification->reciver->first_name)->subject('การแจ้งเตือนจาก ระบบThe Project Acceleration and Progression Monitoring System');
            });
    }
}
