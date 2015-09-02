@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เพิ่มข้อมูลโปรเจค 
                </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'project/create','class'=>'form-horizontal']) !!}
                    {!! Form::hidden('primary_adviser_id',Auth::user()->id) !!}
                    <fieldset>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">ชื่อ</label>  
                            <div class="col-md-6">
                                <input id="name" name="name"  type="text"
                                       placeholder="ระบบจัดการร้านอาหาร ภาคเรียนที่1/2558"
                                       class="form-control input-md validate[required]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="detail">สถานะ</label>
                            <div class="col-md-6">     
                                {!! Form::select('status',[''=>'เลือกสถานะ','เริ่มดำเนินงาน'=>'เริ่มดำเนินงาน',
                                "เสร็จสมบูรณ์"=>'เสร็จสมบูรณ์','ไม่ผ่าน'=>'ไม่ผ่าน',]
                                ,'',['class'=>'form-control chosen validate[required]']) !!}
                            </div>
                        </div>
            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="detail">รายละเอียด</label>
                <div class="col-md-6">                     
                    <textarea class="form-control validate[required]" col="50" rows="10" id="detail" name="detail"></textarea>
                </div>
            </div>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="start">ช่วงเวลา</label>
                <div class="col-md-6">
                    <div class="input-daterange input-group" >
                        <input type="date" class="input-sm form-control validate[required]" name="start" />
                        <span class="input-group-addon">ถึง</span>
                        <input type="date" class="input-sm form-control validate[required]" name="finish" />
                    </div>
                </div>
            </div>
            <!-- Text input-->
            <!-- Search input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="co-adviser">ที่ปรึกษาร่วม</label>
                <div class="col-md-6">
                    <div class="input-group">

                        <select id="coadviser-select" multiple name='secondary_adviser_id' class="form-control input-md validate[required]" type="text">
                                  {!! $dropdown2 !!}
                                     </select>
                        <!--{!! Form::select('secondary_adviser_id',array_merge([''=>'เลือก'],App\User::where('role','adviser')
                        ->whereNotIn('id',[Auth::user()->id])->lists('first_name','id'))
                        ,'',['class'=>'form-control input-md validate[required]','id'=>'coadviser-select']) !!}-->
                        <span class="input-group-addon">
                            <i class="icon-search"></i>
                        </span>
                    </div>
                </div>
            </div>

             <!--<div class="row">
                            <div class="col-md-4"></div>
                                <div class="col-md-8">
                        <label  for="co-adviser"><FONT COLOR=red>  อาจารย์ที่ปรึกษาร่วมสามารถเพิ่มได้หนึ่งท่าน </FONT></label>
                        
                        </div>
                        </div>-->
            <!-- Search input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="student">เลือกนิสิต</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <select id="student-select"  multiple name="student[]" type="text" placeholder="" class="form-control validate[required] input-md">
                            <!-- <select id="student-select"  multiple name="student[]" type="text" placeholder="" class="form-control validate[required] input-md">-->
                            {!! $dropdown !!}
                           
                        </select>   
                        <span class="input-group-addon">
                            <i class="icon-search"></i>
                        </span>
                    </div>
                </div>
            </div>
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
    $("#student-select").chosen({'max_selected_options': 2});
    $("#coadviser-select").chosen({'max_selected_options': 1});
    $("#coadviser-select").chosen({'placeholder_text_multiple': 'เลือกที่ปรึกษาร่วม'});
    $('#datepicker').datepicker({
        format: "dd-mm-yyyy",
        language: "th",
        todayHighlight: true
    });

</script>

@stop

