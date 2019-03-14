
<?php
$set;
	if(Auth::user()->accesslvl_id == 1){
		
		$set = 'masterAdmin';
	}else{
		$set = 'master';
	}


?>
@extends($set)
	@section('body')
<?php
$count =0;
foreach ($attendance as $att) {
	if(!empty($att->DisplayPicture)&& $count < 1){
		$dp = $att->DisplayPicture;
		$count++;
	}
}
?>

		<div class="container">
			<div class="row">

				<div class="col-lg-12">
					<div class="datetime">
						<div class="bs-example">
							<div class="col-lg-16 col-offset-6 centered">
						<div class="EmployeeImaage" style="margin-top:75pt;">
<button id="demo-menu-lower-left">
<img src="{{ asset($dp) }}" alt="Image" width="140pt" height="140pt" class="img-circle"/>
</button>
<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-left">
    	<li class="mdl-menu__item"><i class="fa fa-users"></i><a data-toggle="modal" data-target="#changeDP" style="text-decoration:none;"><font color="black">Change Display Picture</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-pencil-square-o"></i><a data-toggle="modal" data-target="#aw" style="text-decoration:none;"><font color="black">Change Password</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-sign-out"></i><a href="{{ url('/logout') }}" style="text-decoration:none;" ><font color="black">Logout</font></a></li>
</ul>
								<h2>{{ Auth::user()->fname }}</h2>					
							</div>
							</div>
<!-- changepass modal -->

@include('_ChangePassForm')
	@include('_ChangeDp')
								{!!Form::open(['url' => '/filterHistory','method' => 'POST','class'=>'form-inline','role'=>'form']) !!}
						         {!! Form::label('from', 'From:') !!}
						         {!! Form::text('from', date('Y-m-d'), ['class'=>'form-control datepicker', 'placeholder'=>'From',   'id'=>'from-date', 'value' => '']) !!} 
						         {!! Form::label('to', 'To:') !!}
						         {!! Form::text('to', date('Y-m-d'), ['class'=>'form-control datepicker', 'placeholder'=>'To',  'id'=>'to-date', 'value'=>' ']) !!}
						         {!! Form::submit('Filter',  ['class'=>'btn btn-default form-control', 'placeholder'=>'Apply',  'id'=>'apply']) !!}  						         						         
						      	 {!! Form::close() !!}

							</div>
								<table class="table table-condensed" id="example" data-height="200"  data-toggle="table" data-pagination="true">
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
											<td>{{ $att->mins_late }} minute(s)</td>
											<td class="centerheader">{{ $att->hrs_rendered }} hour(s)</td>
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
@endsection

