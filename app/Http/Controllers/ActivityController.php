<?php

namespace App\Http\Controllers;

use DB,
    Input,
    App\Activity,
    App\Task,
    App\User,
    App\Project,
    Auth,
    Redirect;

class ActivityController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getCreate() {
        return view('activity.create');
    }

    function getLists() {
        $actvties = Activity::where('project_id',\Request::get('id'))->get();
//        ddd($activitys);
        $table = '';
        foreach ($actvties as $activity):
             $table .= '<tr>';
            $table .= '<td>' . $activity->name . '</td>';
            $table .= '<td>' . $activity->start_time . '</td>';
            $table .= '<td>' . $activity->stop_time . '</td>';
               $table .= '<td>' . $activity->responsible_user->first_name . '</td>';
            $table .= '<td>' . $activity->approve . '</td>';
            $table .= '<td> <button class="btn btn-primary task_list" id="'.$activity->id.'" >
                              <i class="glyphicon glyphicon-tasks"></i> ดู task</button>  ' ;
            $table .= '</tr>';
        endforeach;

        echo $table;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex($id = null) {
        if (Auth::user()->role == 'adviser') {
            $projects = Project::with('activity')->find($id);
            return view()->make('activity.index')->with(['projects' => $projects]);
        } else if (Auth::user()->role == 'student') {
            $projects = Project::with('activity')->find(Auth::user()->project_id);
            return view()->make('activity.index')->with(['projects' => $projects]);
            //return view('notification.index')->with('notification', $notification);
        }
    }
  public function getEdit($id) {
        $activity = Activity::find($id);
        $students = User::where('role', 'student')->where('project_id', $activity->project_id)->get();
        //dd($students);
        /*$dropdown = '';
        foreach ($students as $key => $student) {
            if ($activity->project_id == $student->project_id) {
                $dropdown .= "<option  selected='selected' value='$student->id'>" . $student->first_name . "</option>";
            } else {
                $dropdown .= "<option value='$student->id'>" . $student->first_name . "</option>";
            }
        }*/
        return view('activity.edit')->with('activity', $activity);
    }
    
       public function postEdit() {
        $activity = Activity::find(Input::get('id'));
        //dd($activity);
        $activity->update(Input::all());
        return Redirect::to('activity/index')->with('success', 'การแก้ไขเสร็จเรียบร้อย');
    }
    public function getSelectuser() {
        $result = User::where('project_id', Input::get('id'))->where('role', 'student')->select('id', 'first_name')->get();
        $project = Project::find(Input::get('id'));

        $dropdown = '<option value=""></option>';
        foreach ($result as $result):
            $dropdown .= '<option value="' . $result->id . '">' . $result->first_name . '</option>';
        endforeach;
        $data = ['dropdown' => $dropdown, 'start' => $project->start, 'finish' => $project->finish];
        return $data;
    }

    public function postCreate() {

        $Activity = new Activity;
        $Activity->name = Input::get('activity_name');
        $Activity->start_time = \DateTime::createFromFormat('Y-m-d', Input::get('task_start'));
        $Activity->stop_time = \DateTime::createFromFormat('Y-m-d', Input::get('task_finish'));
        $Activity->project_id = Input::get('project_id');
        $Activity->user_id = Auth::user()->id;
        $Activity->save();

        $task = new Task;
        $task->name = Input::get('task_name');
        $task->item_of_task = '1';
        $task->start_time = \DateTime::createFromFormat('Y-m-d', Input::get('task_start'));
        $task->stop_time = \DateTime::createFromFormat('Y-m-d', Input::get('task_finish'));
        $task->activity_id = $Activity->id;
        $user = \App\User::find(Input::get('responsible'));
        $datediff = $task->start_time->diff($task->stop_time);
           if($datediff->days == 0){
           $task->timefortask =  $user->working_time;
        } else{
             $task->timefortask = ($datediff->days+1) * $user->working_time;
             $task->timeoftask =$datediff->days+1;
        }
        $task->responsible = Input::get('responsible');
        $task->approve = Input::get('approve');
        $task->save();
         $task->dependent_on = Input::get('dependent_on');
        return Redirect::to('activity/index/'.$Activity->project_id)->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    /*public function edit($id) {
        $activity = Activity::find($id);
        $students = User::where('role', 'student')->where('project_id', $activity->project_id)->get();

        $dropdown = '';
        foreach ($students as $key => $student) {
            if ($activity->project_id == $student->project_id) {
                $dropdown .= "<option  selected='selected' value='$student->id'>" . $student->first_name . "</option>";
            } else {
                $dropdown .= "<option value='$student->id'>" . $student->first_name . "</option>";
            }
        }
        // ddd($dropdown);
        return view('activity.edit')->with('activity', $activity)->with('dropdown', $dropdown);
    }

    public function update() {
        // ddd(Input::all());
        $activity = Activity::find(Input::get('id'));
        $activity->update(Input::all());
        return Redirect::back()->with('success', 'การแก้ไขเสร็จเรียบร้อย');
    }*/

    public function getDelete($id) {
        $activity = Activity::find($id);
        $activity->delete();
       
            
            return redirect()->back()->with('success', 'ลบเรียบร้อย');
        
            
        
    }

}
