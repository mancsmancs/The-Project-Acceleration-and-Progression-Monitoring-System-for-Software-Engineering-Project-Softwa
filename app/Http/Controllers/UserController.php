<?php

namespace App\Http\Controllers;

use \App\User,
    Input,Request,
    Redirect;
use \Auth;
class UserController extends Controller {

    public function __construct() {
//        $this->middleware('auth');
    }

    public function register() {
        if (\Request::isMethod('post')) {
            $user = User::create(\Input::all());
            $user->activated = 0;
            $comfirmcode = \Hash::make($user->password);
            $user->comfirmcode = $comfirmcode;
            $user->update();
            $data = ['id' => $user->id, 'first_name' => $user->first_name, 'comfirmcode' => $comfirmcode];
            \Mail::send('emails.confirm', $data, function($message) use ($user) {
                $message->to($user->email, $user->first_name)->subject('ยืนยันการสมัครสมาชิก!');
            });
            return Redirect::route('login')->with('success', 'กรุณายืนยันตัวเอง ผ่านทางอีเมล์ที่ส่งไปก่อนครับ');
        } else {
            return view('auth.register');
        }
    }

    
    
    public function profile(){
        if(Request::isMethod('post')){
             $user = User::find(\Auth::user()->id);
        if (Input::hasFile('profile')):
            $file = Input::file('profile');
            $extension = $file->getClientOriginalExtension();
            $filename = str_random('10') . '.' . $extension;
            \Storage::disk('photo')->put($filename, \File::get($file));
            $user->profile_image = $filename;
        endif;

        $user->working_time = Input::get('working_time');
        $user->non_working_time = Input::get('non_working_time');
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        //$user->password = \Hash::make(Input::get('new_password'));
        $user->save();
        return Redirect::back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
        }else{
           
            return view('user.profile');
        }
    }
    function activate() {
        $user = User::find(Input::get('id'));
        
        if (strcmp($user->comfirmcode, Input::get('hash')) == 0) {
            $user->activated = 1;
            $user->comfirmcode = '';
            $user->update();
            return redirect()->route('login')->with('success', 'คุณสามารถเ้ขาสู่ระบบได้เเล้ว');
        } else {
            return redirect()->route('login')->with('danger', 'ไม่สามรถตรวจสอบรหัสได้ โปรดติดต่อ แอดมิน');
        }


    }

    public function dashboard() {
        if (\Auth::user()) {

            if (\Auth::user()->role == 'student') {
                $project = \App\Project::with('activity.task')->where('id', \Auth::user()->project_id)->get();
                //dd($project);

            } else {
                $project = \App\Project::with('activity.task')->where('primary_adviser_id', \Auth::user()->id)->get();
            }



             $tasks = \DB::table('task')->get();
             //dd($tasks);
             //$user =\DB::table('users')->where('role', 'student')->where('id', $task->responsible)->first();
             $today = getdate();
                $hour = $today['hours'];
                $min = $today['minutes'];
                $sec = $today['seconds'];
                //dd( $hour,$min,$sec);
            //dd($tasks);
        //if($hour=='00'&& $min=='36'&& $sec=='00'){
            //echo "HAAAAAAAAAAAAAAAAA";
        //dd( $hour,$min,$sec);

            foreach ($tasks as $key => $task) {

                 $user =\DB::table('users')->where('role', 'student')->where('id', $task->responsible)->first();
                //dd($user);
                //dd($task);
                        $task_date_start = $task->start_time;
                        $task_date_stop = $task->stop_time;
                        $task_item = $task->item_of_task;
                        $now_task_item = $task->work_status;

                        //dd($hour=='00'&& $min=='53'&& $sec=='00');
                        //if($task_date_stop==$today):
                            //dd($today==$task_date_stop);
                        /*/if($now_task_item!=$task_item){
                            $this->notification('task', 'แจ้งเตือนสถานะการดำเนินงาน'.$task->name , $user->id,
                'กรุณาตรวจสอบสถานะการดำเนินงาน  '.$task->name .'  ให้แล้วเสร็จภายในเวลาที่กำหนด หรือหากดำเนินการล่าช้ากรุณาขอขยายเวลาการทำงานในระบบ หากต้องการให้งานเสร็จเร็วขึ้นสามารถขอเพิ่มชั่วโมงการทำงานต่อวันได้ หากวันนี้เป็นวันสุดท้ายของการทำงานและชิ้นงานยังไม่แล้วเสร็จกรุณาขยายเวลาการทำงาน ');
                            }
                        /*if($today>=$task_date_start && $today<=$task_date_stop){
                            if($now_task_item!=$task_item){
                                //dd($user);
                                if($hour=='01'&& $min=='13'&& $sec=='00'){
                                  echo "HAAAAAAAAAAAAAAAAA";  
                                $this->notification('task', 'แจ้งเตือนสถานะการดำเนินงาน'.$task->name , $user->id,
                'กรุณาตรวจสอบสถานะการดำเนินงาน  '.$task->name .'  ให้แล้วเสร็จภายในเวลาที่กำหนด หรือหากดำเนินการล่าช้ากรุณาขอขยายเวลาการทำงานในระบบ หากต้องการให้งานเสร็จเร็วขึ้นสามารถขอเพิ่มชั่วโมงการทำงานต่อวันได้ หากวันนี้เป็นวันสุดท้ายของการทำงานและชิ้นงานยังไม่แล้วเสร็จกรุณาขยายเวลาการทำงาน ');
                                }else{
                                    
                                }
                            }
                                
                        }else{
                            if($now_task_item!=$task_item){
                                //dd($user);
                                if($hour=='01'){
                                  //echo "HAAAAAAAAAAAAAAAAA";  
                                $this->notification('task', 'แจ้งเตือนสถานะการดำเนินงาน'.$task->name , $user->id,
                'กรุณาตรวจสอบสถานะการดำเนินงาน  '.$task->name .'  ให้แล้วเสร็จภายในเวลาที่กำหนด หรือหากดำเนินการล่าช้ากรุณาขอขยายเวลาการทำงานในระบบ หากต้องการให้งานเสร็จเร็วขึ้นสามารถขอเพิ่มชั่วโมงการทำงานต่อวันได้ หากวันนี้เป็นวันสุดท้ายของการทำงานและชิ้นงานยังไม่แล้วเสร็จกรุณาขยายเวลาการทำงาน ');
                                }//else{
                               
                                }

                        }   */
        
            }
        
        //endif;
//}

            return view('dashboard')->with('project', $project);
        } else {
            return redirect()->route('home');
        }
    }

    public function login() {
        if (\Request::isMethod('post')) {
            $user = User::where('email', Input::get('email'))->get();
            if($user->toArray(0)){
            if ($user[0]->activated == 1) {
                if (\Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {
                    
                        return redirect()->route('dashboard');
                    //return redirect()->to(\Session::get('redirect_url'));
                    
                } else {
                    return \Redirect::back()->with('danger', 'email หรือ รหัสผ่าน ไม่ถูกต้อง');
                }
            } else {
                return \Redirect::back()->with('danger', 'คุณยังไม่ได้ยืนยันตัวเองผ่านอีเมล์');
            }
        }else{
            return \Redirect::back()->with('danger', 'ไม่พบข้อมูลในระบบ กรุณาสมัครสมาชิก');
        }
        } else {
            \Session::put('redirect_url', \Request::server('HTTP_REFERER'));
            if (!\Auth::user()) {
                return view('auth.login');
            } else {
                return redirect()->route('dashboard');
            }
        }
    }
    
    public function logout() {
        \Auth::logout();
        return redirect()->route('dashboard')->with('success', 'ออกจากระบบเรียบร้อย');
    }


    public function home() {
        
        return view('home');
    }


    public function deleteUser(){
        $idUser = Auth::user()->id;
        if ( $idUser) {
            $user = User::find($idUser)->delete();
            return redirect()->to('/')->with('success', 'ลบผู้ใช้งานสำเร็จแล้ว');
        }
        
        

    }

}
