@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                    <div class="panel-heading clearfix" >
                    <h3 class="panel-title pull-left" style="padding-top: 7.5px;">การนัดหมายทั้งหมด</h3>
                    <div class="pull-right">
                        <a href="{{ url('appointment/create') }}" class="btn btn-success btn-sm ">
                            <span class="glyphicon glyphicon-plus"></span> สร้างการนัดหมาย</a>

                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="span7">   
                            <div class="widget stacked widget-table action-table">
                                <div class="widget-content">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>กลุ่ม</th>
                                                <th>สมาชิก</th>
                                                <th>จำนวนครั้งที่นัด</th>
                                                <th>สถานะการดำเนินงาน</th>
                                                <th>การจัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            @if($projects)
                                            @foreach($projects as $key => $project)
                                            <tr>
                                                <td>{!! $project->name  !!}</td>
                                                <!--ชื่อนักเรียนของแต่ละโปรเจค-->
                                                <td>@foreach($project->student as $student)
                                                 {!! $student->first_name  !!} <br>
                                                 @endforeach
                                             </td>
                                             <td>
                                                {!! $project->appointment->count() !!}
                                            </td>
                                            <td>                
                                                {!! $project->status !!}
                                            </td>
                                            <td>
                                                <button class="btn btn-info appointment_list" id="{!! $project->id !!}" >
                                                    <i class="glyphicon glyphicon-list"></i>ดูนัดหมาย</button> 

                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    



                                  <div id="appointment_lists" class="modal fade bs-example-modal-lg">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header clearfix">
                                                <button type="button" class="close" data-dismiss="modal" 
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">การนัดหมายของโปรเจค{!! $project->name !!}</h4>
                                                <div class="pull-right">

                                                    มีการนัดหมายทั้งหมด {!! $app_total!!} ครั้ง มาตามนัด {!! $go_total !!} ทั้งหมด
                                                    ไม่มาตามนัดทั้งหมด  {!! $nogo_total !!}
                                                    คิดเป็น @if($go_total != 0) {!! number_format((($go_total/$app_total)* 100), 2, '.', '') !!} @endif เปอเซนต์
                                                    <a href="{{ url('appointment/createexams') }}" class="btn btn-warning btn-sm">
                                                        <span class="glyphicon glyphicon-gift"></span> สร้างข้อความแจ้งสิทธิ์เข้าสอบ</a>
                                                        <a href="{{ url('appointment/create') }}" class="btn btn-success btn-sm ">
                                                            <span class="glyphicon glyphicon-plus"></span> สร้างการนัดหมาย</a>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <th>ชื่อ</th>
                                                                <th>รายละเอียด</th>



                                                                <th>การตอบรับ</th>
                                                                <th>เลือกการตอบรับ</th>
                                                                <th>การเข้าพบ</th>
                                                                <th>ยืนยันการเข้าพบ</th>
                                                                <th>การจัดการ</th>

                                                            </thead>
                                                            <tbody class="data">

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!--.modalรายละเอียด-->


                                                    <div id="appointment_details" class="modal fade bs-example-modal-lg">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">รายละเอียด</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <th>รายละเอียดการนัดหมาย</th>
                                                                            <th>สถานที่</th>
                                                                            <th>วันที่</th>
                                                                            <th>เวลา</th>
                                                                            <th>นัดกับ</th>
                                                                        </thead>
                                                                        <tbody class="datadetail">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal --> 
                                    </div> <!-- /widget-content -->
                                </div> <!-- /widget -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('specific_script')
        <script>
        $('.appointment_list').click(function () {
        // alert('ttt');
        var id = $(this).attr('id');
        //alert(id);

        $('.data').load('{{ url("appointment/lists") }}/?id=' + id, function (result) {
            $('#appointment_lists').modal({show: true});
        });
    });







        $('#appointment_lists').on('shown.bs.modal', function (e) {

            $('.readmore').readmore();
            $('.chosen1').chosen();
            $('.chosen2').chosen();
            $('.chosen1').change(function () {
                var id = $(this).attr('id');
                var val = $(this).val();
                $.ajax({
                    method: 'get',
                    url: "{!! url('appointment/approvestatus') !!}",
                    data: {id: id, status: val},
                //dd(student);
                success: function (data) {
                    alert('ตอบรับการนัดหมายเรียบร้อย')
                }
            });
            });

            $('.chosen2').change(function () {
                var id = $(this).attr('id');
                var val = $(this).val();
                $.ajax({
                    method: 'get',
                    url: "{!! url('appointment/appointmentstatus') !!}",
                    data: {id: id, status: val},
                    success: function (data) {
                        alert('เปลี่ยนสถานะเรียบร้อย')
                    }
                });
            });


            $('.appointment_detail').click(function () {
         //alert('ttt');
        var id = $(this).attr('id');
        //alert(id);
        $('.datadetail').load('{{ url("appointment/detail") }}/?id='+ id, function (result) {
            $('#appointment_details').modal({show: true});
        });
    });
        });
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
@endsection
