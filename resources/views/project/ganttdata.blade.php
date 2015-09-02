@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">ตารางงานของโปรเจค 
                    <?php $projects = App\Project::find(Request::segment(3))->get();
                    foreach ($projects as $key => $project) {
                        if($project->id==Request::segment(3))
                        {
                            $projectname = $project->name;
                            //dd($project->name);
                        }else{

                        }
                    }
                     ?> 
                    {!! $projectname !!} </div>
                <div id="ganttChart"></div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('specific_script')
<script>
    $.ajax({
        url: '{{ url("project/ganttt",$id) }}',
        type: "get",
        dataType: 'json',
        success: function (data) {
//             var result = {};
            for (i = 0; i < data.length; i++) {
                if(("series" in data) ){
                var serie_length = data[i].series.length;
                var serie = data[i].series;
                for (j = 0; j < serie_length; j++) {
                      data[i].series[j].start = new Date( data[i].series[j].start);
                     data[i].series[j].end =   new Date(data[i].series[j].end);
                }
            }
        }
            $("#ganttChart").ganttView({
                data: data,
                slideWidth: 700,
                behavior: {
                    onClick: function (data) { 
                        var msg = "You clicked on an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                        $("#eventMessage").text(msg);
                    }
                    //clickable: true,
                    //draggable: true,
                    //resizable: true
                }
            })
        }
    })
</script>

@stop