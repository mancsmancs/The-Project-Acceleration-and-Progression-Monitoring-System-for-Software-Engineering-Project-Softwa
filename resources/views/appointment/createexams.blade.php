@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เพิ่มข้อความแจ้งสิทธิการเข้าสอบโครงงาน</div>
                <div class="panel-body">
                    {!! Form::open(['to'=>'appointment/createexams','class'=>'form-horizontal']) !!}
                    <fieldset>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">หัวข้อ</label>  
                            <div class="col-md-5">          
                                <input id="name" name="title" type="text" placeholder="" value="ผลสิทธิการเข้าสอบโครงงาน"class="form-control validate[required] input-md"></input>
                            </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">       
                            <label class="col-md-4 control-label" for="detail">รายละเอียดผลการเข้าสอบ</label>
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
                                    <input type="time"  class="input-sm form-control validate[required]" name="appoint_time" min=8:00 max=18:00 />
                                </div>   
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="stop">สถานที่สอบ</label>  
                            <div class="col-md-5">
                                <input id="stop" name="location" type="text" placeholder="" class="form-control validate[required] input-md">

                            </div>
                        </div>
                        
                        @if(Auth::user()->role == 'adviser')
                        <!-- Search input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="co-adviser">กลุ่มที่จะแจ้งสิทธิ</label>
                            <div class="col-md-5">

                                <div class="input-group">

                                   {!! Form::hidden('adviser_id',Auth::user()->id)!!}
                                   {!! Form::select('project_id',$project,'',['class'=>'form-control validate[required]
                                   input-md','id'=>'appoint_group']) !!}
                                   
                                   
                                   <span class="input-group-addon">
                                    <i class="icon-move"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- Button -->
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-4">
                            <button id="singlebutton" name="singlebutton" class="btn btn-primary">บันทึก</button>
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
$(function() {
    $('#datetimepicker1').datetimepicker({
        locale: 'th',
        format: 'LLLL'
    });
});
$("#appoint_group").chosen();
</script>

@stop