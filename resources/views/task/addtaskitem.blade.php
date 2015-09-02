@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เพิ่มลิ้งค์ไฟล์งานของงาน {!! $task->name !!}


                </div>

                <div class="panel-body">
                    {!! Form::open(['url'=>'task/addtaskitem','class'=>'form-horizontal']) !!}
                    {!! Form::hidden('id',$task->id) !!}
                    
                    <fieldset>
                         <!-- label-->
                         @if($task->work_status=='0')
                            <div class="form-group">  
                                <label class="col-md-4 control-label" for="name">ชื่องาน</label>  
                                <div class="col-md-6">
                                
                                    <!--<label class=" control-label" for="name"> {{ $task->item_of_task }}  ชิ้น</label>--> 
                                    <input id="work_status" name="work_status" type="text"
                                       placeholder="ชื่อชิ้นงาน" class="form-control input-md validate[required]">
                                </div>
                            </div>
                        
                         <!-- Text input-->
                         
                         <div class="form-group">
                            <label class="col-md-4 control-label">ลิ้งค์ไฟล์งาน</label>
                            <div class="col-md-6">
                                
                                <input id="work_status" name="LinkItem" type="text" class="form-control input-md validate[required]"placeholder="https://drive.google.com/file....">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label>  
                            <div class="col-md-3">

                                {!! Form::submit('บันทึก',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        @else
                         <div class="form-group">  
                                <label class="col-md-4 control-label" for="name">ชื่องาน</label>  
                                <div class="col-md-6">
                                
                                    <!--<label class=" control-label" for="name"> {{ $task->item_of_task }}  ชิ้น</label>--> 
                                    <input id="work_status" name="work_status" type="text"
                                       placeholder="ชื่อชิ้นงาน" class="form-control input-md validate[required]" value="{!! $task->work_status !!}" readonly >
                                </div>
                            </div>
                        
                         <!-- Text input-->
                         
                         <div class="form-group">
                            <label class="col-md-4 control-label">ลิ้งค์ไฟล์งาน</label>
                            <div class="col-md-6">
                                
                                <input id="LinkItem" name="LinkItem" type="text" 
                                        class="form-control input-md validate[required]"placeholder="https://drive.google.com/file...." value="{!! $task->LinkItem !!}" readonly >

                            </div>
                        </div>
                        @endif

                        <!-- Text input-->
                     
                        <!-- Button-->
                        
                      
                    </fieldset>
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




@stop
