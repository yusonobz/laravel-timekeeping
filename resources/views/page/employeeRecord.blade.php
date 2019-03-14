@extends('masterAdmin')

	@section('body')
	<script type="text/javascript">
		$(document).ready(function() {
			// Initialize datepicker 
			$( ".datepicker" ).datepicker({
				changeYear: true,
				yearRange: '2010:2016',
				changeMonth: true,
				dateFormat: 'yy-mm-dd'

			});
			// Before execute request assign value
			$('#trigger-download').click(function() {
				var fromDate = $('#from-date').val();
				var toDate = $('#to-date').val();
				window.location.href = "{{ url('download') }}?from_date="+fromDate+"&to_date="+toDate;
			

			});
		});
	</script>
@include('_ChangePassForm')
@include('_ChangeDp')
		<div class="container">
			<div class="row">
				<div class="col-lg-12">	
					<h1>{{ $user->DisplayPicture }}</h1>
<div class="EmployeeImaage" style="margin-top:20pt;">
<button id="demo-menu-lower-left">
<img src="{{ asset($user->DisplayPicture) }}" alt="Image" width="140pt" height="140pt" class="img-circle"/>
</button>
<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-left">
    	<li class="mdl-menu__item"><i class="fa fa-users"></i><a data-toggle="modal" data-target="#changeDP" style="text-decoration:none;"><font color="black">Change Display Picture</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-pencil-square-o"></i><a data-toggle="modal" data-target="#aw" style="text-decoration:none;"><font color="black">Change Password</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-sign-out"></i><a href="{{ url('/logout') }}" style="text-decoration:none;" ><font color="black">Logout</font></a></li>
</ul>
					<h3 class="intenthead"><strong>{{ $user->fname . ' '.  $user->mname . ' ' . $user->sname }}</strong></h3>		
					</div>				
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-16">
					<div class="bs-example">
						<div class="col-lg-16 col-offset-6 centered">   
							<pre><b><font color="red">{{ 'Total Minutes Late: ' . $countMins . ' minute(s)'}}<br>{{ 'Total Minutes Under Time: ' . $countUnderTime . ' minute(s)' }}</font><br><font color="green">{{ 'Total Hours Rendered: '. $countHrs . ' hour(s)' }}</font></b></pre>
								<br>
						         {!!Form::open(['url' => '/individualExtract','method' => 'POST','class'=>'form-inline','role'=>'form']) !!}
						         {!! Form::label('from', 'From:') !!}
						         {!! Form::text('from', date('Y-m-d'), ['class'=>'form-control datepicker', 'placeholder'=>'From',   'id'=>'from-date', 'value' => '']) !!} 
						      	<!-- ($old_fr ? $old_fr : date('Y-m-d'))
						      			($old_to ? $old_to : date('Y-m-d')) -->
						         {!! Form::label('to', 'To:') !!}
						         {!! Form::text('to', date('Y-m-d'), ['class'=>'form-control datepicker', 'placeholder'=>'To',  'id'=>'to-date', 'value'=>' ']) !!}			
									           <select class="form-control" name="sched_id" id="sched_id">
									           	<option value="0">All</option>
									            <option value="1">Late</option>
									            <option value="3">Present</option>
									            <option value="4">OB</option>
									           </select>
						         {!! Form::submit('Filter',  ['class'=>'btn btn-default form-control', 'placeholder'=>'Apply',  'id'=>'apply']) !!}  
						       <!--   <a href="javascript:void" id="trigger-download"><i class="fa fa-download fa-2x obj-color"></i></a><br>  -->
						       <button type = "button" class = "btn" data-toggle="modal" data-target="#manual">Add Attendance</button>
						        <a style="background-color:#9259a1;color:white;width:120pt;font-family:arial;font-size:11pt;" class="btn btn-sm" href="{{ url('/download/'.$id) }}" >Download DTR</a>
						         <input type="hidden" name="emp_id" value="{{ $id }}">
						      	 {!! Form::close() !!}

								<br>     	
								
								<!-- Modal -->
								<div id="manual" class="modal fade" role="dialog">
								  <div class="modal-dialog">

								    <!-- Modal content-->
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">Manual Add Attendance</h4>
								      </div>
								      <div class="modal-body">
								        	 {!!Form::open(['url' => '/manualAttendance','method' => 'POST','class'=>'form-inline','role'=>'form']) !!}
						     
									      	 {!! Form::label('timein', 'Time in:') !!}
									         {!! Form::text('timein', '', ['class'=>'form-control', 'placeholder'=>'Time In', 'value' => '']) !!} 
									         
									  <!--        {!! Form::label('timeout', 'Time out:') !!}
									         {!! Form::text('timeout', '', ['class'=>'form-control', 'placeholder'=>'Time Out', 'value' => '']) !!}  -->
								      </div>
								      <div class="modal-footer">
								      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								      	<input type="hidden" name="emp_id" value="{{ $id }}">
								      	{!! Form::submit('Add', ['class'=>'btn btn-success', 'placeholder'=>'Add', 'id'=>'add']) !!}
								      	{!! Form::close() !!}
								      </div>
								    </div>
								  </div>
								</div>
								<!-- End of Modal -->
						         <input type="hidden" name="emp_id" value="{{ $id }}">
						      </div>
							<table class="table table-condensed" id="example" data-height="200"  data-toggle="table" data-pagination="true" style="background-color:gray;color:white;">
								<thead>
									<tr>
										<th>Date</th>
										<th>Time in</th>
										<th>Time out</th>
										<th>Remarks</th>
										<th>Minutes Late</th>
										<th class="centerheader">Hours Rendered</th>
										<th>Under Time</th>
									</tr>
								</thead>
								<tbody>
									@foreach($attendance as $att)
									<tr>						
										<td>{{ \Carbon\Carbon::parse($att->date)->format('M d, Y')  }}</td>
										<td>{{ \Carbon\Carbon::parse($att->time_in)->format('h:i:s A') }}</td>
									@if($att->time_out == '00:00:00')
						  				<td>---------------</td>
									@else
						  				<td>{{ \Carbon\Carbon::parse($att->time_out)->format('h:i:s A') }}</td>
									@endif
										<td>{{ $att->stat_name }}</td>
										<td>{{ $att->mins_late . ' minute(s)'}}</td>
										<td class="centerheader">{{ $att->hrs_rendered . ' hour(s)' }}</td>
										<td>{{ $att->under_time . ' hour(s)'}}</td>	
									</tr>								
									@endforeach
								</tbody>
							</table>

					</div>		
				</div>
			</div>
		</div>
	</div>
@endsection