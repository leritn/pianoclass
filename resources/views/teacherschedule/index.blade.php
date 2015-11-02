@extends('app')


@section('htmlheader_title')
Teacher Schedule
@endsection


@section('contentheader_title')
<h1>Teacher Schedule <small>Schedule List</small></h1>
@endsection


@section('main-content')
<div class="box  box-solid box-default">
	<div class="box-header">
			<div class="row" >
				<div class="col-xs-12 col-sm-12">
					<button type="button" class="btn  pull-right  btn-circle btn-xs" id="btn-show-hide">
						
						<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
						
					</button>
				</div>
			</div>
			<div class="row" id="sliding">
				<form action="{{url('teacherschedule')}}" method="POST" role="form" id="dateform">
					<div class="col-sm-7">
							{!! csrf_field() !!}
							<div class="input-group ">
								<label>Select Teacher</label>
								<select name="teacher" class="form-control" id="select_teacher" >
									@foreach ($teachers as $teacher)
										<option value="{{$teacher->id}}" <?php
											if($teacher->id == $teacher_id){
												echo "selected";
											}
										 ?> >{{"ครู".$teacher->nickname." "."(".$teacher->firstname." ".$teacher->lastname.")"}}</option>
									@endforeach
								</select>
							</div>
					</div>
					<div class="col-sm-5">
						<label>Select Date Range</label>
						<div class="input-group">
							<div class="input-group-addon">
			                  <i class="fa fa-calendar"></i>
			                </div>
								<input type="text" class="form-control pull-right" id="reservationtime" name="date" 
								value = <?php 
									if($date_request!=NULL){
										echo $date_request;
									}else {
										 $date = new DateTime();
										 $today =$date->format('m/d/Y');
										 echo $today;		
									} ?> 
								>
						      	
					    </div>
					</div>			
				</form>
			</div>
	</div>
	<div class="box-body">
		
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-2 col-sm-4 text-right" style="height:34px;">
					<span>
						
						<a href="#" class="btn btn-responsive btn-default btn-flat">
							<i class="glyphicon glyphicon-chevron-left"></i>
						</a>
					</span>
	            </div>
				<div class="col-xs-8 col-sm-3">						
		            <div align="center"><h5><?php //echo  $date->format('l d F Y');?></h5></div>	               	                
	            </div>
	            <div class="col-xs-2 col-sm-5 " style="height:34px;">
	            	<span>
	            	
						<a href="#" class="btn btn-responsive btn-default btn-flat">
							<i class="glyphicon glyphicon-chevron-right"></i>
						</a>
					</span>
	            </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" style="height:10px"></div>
		</div>
		
		<div class="table-responsive">
			<table class="table table-hover table-bordered " id="tabel-teacher-schedule">
				<thead>
					<tr>
						<th bgcolor="#736F6E" style="text-align:center"><font color="white" >Time/Days</font></th>
						@foreach($date_range_selected as  $key=>$date)
							<th  bgcolor="#736F6E" style="text-align:center">
								<a href="{{url('schedule/create')}}/?teacher={{$teacher_id}}&day={{$key}}" class="link-color" >
									<i class="fa fa-plus-square-o"></i>
									<b >{{$date}}</b>
								</a>
							</th>
						@endforeach
					</tr>
					
				</thead>
				<tbody>
					@foreach($time_in_config as $time_in_header)
						<tr>
								
							<td  bgcolor="#A0A0A0" align="center">
								<font color="#ffffff">{{$time_in_header}}</font>
							</td>
								
								@foreach($date_range_selected as  $key=>$date)
								<?php 

										$student_name ='';
										$schedule_id = '';
								?>		
								<?php	 if(isset($schedule_of_teacher[$date][$time_in_header]))
										{	
											$student_name = $schedule_of_teacher[$date][$time_in_header];  
											$schedule_id = $schedules_id[$date][$time_in_header];
											?>
											<td onclick="document.location.href='{{url('schedule/'.$schedule_id.'/edit')}}/?teacher={{$teacher_id}}&day={{$key}}&time={{$time_in_header}}' " bgcolor="#C0D0FF" align="center"> {{$student_name}} </td>	

								<?php   } 
										else {
										?>	<td bgcolor="#FFFFFF"></td>
								<?php		}

								?>		
								@endforeach
						
						</tr>
					@endforeach
					
				</tbody>
			</table>
		</div>

</div>


@endsection

@section("script")

	<script type="text/javascript">
		$(document).ready(function(){
			var now = moment();
			var next_seven_day = moment().add(7, 'days');
			var current_days = moment(now).format('MM/DD/YYYY');
			var sevendays = moment(next_seven_day).format('MM/DD/YYYY');
			$('#reservationtime').daterangepicker({
				"ranges":{
					"Today":[],
					"7 Days":[
						current_days,
						sevendays
					]
				}
			});
			$('#reservationtime').on('apply.daterangepicker' , function(ev, picker) { 
				$("#dateform").submit();
			});

			$("#sliding").hide();
			$("#btn-show-hide").show();	
			$("#btn-show-hide").click(function(){
			$("#sliding").slideToggle();

			});	

		})
	</script>
@endsection