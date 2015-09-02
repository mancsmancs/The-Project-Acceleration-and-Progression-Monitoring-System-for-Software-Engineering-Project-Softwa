@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-4 control-label">ชื่อ</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control validate[required]" name="first_name" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">นามสกุล</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control validate[required]" name="last_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control validate[required]" name="email" >
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-4 control-label">ชื่อผู้ใช้งาน</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control validate[required]" name="username" value="{{ old('username') }}">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-md-4 control-label">รหัสผ่าน</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control validate[required]" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">ยืนยันรหัสผ่าน</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control validate[required]" name="confirm_password">
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-md-4 control-label">สถานะ</label>
                            <div class="col-md-6">
                                <div class="col-sm-6">
                                    <div class="radio">
                                        <input type="radio" name="role" value="adviser" id="radio1">
                                        <label for="radio1">
                                            อาจารย์
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="role" value="student" id="radio2">
                                        <label for="radio2">
                                            นิสิต
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!--<div id="student-input" style="display:none;">
                          <div class="form-group">
                            <label class="col-md-4 control-label">เวลาทำงาน(ชั่วโมง/วัน)</label>
                            <div class="col-md-6">
                                <input type="number" min="1" max="24" class="form-control" name="working_time">
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-md-4 control-label">เวลาที่ไม่ทำงาน(ชั่วโมง/วัน)</label>
                            <div class="col-md-6">
                                <input type="number" min="1" max="24" class="form-control" name="non_working_time">
                            </div>
                        </div>
                        </div>-->
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    สมัครสมาชิก
                                </button>
                                <button class="btn btn-danger " type="reset" value="Reset">ยกเลิก</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('specific_script')
<script>
    $('.form-horizontal input').on('change', function() {
   var val =$('input[name=role]:checked', '.form-horizontal').val(); 
   if(val == 'student'){
       $('#student-input').show("slow")
   }else{
       $('#student-input').hide("slow")
   }
});
    
  </script>

@stop
