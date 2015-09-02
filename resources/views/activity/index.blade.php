@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-right">
                        @if(Auth::user()->role == 'student')
                        <a  href="{{ url('activity/create/'.Auth::user()->project_id)}}" 
                            id="addproject" data-toggle="modal" class=" btn btn-success">
                            <span class="glyphicon glyphicon-plus"></span> เพิ่มงาน</a>
                            @endif
                    </div>
                    @if(Auth::user()->role == 'adviser')
                    Activity ของโปรเจค {!! $projects->name !!}
                    @else
                    ตารางงาน
                    @endif
                   
                </div>
                <div class="panel-body">
                    <div class="span7">   
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ชื่องาน</th>
                                            <th>เริ่ม</th>
                                            <th>กำหนดเสร็จ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($projects->activity)
                                        @foreach($projects->activity as $key => $activity)
                                        <tr  class="clickable" id="row1" data-target=".row{!!$key!!}" data-toggle="collapse">
                                            <td>{!! $activity->name !!}</td>
                                            <td>{!! $activity->start_time !!}</td>
                                            <td>{!! $activity->stop_time !!}</td>
                                            <td>
                                                <a href="{{ url('task/index',$activity->id)}}" class="btn btn-primary">
                                                     <span class="glyphicon glyphicon-list-alt"></span> จัดการงานย่อย</a>
                                                     @if(Auth::user()->role == 'student')
                                                <!--<a href="{{ url('task/taskstatus',$activity->id)}}" class="btn btn-info">
                                                     <span class="glyphicon glyphicon-list-alt"></span>เพิ่มจำนวนชิ้นงานที่เสร็จแล้ว</a>-->
                                                <a href="{{ url('activity/edit',$activity->id)}}" class="btn btn-warning">
                                                     <span class="glyphicon glyphicon-pencil"></span> แก้ไข</a>
                                                <a  href="#myModal" data-url="{{ url('activity/delete',$activity->id)}}"
                                                    data-toggle="modal" data-target="#myModal" class="remove btn btn-danger">
                                                    <span class="glyphicon glyphicon-trash"></span> ลบ</a>
                                                
                                                    @endif
                                            </td>
                                        </tr>
                                    <div id="modal_task" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header"> 
                                                    <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                        <a href="#modal"  data-toggle="modal"  class=" btn btn-primary">
                                                            <span class="glyphicon glyphicon-plus"></span> เพิ่มงาน
                                                        </a>
                                                </div>
                                                <div id="modal-body{{$activity->id}}">
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div> <!-- /widget-content -->
                        </div><!-- /.modal -->
                    </div> <!-- /widget -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('specific_script')
<script type="text/javascript">
    $('.chosen').chosen();
    $('#addproject').click(function(){
        $('.modal-body').load('{{ url("activity/list") }}', function(result){
        $('#modal_activity').modal({show:true});
    });
    });
            $('.approve').change(function(){
            var id = $(this).attr('data');
            var val = $(this).val();
            $.ajax({
            method :'get',
                    url :"{!! url('activity/changeapprove') !!}",
                    data :{id:id, status:val},
                    success:function(data){
               
                    }
            });
    });

</script>

@stop
