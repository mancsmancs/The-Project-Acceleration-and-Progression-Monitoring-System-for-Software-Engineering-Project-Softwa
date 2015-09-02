@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เพิ่มข้อมูล งาน</div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'activity/create','class'=>'form-horizontal']) !!}
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">โปรเจค</label>  
                            <div class="col-md-3">
                                @if(Auth::user()->role == 'student')
                                {!! Form::hidden('project_id',Auth::user()->project_id) !!}
                                <?php 
                                    $project = \App\Project::find(Request::segment(3));

                                ?>
                                <input id="name"  type="text" value="{!! $project->name !!}" 
                                       id="project" class="form-control input-md" readonly >
                                @else 
                                <?php $data = App\Project::where('primary_adviser_id', Auth::user()->id)
                                        ->orWhere('secondary_adviser_id', Auth::user()->id)
                                        ->lists('name', 'id');
                                ?>
                                {!! Form::select('project_id',$data,Request::input('id'),
                                ['class'=>'form-control required chosen','id'=>'project']) !!}
                                @endif                               
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">งานหลัก</label>  
                            <div class="col-md-6">
                                <input id="name" name="activity_name" type="text"  
                                       class="form-control validate[required] input-md" min="0" max="50" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">งานย่อยงานแรก</label>  
                            <div class="col-md-6">
                                <input id="name" name="task_name" type="text"  
                                       class="form-control validate[required] input-md"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ช่วงเวลาที่ทำงานย่อย</label>  
                            <div class="col-md-6">
                                <div class="input-daterange input-group" >
                                    <input  type="date" class="input-sm form-control validate[required]" min="{{ $project->start }}" max="{{ $project->finish }}" 
                                           name="task_start" />
                                    <span class="input-group-addon">ถึง</span>
                                    <input  type="date" class="input-sm form-control validate[required]" min="{{ $project->start }}"  
                                           name="task_finish" />
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-4 control-label" for="name">ชิ้นงานที่ได้</label>  
                            <div class="col-md-3">
                                <label class="control-label" for="name"> 1 ชิ้นงานต่อ 1 งานย่อย</label>
                                <!--<input id="item_of_task" name="item_of_task" type="text" 
                                       class="form-control validate[required] input-md">
                            </div>

                        </div>-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ผู้รับผิดชอบ</label>  
                            <div class="col-md-3">
                                <?php $user = App\User::where('project_id', Auth::user()->project_id)
                                                ->where('role', 'student')->lists('first_name', 'id')
                                ?>
                                {!! Form::select('responsible',$user,'',['class'=>'form-control chosen','id'=>'reponsible']) !!}
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
    $(".chosen").chosen();
    $('#datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "th",
        todayHighlight: true,
    });
    $('.chosen-select').chosen(); // สั่งให้ chosen ทำงานโดยเป้าหมายเป็น คลาส chosen-select
    $('#project').change(function () { // เมื่อไอดี pak ถูกเลือก
        var value = $("#project").val(); // เราก็จะดึงค่ามา
        $.ajax({// จากนั้นก็สร้าง ajax
            type: 'GET', // ชนิดของ http เป็น get
            url: "{!! url('activity/selectuser')!!}", // url ที่จะยิงไป
            data: {id: value}, // ค่าที่จะส่งไป 
            success: function (data) { // ถ้าสำเร็จ
                $('#datepicker').datepicker({'setStartDate':data.start,'setEndDate':data.finish}); 
                // ตั้งค่าระยะของการเลือกวันใหม่ ตามค่าทของดรอบดาวน์
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