@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">แก้ไขข้อมูล การนัดหมาย</div>
                <div class="panel-body">
                    {!! Form::open(['to'=>'appointment/edit','class'=>'form-horizontal']) !!}
                    <fieldset>
                        {!! Form::hidden('id',$appointment->id) !!}
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">หัวข้อ</label>  
                            <div class="col-md-5">
                                <input id="name" name="title" value="{{ $appointment->title}}" type="text" 
                                placeholder="" class=" validate[required] form-control input-md"></input>
                            </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="detail">รายละเอียด</label>
                            <div class="col-md-5">                     
                                <textarea class="form-control validate[required]" col="70" rows="10" id="detail" name="detail">{{ $appointment->detail}}</textarea>
                            </div>
                        </div>

                        <!-- Text input-->
                        <?php
                        $strDate = $appointment->due_date ;
                        $strYear = date("Y",strtotime($strDate))+543;
                        $strMonth= date("n",strtotime($strDate));
                        $strDay= date("j",strtotime($strDate));
                        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                        $strMonthThai=$strMonthCut[$strMonth];
                        $strDates ="$strDay $strMonthThai $strYear";
                        ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="start">วันที่นัดและเวลา</label>  
                            <div class="col-md-5">
                                <div class="input-append date">
                                    <label class="control-label" for="start">{{$strDates}}  เวลา{{$appointment->appoint_time}} </label>
                                    <!--<input id="datetimepicker1" data-format="dd/MM/yyyy hh:mm:ss" type="text" name="due_date" class=" form-control validate[required] input-md" value="{{ $appointment->due_date}}"></input>    -->
                                </div>
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="stop">สถานที่</label>  
                            <div class="col-md-4">
                                <input id="stop" name="location" value="{{ $appointment->location}}"type="text"
                                placeholder="" class=" validate[required] form-control input-md">
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
$('#datepicker').datepicker({
    //format: "yyyy-mm-dd" ,
    language: 'th',
    todayHighlight: true,
    orientation: "bottom left",
    startDate: '{{}}',
    //todayBtn:true
});
$("#appoint_group").chosen();
</script>

@stop