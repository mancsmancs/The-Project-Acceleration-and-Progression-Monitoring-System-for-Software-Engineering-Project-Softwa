@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">การแจ้งเตือน </div>
                <div class="panel-body">
                    <div class="span7">   
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <!--<a class="btn btn-primary" href="{{ url('notification/index',['status'=>1])}}">อ่านแล้ว</a>
                                <a class="btn btn-success" href="{{ url('notification/index',['status'=>0])}}">ยังไม่ได้อ่าน</a>
                          	<a class="btn btn-warning" href="{{ url('notification/index',['status'=>2])}}">ดูที่ส่งไป</a>
                          </div> <!-- /widget-header -->
                          <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ส่งจาก</th>
                                        <th>ข้อความ</th>
                                        <th>เนื้อหา</th>
                                        <th>ส่งมาเมื่อ</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($notification)
                                    @foreach($notification as $key => $notification)
                                    <tr>
                                        <td><!--ถ้าส่งมาจากอาจารย์ให้แสดงคำว่าอาจารย์ขึ้นต้น-->
                                            @if($notification->sender->role == 'adviser')
                                            อาจารย์ {!! $notification->sender->first_name !!}
                                            @endif
                                            <!--ถ้าส่งมาจากนิสิตให้แสดงคำว่านิสิตขึ้นต้น-->
                                            @if($notification->sender->role == 'student')
                                            นิสิต {!! $notification->sender->first_name !!}
                                            @endif
                                        </td>
                                        <td> {!! $notification->subject !!}</td>
                                        <td> {!! $notification->body !!}</td>
                                        <td>{!! $notification->created_at !!}</td>
                                        <td>
                                            @if($notification->is_read == 0)
                                            <a href="{{ url('notification/markasread',$notification->id)}}"class="btn btn-warning" >
                                                <span class="glyphicon glyphicon-pencil"></span>รับทราบ</a>
                                                @endif
                                                <!--data-toggle="modal" data-target="#subject{!! $notification->id !!}" class="btn btn-warning" id="openBtn"-->

                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div> <!-- /widget-content -->
                            <!--<ul class="pager">
@if (isset($previous) and $previous->id === $notification->id )
<li class="previous"><a href="{{ $previous->sef }}">←ก่อนหน้า</a></li>
@endif

<li><a href="/notification/index">&uarr;-------</a></li>

@if (isset($next) and $next->id === $notification->id )
<li class="next"><a href="{{ $next->sef }}">ถัดไป→</a></li>
@endif
</ul>-->
                     </div> <!-- /widget -->
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>
@endsection
