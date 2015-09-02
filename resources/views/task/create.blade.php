@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เพิ่มข้อมูลงานย่อย


                </div>

                <div class="panel-body">
                    {!! Form::open(['url'=>'task/create','class'=>'form-horizontal']) !!}
                    {!! Form::hidden('activity_id',Request::segment(3)) !!}
                    {!! Form::hidden('approve','รอ') !!}
                    <fieldset>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label> 
                            <div class="col-md-6">
                               <label class="control-label" for="name"></label> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label> 
                            <div class="col-md-6">
                               <label class="control-label" for="name"></label> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label> 
                            <div class="col-md-6">
                               <label class="control-label" for="name"></label> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ชื่องานย่อย</label>  
                            <div class="col-md-6">
                                <input id="name" name="name" type="text"  class="form-control input-md" maxlength="50">

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-4 control-label" for="name">ช่วงเวลาที่ทำ</label>  
                            <div class="col-md-6">
                               <div class="input-daterange input-group" >
                                    <input type="date" class="input-sm form-control" name="start_time" />
                                    <span class="input-group-addon">ถึง</span>
                                    <input type="date" class="input-sm form-control" name="stop_time" />
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ชิ้นงานที่ได้</label>  
                            <div class="col-md-3">
                                <input id="item_of_task" name="item_of_task" type="text"  class="form-control input-md">
                                    <label class="control-label" for="name"> 1 ชิ้นงานต่อ 1 งานย่อย</label>
                            </div>

                        </div>-->

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ผู้รับผิดชอบ</label>  
                            <div class="col-md-3">
                                <?php $user = App\User::where('project_id', Auth::user()->project_id)->where('role', 'student')->lists('first_name', 'id') ?>
                                {!! Form::select('responsible',$user,'',['class'=>'form-control chosen']) !!}

                            </div>

                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-4 control-label" for="name">ต้องรองานอื่นไหม?</label>  
                            <div class="col-md-3">
                                <?/*php $user = App\Task::where('activity_id',Request::segment(3))
                                        ->lists('name', 'id')
                                */?>
                                {!! Form::select('dependent_on[]',$user,'',['class'=>'form-control chosen','multiple']) !!}

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
<?php $activity = App\Activity::find(Request::get('activity_id'));  ?>
<script type="text/javascript">
    $("#appoint_group").chosen();
    $('#datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "th",
        todayHighlight: true,
        orientation: "bottom left"
    });
</script>

@stop