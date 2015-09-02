@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">แก้ไขข้อมูลโปรเจค 
                </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'project/update','class'=>'form-horizontal']) !!}
                    {!! Form::hidden('primary_adviser_id',Auth::user()->id) !!}
                    <fieldset>
                        {!! Form::hidden('id',$projects->id)!!}
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ชื่อ</label>  
                            <div class="col-md-6">
                                <input id="name" name="name" value="{{ $projects->name }}" 
                                       type="text" placeholder="ระบบจัดการร้านอาหาร" class="validate[required] form-control input-md">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="detail">สถานะ</label>
                            <div class="col-md-6">     
                                {!! Form::select('status',[''=>'เลือกสถานะ','เริ่มดำเนินงาน'=>'เริ่มดำเนินงาน',"เสร็จสมบูรณ์"=>'เสร็จสมบูรณ์','ไม่ผ่าน'=>'ไม่ผ่าน',],
                                $projects->status ,['class'=>'form-control chosen'])!!}
                            </div>
                        </div>    
                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="detail">รายละเอียด</label>
                            <div class="col-md-6">                     
                                <textarea class="form-control validate[required]" col="70" rows="10" id="detail" name="detail">
                                {{ $projects->detail }}
                                </textarea>
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="start">ช่วงเวลา</label>
                            <div class="col-md-6">
                                <div class="input-daterange input-group" >
                                    <input type="date" value="{{ $projects->start }}"class="input-sm form-control validate[required]" name="start" />
                                    <span class="input-group-addon">ถึง</span>
                                    <input type="date" value="{{ $projects->finish }}" class="input-sm form-control validate[required]" name="finish" />
                                </div>
                            </div>
                        </div>
                        <!-- Search input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="coadviser">ที่ปรึกษาร่วม</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <!--<select id="coadviser-select"  multiple name="coadviser[]" type="text" placeholder="" class="form-control input-md">-->
                                        <select id="coadviser-select" multiple name='secondary_adviser_id' placeholder=""class=" form-control input-md validate[required]" type="text">
                                  {!! $dropdown2 !!}
                                     </select><span class="input-group-addon">
                                       
                                    </span>
                                </div>
                                    <!--{!! Form::select('secondary_adviser_id',array_merge([''=>'เลือก'],App\User::where('role','adviser')->whereNotIn('id',
                                    [Auth::user()->id])->lists('first_name','id'))
                                    ,'',['class'=>'form-control input-md validate[required]','id'=>'coadviser-select']) !!}-->
                                    
                                
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="student">นิสิต</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select id="student-select"  multiple name="student[]" type="text" placeholder="" class="form-control input-md">
                                        {!! $dropdown !!}
                                    </select>   
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-4">
                                <button id="singlebutton" name="singlebutton" class="btn btn-primary">บันทึก</button>
                                <a href="http://papmproject.com/project/index" class="btn btn-danger "  >ยกเลิก</a>
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
    $("#student-select").chosen({'max_selected_options': 2});
    //$("#coadviser-select").chosen({'max_selected_options': 1});
    $("#coadviser-select").chosen({allow_single_deselect: true});
    

    //$("#coadviser-select").chosen({'placeholder_text_multiple': 'เลือกที่ปรึกษาร่วม'});
    $('#datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "th",
        todayHighlight: true
    });

</script>

@stop

