@extends('app')

@section('content')

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">งานย่อย
            <div class="pull-right">
                @if(Auth::user()->role == 'student')
                <a  href="{{ url('task/create',Request::segment(3))}}" class=" btn btn-success">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มงานย่อย</a>
                    @endif 
            </div>
        </div>
        <div class="panel-body">

            <table class="table table-bordered">
                <thead>
                <th> ชื่องานย่อย</th>
                <th>วันที่เริ่ม</th>
                <th> กำหนดเสร็จ</th>
                <th>วันที่เสร็จจริง</th>
                <th>สถานะของงาน</th>
                <!--<th>จำนวนชั่วโมงทำงาน (ชั่วโมง)</th>--> 
                <th>จำนวนวันทำงาน (วัน)</th>
                <!--<th>ชิ้นงานทั้งหมด</th>-->
                <th>ชิ้นงานที่เสร็จแล้ว</th>
                <th>อนุมัติการทำงาน</th>
                <!--<th>สถานะการขยายเวลา</th>-->
                @if(Auth::user()->role == 'student')
                <th>การจัดการ</th> 
                @else
                <th>การจัดการการขยายเวลา</th>
                @endif
                
                 
                </thead>
                <tbody>
                    @foreach($tasks as $key => $task)
                    <tr>
                        <td>{!! $task->name !!}</td>
                        <td>{!! $task->start_time !!}</td>
                        <td>{!! $task->stop_time !!}</td>

                        @if($task->status == 'เสร็จแล้ว') 
                        <td>{!! $task->updated_at !!}</td>
                        @else
                        <td>{!! $task->completed_at !!}</td>
                        @endif

                        @if(Auth::user()->role == 'student')
                         
                            @if($task->approve== 'อนุมัติแล้ว'&&$task->status!= 'เสร็จแล้ว')
                            <td>
                            <!--{!! Form::select('status',[''=>'เลือกสถานะ','เสร็จแล้ว'=>'เสร็จแล้ว','กำลังทำ'=>'กำลังทำ'],
                            $task->status,['data'=>$task->id,'class'=>'form-control status']) !!}-->
                            {{$task->status}}
                            </td>
                            @elseif($task->status== 'เสร็จแล้ว')
                            <td>{{$task->status}}</td>
                            @else
                            <td>{{$task->status}}</td> 
                            @endif

                        @else
                        <td>{!! $task->status !!}</td>
                        @endif
                        
                        <!--<td>{!! $task->timefortask !!}</td>-->
                        <td>{!! $task->timeoftask !!} วัน</td>
                        <!--<td>{!! $task->item_of_task !!} ชิ้น</td>-->
                        @if(Auth::user()->role == 'student')
                            @if($task->work_status=='0'&&$task->status!='ไม่อนุมัติ'&&$task->status!='รอ')
                            <td>ชื่องาน :{!! $task->work_status !!}<a href="{{ url('task/addtaskitem',$task->id)}}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-plus-sign"></span>เพิ่มลิ้งค์ไฟล์งาน</a> </td>
                            @elseif($task->status=='ไม่อนุมัติ')
                            <td>ไม่อนุมัติ</td>
                            @elseif($task->status=='รอ')
                            <td>รอ</td>
                            @else
                            <td>
                                ชื่องาน :{!! $task->work_status !!}
                                <a href="{{ $task->LinkItem }}">ดาวน์โหลด<span><i class="glyphicon glyphicon-file"></i> {!! $task->work_status !!}</span></a>
                            </td>
                            @endif
                        @else
                            @if($task->work_status=='0'&&$task->status!='ไม่อนุมัติ'&&$task->status!='รอ')
                                    <td>
                                    ชื่องาน :{!! $task->work_status !!}
                                    </td>
                            @elseif($task->status=='รอ')
                            <td>รอ</td>
                            @elseif($task->status=='ไม่อนุมัติ')
                            <td>ไม่อนุมัติ</td>
                            @else
                            <td>
                                ชื่องาน :{!! $task->work_status !!}
                                <a href="{{ $task->LinkItem }}">ดาวน์โหลด<span><i class="glyphicon glyphicon-file"></i> {!! $task->work_status !!}</span></a>
                            </td>
                            @endif
                        @endif


                        @if(Auth::user()->role == 'adviser')
                                @if($task->status=='รอ')
                                <td>{!! Form::select('approve',[''=>'เลือกสถานะ','อนุมัติ'=>'อนุมัติ','ไม่อนุมัติ'=>'ไม่อนุมัติ','รอ'=>'รอ'],$task->approve,['data'=>$task->id,'class'=>'form-control approve']) !!}</td>
                                @else
                                <td>อนุมัติการขอดำเนินงานแล้ว</td>
                                @endif
                        @else
                        <td>{!! $task->approve !!}</td>
                        @endif


                        <!--<td>{!! $task->approve_newtime !!}</td>-->
                        
                        @if(Auth::user()->role == 'student')
                                @if( $task->approve=='อนุมัติแล้ว'&&$task->status!='เสร็จแล้ว'&&$task->approve_newtime==''&&$task->newdeadline==''&&$task->newtimefortask=='')

                                <td>
                                <a href="{{ url('task/postponse',$task->id)}}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-time"></span> ขยายเวลา</a>  
                                <a href="{{ url('task/edit/'.$task->id.'/'.$task->activity_id)}}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span> แก้ไข</a>
                                <a  href="#myModal" data-url="{{ url('task/delete',['id'=>$task->id])}}" 
                                data-toggle="modal" data-target="#myModal" class="remove btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> ลบ</a>
                                
                                </td>
                                @elseif($task->status=='มีการขอขยายเวลาทำงาน'&&$task->approve=='อนุมัติแล้ว'&&$task->approve_newtime=='อนุมัติ')
                                <td> 
                                <a href="{{ url('task/edit/'.$task->id.'/'.$task->activity_id)}}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span> แก้ไข</a>
                                <a  href="#myModal" data-url="{{ url('task/delete',['id'=>$task->id])}}" 
                                data-toggle="modal" data-target="#myModal" class="remove btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> ลบ</a>
                                <span class="label label-info">สถานะการขยายเวลา:{!! $task->approve_newtime !!}</span>
                                 
                                </td>
                                @else
                                    @if($task->status=='เสร็จแล้ว')
                                    <td>งานนี้ทำเสร็จแล้ว</td>
                                    @elseif($task->status=='มีการขอขยายเวลาทำงาน'&&$task->approve_newtime=='ไม่อนุมัติ'||$task->status=='ไม่อนุมัติการขอขยายเวลา'&&$task->approve_newtime=='ไม่อนุมัติ')
                                    <td>
                                    <a href="{{ url('appointment/create') }}" class="btn btn-success btn-sm">
                                    <span class="glyphicon glyphicon-plus"></span> สร้างนัดหมาย</a>
                                    <span class="label label-info">กรุณาติดต่ออาจารย์ที่ปรึกษาด่วน!!!!!</span>
                                        <span class="label label-info">สถานะการขยายเวลา:{!! $task->approve_newtime !!}</span>
                                     
                                    </td>
                                    @elseif($task->status=='ไม่อนุมัติ')
                                    <td>งานนี้ไม่ได้รับการอนุมัติให้ดำเนินงาน</td>
                                    @else
                                    <td>ยังไม่ได้รับการอนุมัติจากอาจารย์</td>
                                    @endif
                                @endif
                        @else
                        
                            @if( $task->approve_newtime=='มีการขอขยายเวลาทำงาน')
                            <td>
                            <a href="{{ url('task/postponse',$task->id)}}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-time"></span>จัดการ การขอเลื่อนเวลาทำงาน</a>
                            </td>
                            @else
                                @if($task->status=='รอ'&&$task->approve_newtime=='')
                                <td>กรุณาเลือกสถานะการให้ดำเนินงาน</td>
                                @elseif($task->status=='มีการขอขยายเวลาทำงาน'&&$task->approve_newtime=='อนุมัติ')
                                <td>การขอขยายเวลาการทำงานถูกอนุมัติแล้ว</td>
                                @elseif($task->status=='เสร็จแล้ว'&&$task->approve_newtime=='อนุมัติ')
                                <td>การขอขยายเวลาการทำงานถูกอนุมัติแล้ว</td>
                                @elseif($task->status=='มีการขอขยายเวลาทำงาน'&&$task->approve_newtime=='ไม่อนุมัติ')
                                <td>การขอขยายเวลาการทำงานไม่ได้รับการอนุมัติ</td>
                                @else
                                <td>ยังไม่มีการขอขยายเวลาการทำงาน</td>
                                @endif
                            
                            @endif  
                        

                        @endif
                        
                    </tr>
                    @endforeach()
                </tbody>
            </table>
        </div>
    </div>

</div>
@stop()
@section('specific_script')
<script>

 
    $('.status').change(function () {
        $.blockUI({message: '<h2> รอสักครู่...</h2>'});
        var id = $(this).attr('data');
        var val = $(this).val();
        $.ajax({
            method: 'get',
            url: "{!! url('task/changetaskstatus') !!}",
            data: {id: id, status: val},
            success: function (data) {
                $.unblockUI();
            }
            
        });

        location.reload();
    });
    $('.approve').change(function () {
        $.blockUI({message: '<h2> รอสักครู่...</h2>'});
        var id = $(this).attr('data');
        var val = $(this).val();
        $.ajax({
            method: 'get',
            url: "{!! url('task/changeapprovestatus') !!}",
            data: {id: id, status: val},
            success: function (data) {
                $.unblockUI();
            }   
        });
        setTimeout(function () {
        location.reload()}, 300);
    });


    $(function() {
    $('#datetimepicker1').datetimepicker({
        locale: 'th',
        format: 'LLLL'
    });
  });
    
</script>

@stop