<?php

namespace App\Http\Controllers;

use Request,
DB,
Auth,
Input,
View,
App\Appointment,
Redirect,
App\Project,
App\User;

class AppointmentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getLists() {
        $appointment = Appointment::where('project_id', Input::get('id'))->get();
//dd($appointment);
        //$user= User::where('role','student')->where('id',$appointment->student_id)->first();
        //echo($appointment->student_id);
        //dd($appointment->student_id->first_name);
        $table = '';
        foreach ($appointment as $appointment):
            $table .= '<tr>';
        $table .= '<td>' . $appointment->title . '</td>';
            //$table .= '<td class="readmore">' . substr($appointment->detail,0,100) . '</td>';//กำหนดให้แสดงความยาวตัวอักษร100

        $table .= '<td>' . '<button class="btn btn-info appointment_detail" id='. $appointment->id.' >ดูรายละเอียด</button> ' . '</td>';
                        
        $table .= '<td>' . $appointment->approve . '</td>';



        if($appointment->status!='เข้าพบแล้ว'){
            $table .= '<td><select class="chosen1" id=' . $appointment->id . '>'
            . '<option   value="รอการตอบรับ">รอการตอบรับ</option>';
            if ($appointment->approve == 'เข้าพบได้แล้ว') {
                $table .= '<option  selected="selected" value="เข้าพบได้">เข้าพบได้</option>';
            } else {
                $table .= '<option  value="เข้าพบได้">เข้าพบได้</option>';
            }
            if ($appointment->approve == 'ไม่ว่าง') {
                $table .= '<option selected="selected"  value="ไม่ว่าง">ไม่ว่าง</option>';
            } else {
                $table .= '<option value="ไม่ว่าง">ไม่ว่าง</option>';
            }
            $table .= '</select>';
        }else{
            $table .= '<td>'.'</td>'; 
        }



        $table .= '<td>' . $appointment->status . '</td>';
        if($appointment->status!='เข้าพบแล้ว'){
        $table .= '<td><select class="chosen2" id=' . $appointment->id . '>'
        . '<option   value="รอการตอบรับ">รอการตอบรับ</option>';
        if ($appointment->status == 'เข้าพบแล้ว') {
            $table .= '<option  selected="selected" value="เข้าพบแล้ว">เข้าพบแล้ว</option>';
        } else {
            $table .= '<option  value="เข้าพบแล้ว">เข้าพบแล้ว</option>';
        }
        if ($appointment->status == 'ไม่มาพบตามนัด') {
            $table .= '<option selected="selected"  value="ไม่มาพบตามนัด">ไม่มาพบตามนัด</option>';
        } else {
            $table .= '<option value="ไม่มาพบตามนัด">ไม่มาพบตามนัด</option>';
        }
        $table .= '</select>';
       } else
            {
               $table .= '<td>'.'</td>';  
           }
        if($appointment->status!='เข้าพบแล้ว'){
            $table .= '<td>' . '<a href="/appointment/edit/'.$appointment->id.'" class="btn btn-warning">
            <i class="glyphicon glyphicon-edit"></i>แก้ไข</a>' . 
            '<a href="/appointment/postponse/' .$appointment->id.'" class="btn btn-primary">
            <i class="glyphicon glyphicon-pencil"></i>เลื่อน</a>' .
            '<a href="/appointment/delete/' .$appointment->id.'" class="btn btn-danger">
            <i class="glyphicon glyphicon-trash"></i>ลบ</a>' .
            '</td>';}
            else
            {
               $table .= '<td>'.'</td>';  
           }
           $table .= '<tr>';
           endforeach;

           echo $table;
           return $appointment->id;
       }

    public function getDetail() {

        $appointment = Appointment::find(Input::get('id'));
        $users= User::where('role','student')->where('id',$appointment->student_id)->first();
        //dd($users->first_name);
        $strDate = $appointment->due_date ;
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        $strDates ="$strDay $strMonthThai $strYear";

        $table = '';
        $table .= '<tr>';
        $table .= '<td>' . $appointment->detail . '</td>';
        $table .= '<td>' . $appointment->location . '</td>';
        $table .= '<td>' . $strDates . '</td>';
        $table .= '<td>' . $appointment->appoint_time . '</td>';
        $table .= '<td>' . $users->first_name.' '.$users->last_name. '</td>';
        $table .= '<tr>';
        echo $table;
    }




//ฟังก์ชั้นเปลี่ยนการยันยันการนัดหมาย
       public function getApprovestatus() {
        $app = Appointment::find(Input::get('id'));
        //เมื่อมีการเปลี่ยนสถานะให้ไปอัตเดตที่ค่าapproveในฐานข้อมูล โดยอัพเดพตามค่าstatusที่ส่งมา
        $app->update(['approve' => Input::get('status')]);
        //dd(status);
        
        $app->save();
        
        
    }
//ฟังก์ชั้นการมาเข้าพบตามนัด
    public function getAppointmentstatus() {
        $app = Appointment::find(Input::get('id'));
        //เมื่อมีการเปลี่ยนสถานะให้ไปอัตเดตที่ค่าstatusในฐานข้อมูล โดยอัพเดพตามค่าstatusที่ส่งมา
        $app->update(['status' => Input::get('status')]);
        $app->save();
        //dd(status);


    }

    public function getIndex() {    

        //$today = getdate();
        //dd($today);
        //$day = $today['mday'];
        //$month = $today['mon'];
        //$year = $today['year'];
        //$datenow = $year."-".'0'.$month."-".$day;
        //dd($datenow);


        if (Auth::user()->role == 'adviser') {
            //$appointment = Appointment::where('project_id', Input::get('id'))->get();
            $projects = Project::with('appointment')->where('primary_adviser_id', Auth::user()->id)
            ->orWhere('secondary_adviser_id', Auth::user()->id)->get();
            //dd($projects->values());
            
            if($projects->toArray(0)){

            $allappointments = Appointment::with('student')->where('adviser_id', Auth::user()->id)->where('project_id', Input::get('id'))->get();
            $app = Appointment::where('adviser_id', Auth::user()->id);
            $app_total = $app->count();
            $go_total = $app->where('status', 'เข้าพบแล้ว')->count();
            $nogo_total = $app->where('status', 'ไม่มาพบตามนัด')->count();
            foreach ($projects as $key => $project) {
                $appointments = Appointment::where('project_id', $project->id)->get();
                foreach ($appointments as $key => $appointment) {
                    if($appointment->approve=='เข้าพบได้'):
                        $users = \App\User::where('project_id', \Auth::user()->project_id)->where('role', 'student')->get();
                    foreach ($users as $key => $user) {
                        $this->notification('appointment', 'แจ้งเตือนการตอบรับการนัดหมาย'.$appointment->title , $user->id,'อาจารย์'. \Auth::user()->first_name .
                            'ตอบรับการนัดหมาย'. $appointment->title .'ว่า'.$appointment->approve);
                    }
                    $appointment->approve = 'เข้าพบได้แล้ว';
                    $appointment->update();
                    endif;
                }
            }
            return view()->make('appointment.adviser')->with(['projects' => $projects, 'app_total' => $app_total,
                'go_total' => $go_total, 'nogo_total' => $nogo_total,'allappointments'=>$allappointments]);
        }else{
            return redirect()->back()->with('warning', 'คุณยังไม่มีโปรเจคให้นัดหมาย');
        }


        } else if (Auth::user()->role == 'student') {
            $appointments = Appointment::with('adviser')->where('student_id', Auth::user()->id)->get();
            //dd($appointments);
            //$app = Appointment::where('project_id', Auth::user()->id)->orWhere('student_id', Auth::user()->id);
            $app = Appointment::where('student_id', Auth::user()->id);
            $app_total = $app->count();
            $go_total = $app->where('status', 'เข้าพบแล้ว')->count();
            $nogo_total = $app->where('status', 'ไม่มาพบตามนัด')->count();
            return view()->make('appointment.index')
            ->with(['appointments' => $appointments, 'app_total' => $app_total,
                'go_total' => $go_total, 'nogo_total' => $nogo_total]);
        }
    }

    public function getCreate() {
        if(Auth::getUser()->role == 'adviser'){
           $today = getdate();
        //dd($today);
           $day = $today['mday'];
           $month = $today['mon'];
           $year = $today['year'];
           $datenow = $year."-".'0'.$month."-".$day;
           $project = DB::table('project')->where('primary_adviser_id', Auth::user()->id)
           ->orWhere('secondary_adviser_id', Auth::user()->id)->lists('name', 'id');
            //dd($project);
           return view()->make('appointment.create')->with('project',$project)->with('datenow',$datenow);

       }elseif (Auth::getUser()->role == 'student') {
           $today = getdate();
        //dd($today);
           $day = $today['mday'];
           $month = $today['mon'];
           $year = $today['year'];
           $datenow = $year."-".'0'.$month."-".$day;
           $project = Project::with('primary_adviser','secondary_adviser')->where('id',Auth::getUser()->project_id)->get();
           $dropdown = '';
            //dd($project[0]->secondary_adviser,$project[0]->primary_adviser[0]);
           if($project[0]->primary_adviser_id !=0 && $project[0]->secondary_adviser_id !=0){
            $dropdown .= "<option value=".$project[0]->primary_adviser[0]->id.">".'อาจารย์'.$project[0]->primary_adviser[0]->first_name.'   '.$project[0]->primary_adviser[0]->last_name."</option>";

            if($project[0]->primary_adviser){
                $dropdown .= "<option value=".$project[0]->secondary_adviser[0]->id.">".'อาจารย์'.$project[0]->secondary_adviser[0]->first_name.'   '.$project[0]->secondary_adviser[0]->last_name."</option>";
            }
        }elseif($project[0]->primary_adviser){
            $dropdown .= "<option value=".$project[0]->primary_adviser[0]->id.">".'อาจารย์'.$project[0]->primary_adviser[0]->first_name.'   '.$project[0]->primary_adviser[0]->last_name."</option>";

        }else{ }
        return view()->make('appointment.create')->with(['dropdown'=>$dropdown])->with('datenow',$datenow);
    }
}

public function postCreate() {
    if (Auth::user()->role == 'adviser') {
        $users = User::where('role','student')->where('project_id',Input::get('project_id'))->get();
        //dd($users);
        foreach ($users as $key => $user) {
            //dd($user);
            $appointment = Appointment::create(Input::all());
            $appointment->student_id = $user->id;
            $appointment->update();

            $this->notification('appointment', 'แจ้งเตือนนัดหมาย ' . 
                $appointment->title, $user->id,' รายละเอียดการนัดหมาย :' . $appointment->detail. 'สถานที่นัดพบ ' . $appointment->location .
                ' เวลา ' . $appointment->due_date);
        }
    }else if (Auth::user()->role == 'student') {
        // dd(Input::get('adviser_id'));
        $appointment = Appointment::create(Input::all());
        //dd($this); 
        $this->notification('appointment', 'แจ้งเตือนนัดหมาย ' . $appointment->title, $appointment->adviser_id,' รายละเอียดการนัดหมาย :' . $appointment->detail. 'สถานที่นัดพบ ' . $appointment->location .
            ' เวลา ' . $appointment->due_date);
    }

    return Redirect::to('appointment/index')->with('success', 'เพิ่มนัดหมายและแจ้งเตือนเรียบร้อยแล้ว');
}


//ฟังก์ชั้นสร้างการแจ้งเตือนสิทธิผลการเข้าสอบโครงงาน
public function getCreateexams() {
        //เป็นการgetค่าโปรเจคออกมาจากฐานข้อมูล
    $project = DB::table('project')->where('primary_adviser_id', Auth::user()->id)
    ->orWhere('secondary_adviser_id', Auth::user()->id)->lists('name', 'id');
        //$project = DB::table('project')->where('id', Auth::user()->project_id)->lists('name', 'id');
        //รีเทิร์นค่ากลับไปหน้าสร้างการแจ้งเตือนสิทธิผลการเข้าสอบโครงงาน
    $today = getdate();
        //dd($today);
           $day = $today['mday'];
           $month = $today['mon'];
           $year = $today['year'];
           $datenow = $year."-".'0'.$month."-".$day;
    return view()->make('appointment.createexams')->with('project', $project)->with('datenow',$datenow);
}
//ฟังก์ชั้นหลังจากสร้างการแจ้งเตือนสิทธิผลการเข้าสอบโครงงานแล้ว
public function postCreateexams() {
        //dd(Input::all()); 
        //กำหนดตัวแปรappointmentเท่ากับค่าของidโปรเจคที่ได้สร้างการแจ้งเตือน
    $appointment = Appointment::where('project_id',Input::get('project_id'))->get();
        //dd($appointment);
        //กำหนดตัวแปรuserคือสมาชิกที่เป็น นักเรียนในโปรเจค
    $users = User::where('role', 'student')->where('project_id', $appointment[0]->project_id)->get();

        //ทำการวนลูปแจ้งเตือน Input::get('???')คือการรับค่ามาจากฟอร์มCreateexams
    foreach ($users as $user):
        $this->notification('appointment', 'แจ้งเตือน ' . 
            Input::get('title'), $user->id, ' รายละเอียด :' . Input::get('detail') .
            ' วันเวลาที่สอบ ' . Input::get('due_date') . 'สถานที่สอบ ' . Input::get('location') );
    endforeach;
        //dd($appointment);
        //เมื่อสร้างเสร็จแล้ว กลับไปยังหน้าการนัดหมายและแสดงข้อความ
    return Redirect::to('appointment/index')->with('success', 'เพิ่มการแจ้งเตือนสิทธิการเข้าสอบเรียบร้อย');
}

public function getEdit($id) {
        //$project = Project::with('primary_adviser','secondary_adviser')->where('id',Auth::getUser()->project_id)->get();
    $appointment = Appointment::find($id);
    $project = DB::table('project')->lists('name', 'id');
    return view('appointment.edit')->with('appointment', $appointment)->with('project', $project);
}

public function postEdit() {
    $appointments = Appointment::with('project.student')->find(Input::get('id'));
        //dd($appointments);
    $appointments->update(Input::all());
    if (Auth::user()->role == 'adviser') {
        foreach ($appointments->project->student as $student):
            $this->notification('appointment', 'อาจารย์' . Auth::user()->first_name . ' ได้แก้ไขข้อความการนัดหมาย'
                , $student->id, 'สถานที่นัดพบ ' . $appointments->location .
                ' วันและเวลา ' . $appointments->due_date . ' รายละเอียดเพิ่มเติม :' . $appointments->detail);
        endforeach;

    }else if (Auth::user()->role == 'student') {
        $appointments = Appointment::with('project.primary_adviser','project.secondary_adviser')->find(Input::get('id'));
        //dd($appointments);  
        $appointments->update(Input::all());
        $user=$appointments->adviser_id;
        //dd($user);
        $this->notification('appointment', 'นิสิต' . Auth::user()->first_name . ' ได้แก้ไขข้อความการนัดหมาย'
            , $user, 'สถานที่นัดพบ ' . $appointments->location .
            ' วันและเวลา ' . $appointments->due_date . ' รายละเอียดเพิ่มเติม :' . $appointments->detail);
    }
       /* if ($appointments->approve == 'เข้าพบได้'):
            foreach ($appointments->project->student as $student):
                $this->notification('appointment', 'สามารถเข้าพบอาจารย์' . Auth::user()->first_name . ' ได้'
                        , $student->id, 'สถานที่นัดพบ ' . $appointments->location .
                        ' วันและเวลา ' . $appointments->due_date . ' รายละเอียดเพิ่มเติม :' . $appointments->detail);
            endforeach;
            endif;*/
            return Redirect::to('appointment/index')->with('success', 'การแก้ไขและการแจ้งเตือนเสร็จเรียบร้อย');
        }

        public function getDelete($id) {
        //dd($id);
            $appointments = Appointment::find($id);
        //dd()
        //dd($appointments->adviser_id);
            $appointments->delete();
        //return View::make('appointment.edit')->with('warning', 'การลบเสร็จเรียบร้อย');
            if (Auth::user()->role == 'adviser') {
                foreach ($appointments->project->student as $student):
                    $this->notification('appointment', 'อาจารย์' . Auth::user()->first_name . 'ได้ลบการนัดหมายหัวข้อ' . $appointments->title,$student->id ,
                        'การนัดหมายหัวข้อ' . $appointments->title . 'วันที่' . $appointments->due_date . '  ได้ถูกยกเลิกแล้ว');
                endforeach;
            }else if (Auth::user()->role == 'student') {
                $this->notification('appointment', 'นิสิต' . Auth::user()->first_name . 'ได้ลบการนัดหมายหัวข้อ' . $appointments->title, $appointments->adviser_id ,
                    'การนัดหมายหัวข้อ' . $appointments->title . 'วันที่' . $appointments->due_date . '  ได้ถูกยกเลิกแล้ว');
            }
            return redirect()->back()->with('warning', 'การลบเสร็จเรียบร้อย');
        }

        public function getPostponse($id) {
            $appointment = Appointment::find($id);
            $project = DB::table('project')->lists('name', 'id');
             $today = getdate();
            $day = $today['mday'];
            $month = $today['mon'];
            $year = $today['year'];
            $datenow = $year."-".'0'.$month."-".$day;
            return view('appointment.postponse')->with('appointment', $appointment)->with('project', $project)->with('datenow',$datenow);
        /*if (Request::isMethod('post')):
            $postponse = \App\Postponse::create(Input::all());
            foreach ($postponse->appointment->project->student as $student):
                $this->notification('postponse', 'เลื่อนการนัดหมาย', $student->id, 'เลื่อนไปเป็นวันที่ ' .
                        $this->DateThai($postponse->timetogo) . ' สถานที่ ' . $postponse->location . ' เพราะ ' . $postponse->reason);
            endforeach;
            return redirect()->route('appointment.index')->with('success', 'แจ้งเตือนไปยังสมาชิกในกลุ่มแล้ว');
        endif;

        return view('appointment/postponse');*/
    }

    public function postPostponse() {
        $appointments = Appointment::with('project.student')->find(Input::get('id'));
        //$appointments->due_date == $appointments->postponse_date;
        //dd($appointments->postponse_date);
        
        $appointments->update(Input::all());

        if (Auth::user()->role == 'adviser') {
            foreach ($appointments->project->student as $student):
                $this->notification('postponse', 'อาจารย์' . Auth::user()->first_name . 'ได้เลื่อนการนัดหมาย' . $appointments->title,$student->id ,
                    'เลื่อนการนัดหมายจากวัน' . $appointments->due_date . 'เป็นวัน' . $appointments->postponse_date . 'เนื่องจาก :' . $appointments->message);
            endforeach;
        }else if (Auth::user()->role == 'student') {
            $appointments = Appointment::with('project.primary_adviser','project.secondary_adviser')->find(Input::get('id')); 
            $user=$appointments->adviser_id;
            $this->notification('postponse', 'นิสิต' . Auth::user()->first_name . 'ได้เลื่อนการนัดหมาย' . $appointments->title,$user ,
                'จากวัน' . $appointments->due_date . 'เป็นวัน' . $appointments->postponse_date . 'นื่องจาก :' . $appointments->message);
        }




        $appointments->update(['due_date' => Input::get('postponse_date')]);
        $appointments->update(['appoint_time' => Input::get('appoint_new_time')]);
        $appointments->save();
       /* $postponse = \App\Postponse::create(Input::all());
        //return redirect()->route('appointment/index')->with('success', 'เลื่อนนัดเเล้ว');*/
       return Redirect::to('appointment/index')->with('success', 'เลื่อนนัดเเล้ว');
   }

}
