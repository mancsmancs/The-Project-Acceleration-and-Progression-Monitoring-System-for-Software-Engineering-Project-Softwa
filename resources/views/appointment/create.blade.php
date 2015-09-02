@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เพิ่มข้อมูล การนัดหมาย</div>
                <div class="panel-body">
                    {!! Form::open(['to'=>'appointment/create','class'=>'form-horizontal']) !!}
                    <fieldset>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">หัวข้อ</label>  
                            <div class="col-md-5">
                                <input id="name" name="title" type="text" placeholder="" class="form-control validate[required] input-md">
                            </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="detail">รายละเอียด</label>
                            <div class="col-md-5">                     
                                <textarea class="form-control validate[required]" col="70" rows="10" id="detail" name="detail"></textarea>
                            </div>
                        </div>


                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="start">วันที่จะนัด</label>  
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="date" id="DATE" data-date-format="DD MMMM YYYY" class="input-sm form-control validate[required]" name="due_date" min="{{$datenow}}"/>
                                    <span class="input-group-addon">เวลา</span>
                                    <input type="time"  class="input-sm form-control validate[required]" name="appoint_time" min=08:00 max=18:00 />
                                </div>   
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="stop">สถานที่</label>  
                            <div class="col-md-5">
                                <input id="location" name="location" type="text" placeholder="" class="form-control validate[required] input-md">

                            </div>
                        </div>
                        @if(Auth::user()->role == 'student')
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="co-adviser">นัดกับ</label>
                            <div class="col-md-5">

                                <div class="input-group">

                                    {!! Form::hidden('project_id',Auth::user()->project_id)!!}
                                    {!! Form::hidden('student_id',Auth::user()->id)!!}
                                    <select name='adviser_id' class="chosen">
                                        {!! $dropdown !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(Auth::user()->role == 'adviser')
                        <!-- Search input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="co-adviser">นัดกับกลุ่ม</label>
                            <div class="col-md-5">

                                <div class="input-group">
                                    {!! Form::hidden('approve','เข้าพบได้') !!}
                                    {!! Form::hidden('adviser_id',Auth::user()->id)!!}
                                    {!! Form::select('project_id',$project,'',['class'=>'form-control validate[required]
                                    input-md','id'=>'appoint_group']) !!}
                                    
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- Button -->
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-4">
                                <button id="singlebutton" name="singlebutton" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span>บันทึก</button>
                                <button class="btn btn-danger " type="reset" value="Reset">ยกเลิก</button>
                            </div>

                        </div>
                        
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('specific_script')
<script type="text/javascript">
$('#datepicker').datepicker({
    format: "yyyy-mm-dd" ,
    language: 'th',
    //todayHighlight: true,
    orientation: "bottom left",
    startDate: 'getdate()',
    //todayBtn:true
});
$("#appoint_group").chosen();

function myFunction() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    var today = dd+'/'+mm+'/'+yyyy;
    document.getElementById("DATE").value = today;

    
}


</script>

@stop