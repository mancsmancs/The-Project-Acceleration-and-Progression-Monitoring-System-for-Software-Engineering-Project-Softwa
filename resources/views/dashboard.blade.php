@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                @if(Auth::user()->role == 'adviser')
                <div class="panel-heading"><h4>หน้าแรกของอาจารย์</h4></div>
                @else
                <div class="panel-heading"><h4>หน้าแรกของนิสิต</h4></div>
                @endif

                <div class="panel-body">
                    @foreach($project as $project)    
                    <div class="tree">
                        <ul> 
                            <li>
                                <span><i class="glyphicon glyphicon-briefcase"></i>{!! $project->name !!}</span> 
                                @if (Auth::user()->role == 'adviser') {
                                <a traget="_blank" href="{{ url('project/edit',['id'=>$project->id])}}">แก้ไข</a>}{
                                <a traget="_blank" href="{{ url('project/gantt',['id'=>$project->id])}}">แกนต์</a>
                                }
                                @endif
                                @foreach($project->activity as $activity)
                                <ul>
                                    <li>
                                        <h4><span class="label label-info">
                                            <i class="glyphicon glyphicon-tasks"></i> {!! $activity->name !!}</span></h4>
                                        @foreach($activity->task as $task)
                                        <ul>
                                            <li>

                                                @if($task->status=='รอ')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-warning">{{ $task->status }}การอนุมัติ</span> </a>
                                                @elseif($task->status=='กำลังทำ')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-primary">{{ $task->status }}</span> </a>
                                                @elseif($task->approve=='ไม่อนุมัติ'||$task->status=='ไม่อนุมัติ')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-default">{{ $task->status }}</span> </a>
                                                @elseif($task->status=='เสร็จแล้ว')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-success">{{ $task->status }}</span> </a>
                                                @elseif($task->status=='ไม่อนุมัติการขอขยายเวลา')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-default">{{ $task->status }}</span> </a>    
                                                @elseif($task->approve_newtime=='มีการขอขยายเวลาทำงาน'&&$task->status=='มีการขอขยายเวลาทำงาน')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-danger">{{ $task->status }}</span> </a>
                                                @elseif($task->approve_newtime=='อนุมัติ'&&$task->status=='มีการขอขยายเวลาทำงาน')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-warning">{{ $task->status }} และอนุมัตแล้ว</span> </a>
                                                @elseif($task->approve_newtime=='ไม่อนุมัติ'&&$task->status=='มีการขอขยายเวลาทำงาน')
                                                <a><span><i class="glyphicon glyphicon-file"></i> {!! $task->name !!}</span> &ndash;
                                                    <span class="label label-default">{{ $task->status }} และไมู่กอนุมัต</span> </a>
                                                    @else
                                                    @endif
                                                 

                                                @if (Auth::user()->role == 'adviser') 
                                                    @if($task->approve_newtime == 'มีการขอขยายเวลาทำงาน')
                                                        <ul>
                                                            <li>
                                                                    <a href="" ><span>
                                                                        @if($task->approve_newtime=='มีการขอขยายเวลาทำงาน'&&$task->newtimefortask!=0)
                                                                        <i class="glyphicon glyphicon-time"></i> จำนวนชั่วโมงการทำงานต่อวันเดิมทำวันละ{!! $task->timefortask/$task->timeoftask !!}ชั่วโมง {ขอเพิ่มจำนวนชั่วโมงการทำงานอีกวันละ {!! $task->newtimefortask !!}ชั่วโมง }
                                                                        @else
                                                                        <i class="glyphicon glyphicon-time"></i> เวลาเก่า{!! $task->stop_time !!} {เวลาใหม่{!! $task->newdeadline !!} } 
                                                                        @endif
                                                                        
                                                                        <a href="{{ url('task/extendapprove/1/'.$task->id)}}" >อนุมัติ</a>
                                                                        <a href="{{ url('task/extendapprove/0/'.$task->id)}}" >ไม่อนุมัติ</a>
                                                                    </span> </a>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                @endif
                                                
                                            </li>
                                        </ul>
                                        @endforeach
                                    </li>
                                </ul>
                                @endforeach
                            </li>

                        </ul>

                    </div>
                    @endforeach            
                </div>
            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">สถานะของ task </h4>
            </div>
            <form action="{!! url('task/addstatus') !!}" class="form-horizontal">
                <div class="modal-body">

                    <fieldset>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">สถานะ</label>  
                            <div class="col-md-4">
                                <input id="textinput" name="status" type="number" min="1" max="item_of_task" 
                                       placeholder="สถานะ" class="form-control input-md">
                                <input type="hidden" id="id" name="id" value="" />
                                <span id="item_of_task"></span>  
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('specific_script')
<script type="text/javascript">

    $('.taskstatus').click(function () {
        var id = $(this).attr('id');
        $('#item_of_task').text('มีชิ้นงานทั้งหมด ' + $(this).data('item') + ' ชิ้น');
        $('.link').attr('value', id);
        $('.modal-title').text($(this).data('name'));
    });
    $(function () {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('glyphicon glyphicon-plus-sign')
                        .removeClass('glyphicon glyphicon-minus-sign');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('glyphicon glyphicon-minus-sign')
                        .removeClass('glyphicon glyphicon-plus-sign');
            }
            e.stopPropagation();
        });
    });
</script>

@stop