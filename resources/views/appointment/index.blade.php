@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading clearfix" >
                    <h3 class="panel-title pull-left" style="padding-top: 7.5px;">การนัดหมายทั้งหมด</h3>
					<div class="pull-right">
						มีการนัดหมายทั้งหมด {!! $app_total !!} ครั้ง มาตามนัด {!! $go_total !!} ทั้งหมด
						ไม่มาตามนัดทั้งหมด  {!! $nogo_total !!}
						คิดเป็น @if($go_total != 0) {!!  number_format((($go_total/$app_total)* 100), 2, '.', '') !!} @endif เปอเซนต์

						<a href="{{ url('appointment/create') }}" class="btn btn-success btn-sm">
							<span class="glyphicon glyphicon-plus"></span> สร้างนัดหมาย</a>

						</div>
					</div>
					<div class="panel-body">
						<div class="span7">   
							<div class="widget stacked widget-table action-table">
								<div class="widget-content">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>หัวข้อ</th>
												<th>รายละเอียด</th>
												<th>นัดกับ</th>
												<th>สถานที่</th>
												<th>วันที่และเวลา</th>
												<th>การอนุญาติ</th>
												<th>สถานะการเข้าพบ</th>
												<th>จัดการ</th>
											</tr>
										</thead>
										<tbody> 
											@if($appointments)
											@foreach($appointments as $key => $appointment)
											<tr  class="clickable" id="row1" data-target=".row{!!$key!!}" 
											data-toggle="collapse">
											<td>{!! $appointment->title !!}</td>
											<td>
												<a data-toggle="modal" 
												data-target="#modal{!! $key !!}" class="remove btn btn-success">
												<span class="glyphicon glyphicon-plus"></span> ดูรายละเอียด</a>
											</td>
											<td>อาจารย์ {!! $appointment->adviser->first_name !!}</td>
											<td>{!! $appointment->location !!}</td>
											<?php
											$strDate = $appointment->due_date ;
											$strYear = date("Y",strtotime($strDate))+543;
											$strMonth= date("n",strtotime($strDate));
											$strDay= date("j",strtotime($strDate));
											$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
											$strMonthThai=$strMonthCut[$strMonth];
											$strDates ="$strDay $strMonthThai $strYear";
											?>
											<td>วันที่ {{$strDates}} เวลา{!! $appointment->appoint_time !!}</td>
											<td>{!! $appointment->approve !!}</td>
											<td>{!! $appointment->status !!}</td>
											@if($appointment->status!='เข้าพบแล้ว')
											<td>
												<a  href="{{ url('appointment/postponse',['id'=>$appointment->id])}}" 
													class="btn btn-primary"><span class="glyphicon glyphicon-time"></span> เลือนนัด</a>
													
													<a href="{{ url('appointment/edit',$appointment->id)}}" class="btn btn-warning">
														<span class="glyphicon glyphicon-pencil"></span> แก้ไข</a>
														<a  href="#myModal" data-url="{{ url('appointment/delete',$appointment->id)}}" data-toggle="modal"
															data-target="#myModal" class="remove btn btn-danger">
															<span class="glyphicon glyphicon-trash"></span> ลบ</a>

														</td>
														@else
														<td></td>
														@endif
													</tr>
													<div id="modal{!! $key !!}" class="modal fade">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4<h4 class="modal-title">รายละเอียด</h4>

																</div>
																<div class="modal-body">
																	{!! $appointment->detail !!}
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
