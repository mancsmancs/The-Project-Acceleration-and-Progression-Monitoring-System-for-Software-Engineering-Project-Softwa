@extends('app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                
                @if(Auth::user()->role == 'adviser')
                <div class="panel-heading">ประวัติผู้ใช้ของอาจารย์</div>
                @else
                <div class="panel-heading">ประวัติผู้ใช้ของนิสิต</div>
                @endif
                <form class="form-horizontal" method="post"
                      enctype="multipart/form-data" 
                      action="{{ route('profile')}}">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput"></label>  
                            <div class="col-md-4"> 
                                @if(Auth::user()->profile_image)
                                <img class="img-thumbnail" src="{!! '/public/upload/photo/'.Auth::user()->profile_image !!}" >
                                @else 
                                <img class="img-thumbnail" src="/public/upload/photo/default.png" >
                                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">รูประจำตัว</label>  
                            <div class="col-md-4"> 
                                <input type="file" name="profile" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">ชื่อ</label>  
                            <div class="col-md-4"> 
                                <input type="text" name="first_name"  value="{{ Auth::user()->first_name }}"class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">นามสกลุ</label>  
                            <div class="col-md-4"> 
                                <input type="text" name="last_name"  value="{{ Auth::user()->last_name}}"  class="form-control" >
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">email</label>  
                            <div class="col-md-4"> 
                                <input type="email" value="{{ Auth::user()->email}}" name="email" class="form-control" >
                            </div>-->


                    

                        @if(Auth::user()->role == 'student')
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="woringtime">เวลาทำงาน</label>  
                            <div class="col-md-3">
                                <input name="working_time" value="{{ Auth::user()->working_time}}"
                                       class="  form-control input-md" id="working_time" type="text" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="woringtime">เวลาพัก</label>  
                            <div class="col-md-3">
                                <input name="non_working_time" value="{{ Auth::user()->non_working_time}}"
                                       class="  form-control input-md" id="non_working_time" type="text" placeholder=""
                            </div>
                        </div>
                        @endif   
                        <!--<div class="form-group">
                        <p id="demo"></p>
                         </div>   -->          
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput"></label>  
                            <div class="col-md-4"> 
                                <button type="submit"  class="btn btn-primary" >บันทึก</button>

                                
                                <!--<button class="btn btn-primary " type="button" onclick="myFunction()">ยกเลิก</button>-->
                                <button class="btn btn-primary " type="reset" value="Reset">ยกเลิก</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('specific_script')
<script>

    $("input[type=file]").fileinput({
        showCaption: false, 
        showUpload: false, 
        maxFileCount: 1, 
        mainClass: "input-group-lg"});
</script>

<script>
var myVar = setInterval(function(){ myTimer() }, 1000);

function myTimer() {
    var d = new Date();
    var t = d.toLocaleTimeString();
    document.getElementById("demo").innerHTML = t;
}

function myStopFunction() {
    clearInterval(myVar);
}
</script>
<script>
function myFunction() {
    location.reload();
}
</script>



@stop