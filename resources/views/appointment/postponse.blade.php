@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">เลือนการนัดหมาย</div>
                <div class="panel-body">
                    {!! Form::open(['to'=>'appointment/postponse','class'=>'form-horizontal']) !!}
                    <fieldset>
                            <!--{!! Form::hidden('appointment_id',Input::get('id')) !!}
                              {!! Form::hidden('user_id',Input::get('user_id')) !!}-->
                              {!! Form::hidden('id',$appointment->id) !!}
                                @if(Auth::user()->role == 'adviser')
                                {!! Form::hidden('approve','เข้าพบได้') !!}
                                @else
                                {!! Form::hidden('approve','รอการตอบรับ') !!}
                                @endif
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">หัวข้อ</label>  
                            <div class="col-md-5">
                                <label class="control-label" for="start">{{ $appointment->title}}</label>
                            </div>
                        </div>
                     

                        <!-- Text input-->
                        <div class="form-group">
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
                                </div>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="stop">สถานที่</label>  
                            <div class="col-md-5">
                                <input id="stop" name="location" value="{{ $appointment->location}}"type="text"
                                       placeholder="" class=" validate[required] form-control input-md">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">เหตุผลการขอเลื่อนนัด</label>  
                                <div class="col-md-5">
                                    <textarea class="form-control validate[required]" col="70" rows="10" id="message" name="message"></textarea>
                                </div>
                        </div>

                        <!-- Text input-->
                        </div><div class="form-group">
                            <label class="col-md-4 control-label" for="start">วันที่จะนัด</label>  
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="date" id="DATE" data-date-format="DD MMMM YYYY" class="input-sm form-control validate[required]" name="postponse_date" min="{{ $appointment->due_date}}"/>
                                    <span class="input-group-addon">เวลา</span>
                                    <input type="time"  class="input-sm form-control validate[required]" name="appoint_new_time" min=8:00 max=18:00 />
                                </div>   
                            </div>
                        </div>
                        
                        <!-- Text input-->    
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
