@extends('app')

@section('content')

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">งานย่อย
            <div class="pull-right">
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['url'=>'task/taskstatus','class'=>'form-horizontal']) !!}

            <table class="table table-bordered">
                <thead>
                <th> ชื่องานย่อย</th>
                <th>วันที่เริ่ม</th>
                <th> กำหนดเสร็จ</th>
                
                <th>สถานะ</th>
                
                
                <th>จำนวนชิ้นงาน</th>
                <th>จำนวนชิ้นงานที่เพิ่มแล้ว</th>
                
                <th>การจัดการ</th> 
                 
                </thead>
                <tbody>
                    @foreach($tasks as $key => $task)
                    <tr>
                        <td>{!! $task->name !!}</td>
                        <td>{!! $task->start_time !!}</td>
                        <td>{!! $task->stop_time !!}</td>
                        <td>{!! $task->status !!}</td>
                        
                        <td>{!! $task->item_of_task !!} ชิ้นงาน</td>
                        <td>{!! $task->work_status !!} ชิ้นงาน</td>
                        @if($task->work_status!=$task->item_of_task&&$task->approve=='อนุมัติแล้ว'&&$task->approve_newtime=='อนุมัติ'||$task->status=='กำลังทำ')   
                        <td>

                            <a href="{{ url('task/addtaskitem',$task->id)}}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-plus-sign"></span>เพิ่มจำนวนชิ้นงาน</a> 

                        </td>
                        @elseif($task->approve_newtime=='ไม่อนุมัติ')
                        <td>ไม่อนุมัติการเพิ่มเวลา</td>
                        @elseif($task->status=='รอ')
                        <td>รอการอนุมัตจากอาจารย์</td>
                        @else
                        <td>งานนี้ทำเสร็จแล้ว</td>
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

<script type="text/javascript">

    $('.taskstatus').click(function () {
        var id = $(this).attr('id');
        var val = $(this).val();
        $('#item_of_task').text('มีชิ้นงานทั้งหมด ' + $(this).data('item') + ' ชิ้น');
        $('.link').attr('value', id);
        $('.modal-title').text($(this).data('name'));
        $.ajax({
            method: 'get',
            url: "{!! url('task/addtaskstatus') !!}",
            data: {id: id, status: val},
        });
    });
</script>

@stop