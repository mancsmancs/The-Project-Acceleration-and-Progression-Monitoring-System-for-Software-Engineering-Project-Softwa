<?php

namespace App\Http\Controllers;

use App\Task,
Input,
Request,
Redirect;

class TaskController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getAddtaskstatus() {
        //$task = Task::find($id);
        $task=Task::find(Input::get('id'));
        //dd($task);
        //$task = new \App\Task_status;
        //$task->work_status = Request::get('status');
        $task->update(['work_status' => Input::get('status')]);
        //$task->task_id = Request::get('id');
        $task->save();
        $user = \App\Task::with('activity.project')->find($task->task_id);
                // with คือการดึงฟังก์ชันที่ใช้เชื่อความสัมพันธ์ ในโมเดล มาใช้งาน
        $users = \App\User::whereNotIn('id', [\Auth::user()->id])
        ->where('project_id', $user)->get();

        foreach ($users as $user):
            $this->notification('task_status', \Auth::user()->first_name . 'ได้เพิ่มชิ้นงานบนสายงาน ' . $task->task->name . ' แล้ว', $user->id);
        endforeach;

        return redirect()->back()->with('success', 'เพิ่มสถานะเรียบร้อย');

    }

    public function getTaskstatus($id){
        $tasks = Task::where('activity_id', $id)->get();
        //dd($tasks);
        foreach ($tasks as $key => $task) {
            $students = \DB::table('users')->where('role', 'student')->where('id', $task->responsible)->first();
        //dd($students->non_working_time);
        //dd($students);
        }
        return view('task.taskstatus')->with('tasks', $tasks)->with('students', $students);

    }

    public function getIndex($id) {
        $tasks = Task::where('activity_id', $id)->get();
        foreach ($tasks as $key => $task) {

            if($task->approve=='อนุมัติ'){
                $activetask = new \App\ActiveTask;
                $activetask->name = $task->name;
                $activetask->startdate = $task->start_time ;
                $activetask->stopdate = $task->stop_time;
                $activetask->task_id = $task->id;
                $activetask->activity_id = $task->activity_id;
                $activetask->save();
                $users = \App\User::where('project_id', \Auth::user()->project_id)->where('role', 'student')->get();
                foreach ($users as $key => $user) {
                    $this->notification('task', 'แจ้งเตือนการตอบรับสถานะการดำเนินงาน ของงาน'.$task->name , $user->id,
                        'งาน'.$task->name .'ถูก'. $task->approve .'การสร้างงานแล้ว');
                }
                $task->approve = 'อนุมัติแล้ว';
                $task->status='กำลังทำ' ;
                $task->update();
                if($task->status =='เสร็จแล้ว'){
                    $start_time = \DateTime::createFromFormat('Y-m-d', $task->start_time);
                    $datediff = $start_time->diff($task->updated_at);
                    //dd( $datediff->days+1);
                    $task->timeoftask  = $datediff->days+1;
                    $task->work_status = $task->item_of_task;
                    $task->completed_at =$task->updated_at;
                    $task->update();

                }
                else{
                   return view('task.index')->with('tasks', $tasks);
               }




           }elseif($task->approve=='ไม่อนุมัติ'){
            $users = \App\User::where('project_id', \Auth::user()->project_id)->where('role', 'student')->get();

            foreach ($users as $key => $user) {
                $this->notification('task', 'แจ้งเตือนการตอบรับสถานะการดำเนินงาน ของงาน'.$task->name , $user->id,
                    'งาน'.$task->name .'ถูก'. $task->approve .'การสร้างงานแล้ว');
            }
            $task->approve = 'ไม่อนุมัติแล้ว';
            $task->status='ไม่อนุมัติ' ;
            $task->update();
        }





    }

    return view('task.index')->with('tasks', $tasks);
}

public function getCreate() {
    return view('task.create');
}

public function getChangetaskstatus() {
    $activity = Task::find(Input::get('id'));
    $activity->update(['status' => Input::get('status')]);

}

public function getChangeapprovestatus() {
    $activity = Task::find(Input::get('id'));
    $activity->update(['approve' => Input::get('status')]);
}

public function getDelete($id) {
    $task = Task::find($id);
    $activetask = \App\ActiveTask::with('task')->where('task_id', $id)->first();
    $task->delete();
    $activetask->delete();
    return redirect()->back()->with('success', 'คุณลบงาน ' . $task->name . ' เรียบร้อยแล้ว');
}

public function getEdit($id) {
    $task = Task::find($id);
        //dd($task);
    return view()->make('task.edit')->with('task', $task);
}

public function postEdit($id) {
        //dd(Request::segment(3));
    $task = Task::find($id);
    $activetask = \App\ActiveTask::with('task')->where('task_id', $id)->first();
    //dd($activetask->name);
                
    //$task->dependent_on = json_encode(Input::get('dependent_on')); 
    $user = \App\User::find(Input::get('responsible'));

    $task->start_time = \DateTime::createFromFormat('Y-m-d', Input::get('start_time'));
    $task->stop_time = \DateTime::createFromFormat('Y-m-d', Input::get('stop_time'));

    //dd($task->start_time);
    //$task->update(Input::all());
    $datediff = $task->start_time->diff($task->stop_time);
    if($datediff->days == 0){
       $task->timefortask =  $user->working_time;
   }else{
     $task->timefortask = ($datediff->days+1) * $user->working_time;
    }
    $activetask->name = $task->name;
                $activetask->startdate = $task->start_time ;
                $activetask->stopdate = $task->stop_time;
                $activetask->task_id = $task->id;
                $activetask->activity_id = $task->activity_id;
                $activetask->update(Input::all());
 $task->update(Input::all());
 $project = \App\Project::with('primary_adviser')->where('id',\Auth::getUser()->project_id)->get();
        //dd($project);
         $this->notification('task','แจ้งเตือนการแก้ไขงาน '.$task->name,$project[0]->primary_adviser[0]->id,'นิสิต'. \Auth::user()->first_name .'ได้แก้ไขงาน'.$task->name.
            'ในโครงงาน'.$project[0]->primary_adviser[0]->name);
 return redirect()->back()->with('success','การแก้ไขเสร็จเรียบร้อย');
}





public function getPostponse($id){
    $task = Task::find($id);
            //dd($task->responsible);
    $students = \DB::table('users')->where('role', 'student')->where('id', $task->responsible)->first();
            //dd($students->working_time);


            //dd($students->working_time);
            //$users = $task->responsible;
            //$user = \DB::table('users')->where('id','=', $users)->lists('working_time');
            //$user_time = $user->working_time;
            /*$project = $task->with('task.activity.project')->get();
            dd($project);
            $project[0]->task->activity->project->primary_adviser_id
            ///dd($user);
            */
            return view()->make('task.postponse')->with('task',$task)->with('students',$students);

        }
        public function postPostponse(){
        //$task = Task::find($id);
            $task = Task::with('project.student')->find(Input::get('id'));
        //dd($task->activity_id);
            $user = \DB::table('users')->where('role', 'student')->where('id', $task->responsible)->first();
            //dd($user);
            $start_time = \DateTime::createFromFormat('Y-m-d', $task->start_time);
            ///dd($start_time);
            $stop_time = \DateTime::createFromFormat('Y-m-d', $task->stop_time);
            //dd($stop_time);
            $datediff = date_diff($start_time,$stop_time);
            $task->houroftask = ($datediff->days+1) * ($user->working_time+$task->newtimefortask);
            $task->save();



            //dd($task);
            //$task = Task::find(Input::get('id'));///หาไอดีทาคนี้ๆ
            $task->update(Input::all());
            if (\Auth::user()->role == 'adviser') {
                $this->notification('extendtask', 'แจ้งเตือนผลการขอขยายเวลาการทำงาน ของงาน'.$task->name , $task->responsible,'อาจารย์'. \Auth::user()->first_name .
                    '   '. $task->approve_newtime .'การขอขยายเวลาการทำงาน'.$task->name);


                    if($task->approve_newtime=='อนุมัติ'){
                    //$task->update(['stop_time' => Input::get('newdeadline')]);
                    //$stopdate = $task->stop_time;
                    $task->stop_time = $task->newdeadline;
                    //$task->stop_time = $task->newdeadline;
                    //dd($task->stop_time);
                    //$task->timefortask(['timefortask'=>Input::get('houroftask')]);
                    $task->save();
                    return Redirect::to('project/index')->with('success','อนุมัติและแจ้งเตือนเรียบร้อย');
                    }else{
                      return Redirect::to('project/index')->with('success','อนุมัติและแจ้งเตือนเรียบร้อย');  
                    }

            }else if (\Auth::user()->role == 'student') {
                $project = \App\Project::with('primary_adviser')->where('id',\Auth::getUser()->project_id)->get();
                //dd($task->newdeadline);
                if($task->newdeadline!=''){
                    $this->notification('extendtask', 'แจ้งเตือนการขอขยายเวลาการทำงาน ของงาน'.$task->name , $project[0]->primary_adviser[0]->id,'นิสิต' .\Auth::user()->first_name .
                        'ได้ขอขยายเวลาของงาน'. $task->name .'จากวันที่'.$task->stop_time.'เป็นวันที่'.$task->newdeadline);
                }else{
                    $this->notification('extendtask', 'แจ้งเตือนการขอเพิ่มเวลาการทำงาน ของงาน'.$task->name , $project[0]->primary_adviser[0]->id,'นิสิต' .\Auth::user()->first_name .
                        'ได้ขอเพิ่มเวลาทำงานต่อวันของงาน'. $task->name .'จากเดิมทำงานวันละ'.$task->timefortask.'ชั่วโมง  เป็นทำงานวันละ'.$task->houroftask.'ชั่วโมง');
                }
                return Redirect::to('activity/index')->with('success','เพิ่มข้อมูลและแจ้งเตือนแล้ว');
            } 

        }

        public function postCreate() {
//       
            $user = \App\User::find(Input::get('responsible'));

            $task = new Task;
            $task->dependent_on = json_encode(Input::get('dependent_on')); 
            $task->start_time = \DateTime::createFromFormat('Y-m-d', Input::get('start_time'));
            $task->stop_time = \DateTime::createFromFormat('Y-m-d', Input::get('stop_time'));
            $task->activity_id = Input::get('activity_id');
        ///$task->project_id = Input::get('project_id');
            $datediff = $task->start_time->diff($task->stop_time);
            if($datediff->days == 0){
               $task->timefortask =  $user->working_time;
               $task->timeoftask ='1';
           } else{
             $task->timefortask = ($datediff->days+1) * $user->working_time;
             $task->timeoftask =($datediff->days+1);
             //dd($datediff->days+1);
         }

        // อัพเดทวันล่าสุดของ activity
         $task->name = Input::get('name');
         $task->item_of_task = '1';
         $task->approve = Input::get('approve');
         $task->responsible = Input::get('responsible');
         $task->save();
         $task->activity()->update(['stop_time' => $task->stop_time]);

         $project = \App\Project::with('primary_adviser')->where('id',\Auth::getUser()->project_id)->get();
        //dd($project);
         $this->notification('task','แจ้งเตือนการสร้างงาน '.$task->name,$project[0]->primary_adviser[0]->id,'นิสิต'. \Auth::user()->first_name .'ได้สร้างงาน'.$task->name.
            'ในโครงงาน'.$project[0]->primary_adviser[0]->name);
         return Redirect::to('task/index/' . Input::get('activity_id'))->with('success', 'การเพิ่มข้อมูลสำเร็จ');
// 
     }

     public function getExtendapprove($value,$id){
        //$extendtask = Task::with('task.responsible')->find($id);
        $extendtask = Task::find($id);
        //dd($extendtask->stop_time);
        //Task::with('project.student')->find(Input::get('id'));

        if($value == 0){
            $extendtask->status = 'ไม่อนุมัติการขอขยายเวลา';
            $extendtask->approve_newtime = 'ไม่อนุมัติ';
        }else if($value == 1){
            //$extendtask->status = 'กำลังทำ';
            $extendtask->approve_newtime = 'อนุมัติ';
            $extendtask->stop_time =  $extendtask->newdeadline;

        }
        $extendtask->update();
        $this->notification('extends','แจ้งเตือนผลการขอขยายเวลาการทำงาน ของงาน '.$extendtask->name,$extendtask->responsible,' อาจารย์'. \Auth::user()->first_name .'ได้'.$extendtask->approve_newtime.
            'การขอขยายเวลาการทำงานของงาน'.$extendtask->name);

        return redirect()->back()->with('success','แจ้งเตือนสถานะไปยังนิสิตที่รับผิดชอบแล้ว');
    }


     /*public function postTaskstatus(){
        //$task = Task::find($id);
        $task = Task::with('project.student')->find(Input::get('id'));
        //dd($task);
            $user = \App\Task::find(Input::get('responsible'));
            //dd($user);
            $start_time = \DateTime::createFromFormat('Y-m-d', $task->start_time);
            dd($start_time);
            $stop_time = \DateTime::createFromFormat('Y-m-d', $task->stop_time);
            //dd($stop_time);
            $datediff = date_diff($start_time,$stop_time);
            //dd($datediff);
            //$datediff = $task->start_time->diff($task->stop_time);
            //$task->timefortask = ($datediff->days+1) * ($user->working_time+$task->newtimefortask);
            $task->save();



            //dd($task);
            //$task = Task::find(Input::get('id'));///หาไอดีทาคนี้ๆ
            $task->update(Input::all());
            if (\Auth::user()->role == 'adviser') {
                    $this->notification('extendtask', 'แจ้งเตือนผลการขอขยายเวลาการทำงาน ของงาน'.$task->name , $task->responsible,'อาจารย์'. \Auth::user()->first_name .
                        '   '. $task->approve_newtime .'การขอขยายเวลาการทำงาน'.$task->name);

                    $task->update(['stop_time' => Input::get('newdeadline')]);
                    $task->save();
            
            return redirect()->back()->with('success','อนุมัติและแจ้งเตือนเรียบร้อย');

            }else if (\Auth::user()->role == 'student') {
            //$task = \Project::with('primary_adviser')->where('id',Auth::getUser()->project_id)->get();
            //dd($task);  
            $task->update(Input::all());
            //$user=$task->adviser_id;
            //dd($user);
            /*$this->notification('extendtask', 'แจ้งเตือนการขอขยายเวลาการทำงาน ของงาน'.$task->name , $user,'นิสิต' .\Auth::user()->first_name .
                        'ได้ขอขยายเวลาของงาน'. $task->name .'จากวันที่'.$task->stop_time.'เป็นวันที่'.$task->newdeadline);
            
            return redirect()->back()->with('success','เพิ่มข้อมูลและแจ้งเตือนแล้ว');
            } 

        }*/

        public function getAddtaskitem($id){
            $task = Task::find($id);
            //dd($task->responsible);
            $students = \DB::table('users')->where('role', 'student')->where('id', $task->responsible)->first();
            //dd($students->working_time);
            return view()->make('task.addtaskitem')->with('task',$task)->with('students',$students);
        }

        public function postAddtaskitem(){
        //$task = Task::find($id);
            $task= Task::find(Input::get('id'));
            //dd($task);


            //$task->update();
            if($task->work_status=$task->item_of_task){
               $task->status ='เสร็จแล้ว';
               $task->completed_at =$task->updated_at;
               $task->update(Input::all());
               return redirect()->back()->with('success','เพิ่มข้อมูลและแจ้งเตือนแล้ว')->with('success','งานนี้ได้เสร็จสิ้นแล้ว');
           }
           else{
            $task->update(Input::all());
            return redirect()->back()->with('success','เพิ่มข้อมูลและแจ้งเตือนแล้ว');
        }
    } 

    

}
