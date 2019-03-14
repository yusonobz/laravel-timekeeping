@extends('masterAdmin')

	@section('body')
@include('_ChangePassForm')
@include('_ChangeDp')
	


			<div class="col-lg-16">
				<div class="container">
					<div class="EmployeeImaage" style="margin-top:40pt;">
<button id="demo-menu-lower-left">
<img src="{{Auth::user()->DisplayPicture}}" alt="Image" width="140pt" height="140pt" class="img-circle"/>
</button>
<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-left">
    	<li class="mdl-menu__item"><i class="fa fa-users"></i><a data-toggle="modal" data-target="#changeDP" style="text-decoration:none;"><font color="black">Change Display Picture</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-pencil-square-o"></i><a data-toggle="modal" data-target="#aw" style="text-decoration:none;"><font color="black">Change Password</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-sign-out"></i><a href="{{ url('/logout') }}" style="text-decoration:none;" ><font color="black">Logout</font></a></li>
</ul>
<h2>{{ Auth::user()->fname }}</h2>
</div>

					<div class="datetime">
						<div class="row">
						    <div class="bs-example">
						      <div class="col-lg-16 col-offset-6 centered">   
						         {!!Form::open(['url' => '/extract','method' => 'POST','class'=>'form-inline','role'=>'form']) !!}
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
						         <!-- <a href="javascript:void" id="trigger-download" class = "btn btn-default form-control" role ="button"><i class="fa fa-download obj-color"></i>Download PDF</a><br> -->
								 <a href="javascript:void" id="trigger-downloadexcel" class = "btn btn-default form-control" role ="button"><i class="fa fa-download obj-color"></i>Download excel</a>
						         <a href="javascript:void" id="trigger-downloadpdf" class = "btn btn-default form-control" role ="button"><i class="fa fa-download obj-color"></i>Download PDF</a><br>
						      	 {!! Form::close() !!}						 
						      	 <!-- STATUS FILTER -->						        
						<!-- 			        {!!Form::open(['url' => '/filterbyStatus','method' => 'POST','class'=>'form-inline','role'=>'form']) !!}	
									        {!! Form::label('sortby', 'Sort By:') !!}
									           <select class="form-control" name="sched_id">
									           	<option value="0">All</option>
									            <option value="1">Late</option>
									            <option value="3">Present</option>
									            <option value="4">OB</option>
									           </select>
									        </div>  
									        {!! Form::submit('Filter Status',  ['class'=>'btn btn-default form-control', 'placeholder'=>'Filter Status',  'id'=>'apply']) !!}
									        {!! Form::close() !!} -->     
								<br>
								 <div class="col-lg-16 col-offset-6 centered">  
								<table class="table table-condensed" id="example" data-height="200"  data-toggle="table" data-pagination="true">
									<thead>
										<tr>
											<th>Name</th>
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
											<td>{{ $att->fname.' '.$att->mname.' '.$att->sname }}</td>						
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
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			// Initialize datepicker 
			$( ".datepicker" ).datepicker({
				changeYear: true,
				yearRange: '2010:2016',
				changeMonth: true,
				dateFormat: 'yy-mm-dd'

			});
			// Before execute request assign value
			$('#trigger-downloadexcel').click(function() {
				var fromDate = $('#from-date').val();
				var toDate = $('#to-date').val();
				var sched_id = $('#sched_id').val();
				window.location.href = "{{ url('dl') }}?from_date="+fromDate+"&to_date="+toDate+"&sched_id="+sched_id;
			

			});
			$('#trigger-downloadpdf').click(function() {
				var fromDate = $('#from-date').val();
				var toDate = $('#to-date').val();
				var sched_id = $('#sched_id').val();
				window.location.href = "{{ url('download') }}?from_date="+fromDate+"&to_date="+toDate+"&sched_id="+sched_id;
			

			});
		});
	</script>
@endsection


						