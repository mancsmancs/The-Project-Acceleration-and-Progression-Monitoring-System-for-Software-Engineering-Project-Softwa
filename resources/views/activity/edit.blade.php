@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">แก้ไขข้อมูล Activity </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'activity/edit','class'=>'form-horizontal']) !!}

                    <fieldset>
                        {!! Form::hidden('id',$activity->id) !!}
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">โปรเจค</label>  
                            <div class="col-md-3">
                                @if(Auth::user()->role == 'student')
                                {!! Form::hidden('project_id',Auth::user()->project_id) !!}
                                <?php 
                                    $project = \App\Activity::with('project')->find(Request::segment(3));
                                    // ddd($project);
                                ?>
                                <input id="name"  type="text" value="{!! $project->name !!}"  
                                       id="project" class="form-control input-md" readonly >
                                @else 
                                <?php $data = App\Project::where('primary_adviser_id', Auth::user()->id)
                                        ->lists('name', 'id');
                                   $project = \App\Project::find(Request::segment(3));
                                ?>
                                {!! Form::select('project_id',$data,Request::input('id'),
                                ['class'=>'form-control required chosen','id'=>'project']) !!}
                                @endif                               
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Activity</label>  
                            <div class="col-md-6">
                                <input id="name" name="name" type="text" 
                                       value="{!! $activity->name !!}"class="form-control validate[required] input-md">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name"></label>  
                            <div class="col-md-6">
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
</div>
@endsection
@section('specific_script')
<script type="text/javascript">
    // $('.daterangepicker1').daterangepicker();
    $("#appoint_group").chosen();
    $('#datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "th",
        todayHighlight: true
    });
    $('.chosen-select').chosen(); // สั่งให้ chosen ทำงานโดยเป้าหมายเป็น คลาส chosen-select
    $('#project').change(function () { 
        var value = $("#project").val(); // เราก็จะดึงค่ามา

        $.ajax({// จากนั้นก็สร้าง ajax
            type: 'GET', // ชนิดของ http เป็น get
            url: "{!! url('activity/selectuser')!!}", // url ที่จะยิงไป
            data: {id: value}, // ค่าที่จะส่งไป 
            success: function (data) { // ถ้าสำเร็จ
                $('#reponsible').find('option') // ทำการค้นหา ตัว option ของ dropdown province
                        .remove() // ลบ option ทิ้ง
                        .end() // ใช้ reset กลับไปตอนที่ยังไม่ลบ option ครับ 
                        .append(data.dropdown) // เอาค่าที่ได้จาก ฐานข้อมูลใส่
                        .trigger('chosen:updated'); // สั่งให้ chosen อัพเดท dropdown
            }
        });
    });
</script>
@stop