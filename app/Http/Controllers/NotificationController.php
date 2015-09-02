<?php

namespace App\Http\Controllers;

use Auth,
Input,
App\Notification;

class NotificationController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {

        $notification = Notification::orderBy('created_at','desc')->where('reciver_id', Auth::user()->id)->get();
        //dd($notifications);
            ///foreach ($notifications as $notification){ // access user properties here{
                //dd($notification->id);
                //$previous = Notification::where('reciver_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
                //$next = Notification::orderBy('created_at', 'desc')->where('reciver_id', Auth::user()->id)->whereNotIn('id',$notification->id)->get();
            ///dd($next);
            //}

            return view('notification.index')->with('notification', $notification);
        }

        public function getMarkasread($id) {
            $notification = Notification::find($id);
            $notification->is_read = 1;
            $notification->save();
        //return redirect()->back()->with('success', 'คุณอ่านข้อความหมายเลข ' . $notification->id . ' เรียบร้อยเเล้ว');
            return redirect()->back()->with('success', 'คุณอ่านข้อความเรียบร้อยเเล้ว');
        }

    }
