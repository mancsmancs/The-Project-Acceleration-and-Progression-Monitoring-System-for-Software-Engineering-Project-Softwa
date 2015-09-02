@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                
                <div class="panel-heading clearfix" >
                    <h3 class="panel-title pull-left" style="padding-top: 7.5px;">โปรเจค</h3>
                    <div class="pull-right">
                        @if(Auth::user()->role == 'adviser')
                        <a href="{{ url('project/create') }}" class="btn btn-success">
                            <span class="glyphicon glyphicon-plus"></span> เพิ่มโปรเจค</a>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    <div class="span7">   
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <i class="icon-th-list"></i>
                                <h3>โปรเจคทั้งหมด</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ชื่อ</th>
                                            <th>ที่ปรึกษาร่วม</th>
                                            <th>รายชื่อนิสิต</th>
                                            <th>รายละเอียด</th>
                                            <th>วันที่เริ่ม</th>
                                            <th>วันที่สิ้นสุด</th>
                                            <th>สถานะ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($projects)
                                        @foreach($projects as $key => $project)
                                        <tr>
                                            <td>{!! $project->name !!}</td>
                                            <td> @if($project->secondary_adviser->count() != 0) 
                                                {!! $project->secondary_adviser[0]->first_name  !!}
                                                @endif
                                            </td>
                                            <td>

                                                    @foreach($students as $student)
                                                        @if($student->project_id == $project->id)
                                                        {!! $student->first_name,'  '.$student->last_name  !!} <br>
                                                        @endif
                                                    @endforeach
                                                   
                                            </td>
                                            <td><a href="#" data-toggle="modal" data-target="#detail{!! $project->id !!}" 
                                                   class="btn btn-success" id="openBtn">ดูรายละเอียด</a></td>
                                            <td>{!! $project->start !!}</td>
                                            <td>{!! $project->finish !!}</td>
                                            <td>{!! $project->status !!}</td>
                                            @if(Auth::user()->role == 'adviser')
                                            <td>
                                                 
                                                <a href="{{ url('project/gantt',$project->id)}}" class="btn btn-sm btn-info">
                                                     <span class="glyphicon glyphicon-tasks"></span> ดู GanttChart</a>
                                                     
                                               <a href="{{ url('activity/index',$project->id)}}" class="btn btn-sm btn-primary">
                                                     <span class="glyphicon glyphicon-list-alt"></span> จัดการงานหลัก</a>

                                            
                                                 <a href="{{ url('project/edit',$project->id)}}" class="btn btn-sm btn-warning">
                                                     <span class="glyphicon glyphicon-pencil"></span> แก้ไข</a>
                                               
                                                <!--<a  href="#myModal" data-url="{{ url('project/delete',$project->id)}}"
                                                    data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-danger">
                                                    <span class="glyphicon glyphicon-trash"></span> ลบ</a>-->
                                                    
                                                    <a  href="#myModal" data-url="{{ url('project/delete',$project->id)}}" data-toggle="modal"
                                                     data-target="#myModal" class="remove btn btn-sm btn-danger">
                                                     <span class="glyphicon glyphicon-trash"></span> ลบ</a>
                                                    
                                            </td>
                                            @else
                                            <td>
                                                 
                                                <a href="{{ url('project/gantt',$project->id)}}" class="btn btn-sm btn-info">
                                                     <span class="glyphicon glyphicon-tasks"></span> ดู GanttChart</a>
      
                                            </td>
                                            @endif
                                          
                                        </tr>
                                    <div id="detail{!! $project->id !!}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">รายละเอียด</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{!! $project->detail !!}</p>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div> <!-- /widget-content -->
                        </div> <!-- /widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
