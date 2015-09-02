<?php

namespace App\Http\Controllers;

use Request,
DB,
Auth,
Input,
App\Project,
Redirect,
App\User;

class ProjectController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getCreate() {




        $coadvisers = DB::table('users')->where('role', 'adviser')->whereNotIn('id',[Auth::user()->id])->get();
        //dd($coadvisers);
        $dropdown2 ='';
        //dd($adviser);
        foreach ($coadvisers as $coadviser) {
            $dropdown2 .= "<option  value=".$coadviser->id.">" . $coadviser->first_name .' '.$coadviser->last_name. "</option>";

        }
        $students = User::where('role', 'student')->get();
        $dropdown = '';
        foreach ($students as $key => $student) {
            $dropdown .= "<option value='$student->id'>" . $student->first_name.'   ' .$student->last_name. "</option>";
        }
        return view('project.create')->with('dropdown', $dropdown)->with('dropdown2', $dropdown2);
    }

    public function postCreate() {

        $project = Project::create(Input::all());

        $user = User::find(Auth::user()->id);
        //dd($user);
        $user->update(['project_id' => $project->id]);

        if (Input::has('student')){


            //dd($students);
            $students = User::whereIn('id', Input::get('student'));
        //dd($student);
            $students->update(['project_id' => $project->id]);
            //dd();
            //$students =User::where('role','student')->where('project_id',Input::get('student'))->get(); 
            //dd($students);

            foreach ( $students as $student): //วนลูปสร้างการแจ้งเตือน
            $this->notification('project','แจ้งเตือนการสร้างโครงงาน' . $project->name, $user,'อาจารย์'.Auth::user()->first_name.'ได้เพิ่มคุณเป็นนิสิตในโครงงาน'.$project->name.'แล้ว คุณสามารถเริ่มดำเนินการโครงงานได้');
            endforeach;   
        }
        else
        {

        }
        
        if (Input::has('secondary_adviser_id'))://เพิ่มอาจารย์ที่ปรึกษาร่วม
        $project->update(Input::all());
//            $this->notification('project','คุณได้ถูกตั้งให้เป็นที่ปรึกษาร่วมู่โปรเจค' . $project->name,Input::has('secondary_adviser_id'));
        endif;
        return Redirect::to('project/index')->with('success', 'เพิ่มโปรเจคสำเร็จ');

    }

    public function getIndex() {
//        ddd(Auth::user()->project_id);
        if (Auth::user()->role == 'student') {
            $students = User::where('role', 'student')->get();
            //dd($students[0]->project_id);
            $projects = Project::with('secondary_adviser')->where('id', Auth::user()->project_id)->get();
            //dd($students->project_id);

        } elseif (Auth::user()->role == 'adviser') {
            $students = User::where('role', 'student')->get();
            $projects = Project::with('student')
            ->where('primary_adviser_id', Auth::user()->id)
            ->orWhere('secondary_adviser_id', Auth::user()->id)->get();
                            //dd($projects);
        } else {
            $projects = Project::with('secondary_adviser')->get();

        }

        return view('project.index')->with('projects', $projects)->with('students', $students);
    }



    public function getEdit($id) {
        $projects = Project::find($id);
        //dd($projects->secondary_adviser_id);
        $students = DB::table('users')->where('role', 'student')->orWhere('role', 'student')->where('project_id', $id)->get();
        //dd($students);
        //dd($projects->secondary_adviser_id);
        $coadvisers = DB::table('users')->where('role', 'adviser')->whereNotIn('id',[Auth::user()->id])->get();
        //dd($coadvisers);
        $dropdown2 ='';
        //dd($adviser);
        foreach ($coadvisers as $coadviser) {
            //dd($projects->secondary_adviser_id);
            if ($projects->secondary_adviser_id >0) {
                $dropdown2 .= "<option selected='selected' value='.$coadviser->id.''>" . $coadviser->first_name .' '.$coadviser->last_name. "</option>";
            } else {
                $dropdown2 .= "<option value='.$coadviser->id.'>" . $coadviser->first_name .' '.$coadviser->last_name. "</option>";
            }
        }



        $dropdown = '';
        foreach ($students as $student) {
            //dd($student);
            if ($projects->id == $student->project_id) {
                $dropdown .= "<option  selected='selected' value='$student->id'>" . $student->first_name .' '.$student->last_name. "</option>";
            } else {
                $dropdown .= "<option  value='$student->id'>" . $student->first_name .' '.$student->last_name. "</option>";
            }
        }
        //dd($dropdown);

//         ddd($dropdown);
        return view('project.edit')->with('projects', $projects)->with('dropdown', $dropdown)->with('dropdown2', $dropdown2);
        //return view('project.index')->with('projects', $projects)->with('dropdown', $dropdown);
    }

    public function postUpdate() {
        $projects = Project::find(Input::get('id'));
        //dd($projects);
        DB::table('users')
        ->where('project_id', Input::get('id'))
        ->where('role', 'student')
        ->update(['project_id' => 0]);


                 // เปลี่ยนข้อมูลกลับก่อน
        

           /* if (Input::has('secondary_adviser')):
            foreach (Input::get('coadviser') as $key => $coadviser) {//เพิ่มอาจารย์ที่ปรึกษาร่วม
            Project::('id',$coadviser)->update(['secondary_adviser_id'=>$]);
            //dd($secondaryadviser);
//            $this->notification('project','คุณได้ถูกตั้งให้เป็นที่ปรึกษาร่วมู่โปรเจค' . $project->name,Input::has('secondary_adviser_id'));
            endif;*/

            if (Input::has('student')):
            foreach (Input::get('student') as $key => $student) { // แล้วค่อยอัพเดทข้อมูลใหม่
                User::where('id', $student)->update(['project_id' => $projects->id]);
            }
            endif;

            $coadviser = Input::get('secondary_adviser_id'); 
            //dd($coadviser);// แล้วค่อยอัพเดทข้อมูลใหม่
            $projects->update(['secondary_adviser_id' => $coadviser]);            

            $projects->update(Input::all());

            return Redirect::to('project/index')->with('success', 'การแก้ไขเสร็จเรียบร้อย');
        //return Redirect::back()->with('success', 'การแก้ไขเสร็จเรียบร้อย');
        }

        public function getDelete($id) {
        //dd($id);
            $projects = Project::find($id);
            $projects->delete();
            return redirect()->back()->with('warning', 'การลบเสร็จเรียบร้อย');
        }






        function getGantt($id) {
        //dd($id);
      $activitys = \App\Activity::with('activetask')->where(['project_id'=> $id])->get();//,'task.approve'=>'อนุมัติแล้ว'
        /*//if()
        //print_r($activity);die();
        //dd($activitys);


        foreach ($activitys as $key => $activity):
            //dd($key);
            $data[$key]['id'] = $activity->id;
            $data[$key]['name'] = $activity->name;
            if($activity->activetask):
            foreach ($activity->activetask as $key2 => $activetask):
                //dd($activity->activetask->toArray());
                //dd($task);
                //if($task->approve =='อนุมัติแล้ว'){
                $data[$key]['series'][$key2]['name'] = $activetask->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($activetask->startdate));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($activetask->stopdate));
            //}else{
            //}
            endforeach;
            endif;
        endforeach;
        //dd($activity->activetask->toArray());
        dd($data);*/
        return view('project.ganttdata')->with('id', $id)->with('activitys', $activitys);

    }
    function getGanttt($id) {

        /*$activitys = \App\Activity::with('activetask')->where(['project_id'=> $id])->get();//,'task.approve'=>'อนุมัติแล้ว'
        //if()
        //print_r($activity);die();
        //dd($activitys);


        foreach ($activitys as $key => $activity):
            //dd($key);
            $data[$key]['id'] = $activity->id;
            $data[$key]['name'] = $activity->name;
            foreach ($activity->activetask as $key2 => $activetask):
                //dd($activity->activetask);
                //dd($task);
                //if($task->approve =='อนุมัติแล้ว'){

                $data[$key]['series'][$key2]['name'] = $activetask->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($activetask->startdate));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($activetask->stopdate));
                $data[$key]['series'][$key2]['color'] = "#ADFF2F";
            //}else{
            //}else{

            //}

            endforeach;
        endforeach;*/
        $activity = \App\Activity::with('task')->where(['project_id'=> $id])->get();//,'task.approve'=>'อนุมัติแล้ว'
        foreach ($activity as $key => $activity):
            //dd($key);
            $data[$key]['id'] = $activity->id;
            $data[$key]['name'] = $activity->name;
            foreach ($activity->task as $key2 => $task):
                if($task->approve =='รอ'){
                $data[$key]['series'][$key2]['name'] = $task->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($task->start_time));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($task->stop_time));
                $data[$key]['series'][$key2]['color'] = "#f0ad4e";
            }elseif($task->approve =='อนุมัติแล้ว'&& $task->status!='มีการขอขยายเวลาทำงาน'){
                $data[$key]['series'][$key2]['name'] = $task->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($task->start_time));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($task->stop_time));
                $data[$key]['series'][$key2]['color'] = "#5bc0de";
            }elseif($task->approve =='ไม่อนุมัติแล้ว'){
                $data[$key]['series'][$key2]['name'] = $task->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($task->start_time));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($task->stop_time));
                $data[$key]['series'][$key2]['color'] ="#adadad" ;
            }elseif($task->status=='เสร็จแล้ว'){
                $data[$key]['series'][$key2]['name'] = $task->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($task->start_time));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($task->stop_time));
                $data[$key]['series'][$key2]['color'] = "#5cb85c";
            }elseif($task->approve =='อนุมัติแล้ว'&& $task->status=='มีการขอขยายเวลาทำงาน'&& $task->approve_newtime!='ไม่อนุมัติ'){
                $data[$key]['series'][$key2]['name'] = $task->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($task->start_time));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($task->stop_time));
                $data[$key]['series'][$key2]['color'] = "#d9534f";
            }
            else{
                $data[$key]['series'][$key2]['name'] = $task->name;
                $data[$key]['series'][$key2]['start'] = date('F d, Y H:i:s', strtotime($task->start_time));
                $data[$key]['series'][$key2]['end'] = date('F d, Y H:i:s', strtotime($task->stop_time));
                $data[$key]['series'][$key2]['color'] ="#adadad" ;

            }

            endforeach;
        endforeach;

                return \Response::json($data);
            }

        }
