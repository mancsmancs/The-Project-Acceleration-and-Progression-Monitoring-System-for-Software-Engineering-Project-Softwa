<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <META http-equiv="refresh" CONTENT="300">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Software Engineering Project</title>

        <link rel="shortcut icon" href="/css/icon_s.ico">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="/css/chosen.css" rel="stylesheet" >
        <link href="/css/bootstrap3-wysihtml5.css" rel="stylesheet" >
        

        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/css/validationEngine.jquery.css">
        @section('js')
            @if(Request::is('*/gantt'))
            <script src="/js/jquery.ganttView/lib/jquery-1.4.2.js"></script>
            
            @else
            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            @endif
            <link href="/js/jquery.ganttView/jquery.ganttView.css" rel="stylesheet" >
            <script src="/js/jquery.ganttView/lib/date.js"></script>
            <script src="/js/jquery.ganttView/jquery.ganttView.js"></script>
            <script src="/js/jquery.ganttView/lib/jquery-ui-1.8.4.js"></script>
            
            
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="/js/moment-with-locales.js" ></script>
        <script src="/js/chosen.jquery.min.js" ></script>

        <!--<script type="text/javascript"src="/js/bootstrap-datepicker.th.js" ></script>-->
        
        <script src="/js/bootstrap-datetimepicker.js" ></script>
        <script src="/js/bootstrap-datepicker.js" ></script>
        <!--<script src="/js/bootstrap-datetimepicker.min.js" ></script>-->
        <script src="/js/moment.js" ></script>
        <script src="/js/th.js" ></script>
        <!--<script src="/js/bootstrap3-wysihtml5.all.min.js" ></script>-->
        <script src="/js/jquery.blockUI.js" ></script>
        <script src="/js/readmore.js" ></script>
        <script type="text/javascript" src="/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="/js/jquery.validationEngine-en.js"></script>
        <!--<script>
$('textarea').wysihtml5();
        </script>-->
        @endsection
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">The Project Acceleration and Progression Monitoring System</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                    <ul class="nav navbar-nav navbar-right list-inline">
                        @if (Auth::guest())
                        <li><a href="{{ url('auth/login')}}">เข้าสู่ระบบ</a></li>
                        <li><a href="{{ url('auth/register')}}">สมัครสมาชิก</a></li>
                        @else
                        <?php
                        if (Auth::user()->role == 'adviser') {
                            $role = 'อาจารย์';
                        } elseif (Auth::user()->role == 'student') {
                            $role = 'นิสิต';
                        }
                        ?>  

                        <li href="#" style=" cursor:pointer;" class="dropdown-toggle" data-toggle="dropdown">


                            <strong>  {!! $role.Auth::user()->first_name ,"  ",Auth::user()->last_name!!}  </strong>
                            <span class="glyphicon glyphicon-chevron-down"></span>

                        </li> 
                        <ul class="dropdown-menu">

                            <li>
                                <div class="navbar-login">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <p class="text-center">
                                                @if(Auth::user()->profile_image)
                                                <span><img class="img-responsive img-thumbnail" width="100px" src="/public/upload/photo/{{Auth::user()->profile_image}}" /></span>

                                                @else
                                                 <span><img class="img-responsive img-thumbnail" width="100px" src="/public/upload/photo/default.png" /></span> 
                                                <!--<span class="glyphicon glyphicon-user icon-size"></span>-->
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-lg-8">
                                            <p class="text-left"><strong>  {!! $role.Auth::user()->first_name !!}  {!! Auth::user()->last_name !!}  </strong></p>
                                            <p class="text-left small">  {!! Auth::user()->email !!}  </p>
                                        
                                        <div class="col-md-10 col-md-offset-1">
                                            <p class="text-left">  
                                                <a href="{{ route('profile')}}" class="btn btn-primary btn-block btn-sm">แก้ไขประวัติ</a>
                                            </p>
                                            <p class="text-left">
                                                  <a href="{{url('/test_delete')}}" class="btn btn-danger btn-block btn-sm">ลบผู้ใช้</a>
                                            </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="navbar-login navbar-login-session">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <a href="{{ route('logout')}}" class="btn btn-danger btn-block">ออกจากระบบ</a>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @include('notifications')  
        <div class="col-md-2">
            @if (Auth::user())
            <div class="panel panel-default">
                <div class="panel-body">
                    <nav class="navbar navbar-default" role="navigation">
                        <!-- Main Menu -->
                        <div class="side-menu-container">
                            <ul class="nav navbar-nav">
                                <li @if(Request::is('notification/*')) class="active" @endif><a href="{{ url('notification/index',['status'=>'0']) }}">
                                        <span class="glyphicon glyphicon-bell"></span> การแจ้งเตือน <span class="badge">{{ $unread = App\Notification::where('is_read',0)->where('reciver_id',Auth::user()->id)->count() }}
                                </span></a></li>
                                <li @if(Request::is('project/*')) class="active" @endif><a href="{{ url('project/index')}}">
                                        <span class="glyphicon glyphicon-briefcase"></span> โปรเจค</a></li>
                               @if(\Auth::user()->role == 'student')             
                                <li @if(Request::is('activity/*')) class="active" @endif><a href="{{ url('activity/index')}}">
                                        <span class="glyphicon glyphicon-tasks"></span> ตารางงาน</a></li>
                               @endif        
                                <li @if(Request::is('appointment/*')) class="active" @endif><a href="{{ url('appointment/index')}}">
                                        <span class="glyphicon glyphicon-file"></span> การนัดหมาย</a></li>
                                <!--<li (Request::is('/*'))  ><a href="https://goo.gl/ecEdFh">
                                        <span class="glyphicon glyphicon-calendar"></span>คู่มือการใช้งาน</a></li>
                                <li (Request::is('/*'))  ><a href="https://plus.google.com/u/0/+PhattharaminInlee/posts">
                                        <span class="glyphicon glyphicon-wrench"></span>แจ้งปัญหาการใช้งาน</a></li>-->
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </nav>
                </div>
            </div>
            @endif 
        </div>
        <div class="col-md-10">
            @yield('content')
        </div>
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">ยืนยันการลบ</h4>
                    </div>
                    <div class="modal-body">
                        <p>คุณต้องการลบจริงๆ หรอ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                        <a href="#" id="delete" class=" btn btn-danger">ลบ</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
    @yield('js')
    @yield('specific_script')
    <script>
         $(".chosen").chosen();
        $('.remove').click(function (e) {
            var href = $(this).attr("data-url");
            console.log(href);
            $('#delete').attr("href", href)
        });
        $("form").validationEngine();
    </script>

</html>
