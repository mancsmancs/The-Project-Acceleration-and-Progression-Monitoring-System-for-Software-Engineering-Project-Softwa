@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เลื่อนเวลาของ task {!! $task->name !!}


                </div>

                <div class="panel-body">
                    {!! Form::open(['url'=>'task/postponse','class'=>'form-horizontal']) !!}
                    {!! Form::hidden('id',$task->id) !!}
                    
                    <fieldset>
                            @if(Auth::user()->role == 'student')
                                @if($task->approve_newtime=='มีการขอขยายเวลาทำงาน')
                                    <div class="form-group">  
                                        <label class="col-md-4 control-label" for="name"><FONT COLOR=red>สถานะ : </FONT></label>  
                                            <div class="col-md-6">
                                                <label class=" control-label" for="name"><FONT COLOR=red>{{ $task->approve_newtime }}แล้วรอการตอบรับจากอาจารย์ที่ปรึกษา</FONT></label> 
                                            </div>
                                        </div>
                                @else
                                @endif
                         <!-- label-->
                            <div class="form-group">  
                                <label class="col-md-4 control-label" for="name">เวลาการทำงานเดิม </label>  
                                <div class="col-md-6">
                                {!! Form::hidden('approve_newtime','มีการขอขยายเวลาทำงาน') !!}
                                {!! Form::hidden('status','มีการขอขยายเวลาทำงาน') !!}
                                    <label class=" control-label" for="name">กำหนดเสร็จเดิมวันที่ {{ $task->stop_time }}  เวลาการทำงานต่อวัน {{$students->working_time}} ชั่วโมง</label> 
                                </div>
                            </div>
                        
                         <!-- Text input-->
                         <div class="form-group">
                            <label class="col-md-4 control-label">เลือกการทำงาน</label>
                            <div class="col-md-6">
                                <div class="col-sm-6">
                                   <!-- <div class="radio">
                                        @if($task->approve_newtime=='มีการขอขยายเวลาทำงาน')
                                        <input type="radio" name="role" value="hour" id="radio1" disabled>
                                        @else
                                        <input type="radio" name="role" value="hour" id="radio1">
                                        @endif
                                        
                                        <label for="radio1">
                                            เพิ่มชั่วโมงการทำงานต่อวัน (เร่งการทำงาน)
                                        </label>
                                    </div>-->
                                    <div class="radio">
                                        @if($task->approve_newtime=='มีการขอขยายเวลาทำงาน')
                                        <input type="radio" name="role" value="day" id="radio2" disabled>
                                        @else
                                        <input type="radio" name="role" value="day" id="radio2">
                                        @endif
                                        <label for="radio2">
                                            เพิ่มระยะเวลา (วัน) 
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Text input-->
                       <!-- <div id="hour-input" style="display:none;">
                            <div class="form-group">
                            <label class="col-md-4 control-label">จำนวนชั่วโมงที่จะเพิ่ม</label>
                                <div class="col-md-4">
                                    
                                    <input id="newtimefortask" name="newtimefortask" type="number" min="1" max="{!! $students->non_working_time !!}"
                                       placeholder="จำนวนชั่วโมงที่เพิ่มได้สูงสุด{!! $students->non_working_time !!}ชั่วโมง" class="form-control input-md">
                                    <label for="name">เพื่มชัวโมงสูงสุดได้ {{$students->non_working_time}} ชั่วโมง</label>
                                </div>
                            </div>
                        </div>



                        <!-- Text input-->
                        <div id="day-input" style="display:none;">
                            <div class="form-group">
                            <label class="col-md-4 control-label">วันที่ใหม่</label>
                                <div class="col-md-4">
                                    <input type="date"  class="input-sm form-control validate[required]" name="newdeadline" min="{{ $task->stop_time }}" />
                                    <label for="name">กำหนดเสร็จเดิมวันที่{{ $task->stop_time }}</label>
                                </div>
                            </div>
                        </div>
                        <!-- Text input-->
                        @if($task->approve_newtime=='มีการขอขยายเวลาทำงาน')
                        
                        <fieldset disabled>
                            <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label>  
                            <div class="col-md-3">

                                {!! Form::submit('บันทึก',['class'=>'btn btn-primary']) !!}
                                <button class="btn btn-danger " type="reset" value="Reset">ยกเลิก</button>

                            </div>
                        </div>
                               </fieldset>
                                @else
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label>  
                            <div class="col-md-3">

                                {!! Form::submit('บันทึก',['class'=>'btn btn-primary']) !!}
                                <button class="btn btn-danger " type="reset" value="Reset">ยกเลิก</button>

                            </div>
                        </div>
                        @endif
                        @else
                                <div class="form-group">  
                                <label class="col-md-4 control-label" for="name">เวลาการทำงานเดิม </label>  
                                    <div class="col-md-6">
                                    <label class=" control-label" for="name">กำหนดเสร็จเดิมวันที่ {{ $task->stop_time }} เวลาการทำงานต่อวันเดิมของนิสิต {{$students->working_time}} ชั่วโมง</label> 
                                </div>
                            </div>

                            <div class="form-group">
                            <label class="col-md-4 control-label" for="name">เวลาการทำงานใหม่</label>  
                                <div class="col-md-6">
                                    @if($task->newdeadline!='0000-00-00')
                                    <label class=" control-label" for="name">กำหนดเสร็จวันใหม่  {{ $task->newdeadline }} </label>
                                    @else
                                    <label class=" control-label" for="name">เพิ่มชั่วโมงการทำงานอีกวันละ  {{ $task->newtimefortask }} ชั่วโมง รวมเป็นทำงานวันละ {{$task->newtimefortask+($task->timefortask/$task->timeoftask)}}ชั่วโมง </label>
                                    @endif 
                                </div>
                            </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="stop">การอนุมัติ</label>  
                            <div class="col-md-4">
                                <?php
                                $value = ['อนุมัติ' => 'อนุมัติ', 'ไม่อนุมัติ' => 'ไม่อนุมัติ'];
                                ?>
                                {!! Form::select('approve_newtime',$value,$task->approve_newtime,['class'=>'form-control input-md','id'=>'appoint_group']) !!}
                            </div>
                        </div> 
                                
                                 
                                 <div class="form-group">
                                        <label class="col-md-4 control-label" for="name"></label>  
                                        <div class="col-md-3">

                                            {!! Form::submit('บันทึก',['class'=>'btn btn-primary']) !!}
                                            <button class="btn btn-danger " type="reset" value="Reset" >ยกเลิก</button>

                                        </div>
                                    </div>
                                    </fieldset>
                                
                        @endif
                    
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('specific_script')
<?php $activity = App\Activity::find(Request::get('activity_id'));  ?>
<script type="text/javascript">
    $('#datepicker').datepicker({
        format: "yyyy-mm-dd" ,
        language: "th",
        todayHighlight: true,
        orientation: "bottom left",
        startDate: "{!! $task->stop_time !!}"

    });
     $("#appoint_group").chosen();
</script>
<script>
    $('.form-horizontal input').on('change', function() {
   var val =$('input[name=role]:checked', '.form-horizontal').val(); 
   if(val == 'hour'){
       $('#hour-input').show("slow")
   }else{
       $('#hour-input').hide("slow")
   }
});
    
  </script>
  <script>
    $('.form-horizontal input').on('change', function() {
   var val =$('input[name=role]:checked', '.form-horizontal').val(); 
   if(val == 'day'){
       $('#day-input').show("slow")
   }else{
       $('#day-input').hide("slow")
   }
});
    
  </script>



@stop
