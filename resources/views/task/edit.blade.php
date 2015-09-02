@extends('app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">แก้ไขข้อมูล </div>
                <div class="panel-body">
                    {!! Form::open(['to'=>'task/edit','class'=>'form-horizontal']) !!}
                    
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Task</label>  
                            <div class="col-md-6">
                                <input id="name" value="{{ $task->name }}" name="name"
                                       type="text"  class="form-control input-md">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">คาดการช่วงเวลาที่ทำ</label>  
                            <div class="col-md-6">
                               <div class="input-daterange input-group" >
                                    <input type="date" class="input-sm form-control validate[required]" value="{{ $task->start_time }}" name="start_time" />
                                    <span class="input-group-addon">ถึง</span>
                                    <input type="date" class="input-sm form-control validate[required]" value="{{ $task->stop_time }}" name="stop_time" />
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-4 control-label" for="name">item of Task</label>  
                            <div class="col-md-3">
                                <input id="item_of_task" name="item_of_task" 
                         value="{{ $task->item_of_task }}" type="text"  class="form-control input-md">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ผู้รับผิดชอบ</label>  
                            <div class="col-md-3">
                                <?php $user = App\User::where('project_id', Auth::user()->project_id)->where('role', 'student')->lists('first_name', 'id') ?>
                                {!! Form::select('responsible',$user,$task->responsible,['class'=>'form-control chosen']) !!}
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-4 control-label" for="name">ต้องรองานอื่นไหม?</label>  
                            <div class="col-md-3">
                               /*<?php /*$user = App\Task::where('activity_id',Request::segment(3))
                                        ->lists('name', 'id')
                                */?>*/
                                {!! Form::select('dependent_on[]',$user,'',['class'=>'form-control chosen','multiple']) !!}
                                </select>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label>  
                            <div class="col-md-3">
                                {!! Form::submit('บันทึก',['class'=>'btn btn-primary']) !!}
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
        format: "yyyy-mm-dd",
        language: "th",
        todayHighlight: true,
        orientation: "bottom left"
    });
</script>

@stop