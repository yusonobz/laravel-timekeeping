	@extends('master')

	@section('body')
<div class="container">
<div class="row">
<div class="EmployeeImaage" style="margin-top:75pt;">
<button id="demo-menu-lower-left">
<img src="{{ Auth::user()->DisplayPicture }}" alt="Image" width="140pt" height="140pt" class="img-circle"/>
</button>
<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-left">
    	<li class="mdl-menu__item"><i class="fa fa-users"></i><a data-toggle="modal" data-target="#changeDP" style="text-decoration:none;"><font color="black">Change Display Picture</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-pencil-square-o"></i><a data-toggle="modal" data-target="#aw" style="text-decoration:none;"><font color="black">Change Password</font></a></li>
    <li class="mdl-menu__item"><i class="fa fa-sign-out"></i><a href="{{ url('/logout') }}" style="text-decoration:none;" ><font color="black">Logout</font></a></li>
</ul>
<h2>{{ Auth::user()->fname }}</h2>
</div>
  <a href="{{ url('/add-attendance') }}" class="mdl-navigation__link" data-toggle="tooltip" data-placement="bottom" title="Click to Time In"><i class="fa fa-calendar-check-o fa-4x circle-icon"></i></a>
               <a href="{{ url('/add-OB-attendance') }}" class="mdl-navigation__link" data-target="#OBmodal" data-toggle="modal" data-placement="bottom" title="Official Business"><i class="fa fa-briefcase fa-4x circle-icon"></i></a>
        <a href="{{ url('/add-timeout/'.Auth::user()->id) }}" class="mdl-navigation__link" data-toggle="tooltip" data-placement="bottom" title="Click to Time Out"><i class="fa fa-calendar-times-o fa-4x circle-icon"></i></a>

</div>
		<!-- changepass modal -->

		@include('_ChangePassForm')

		<!-- END OF CHANGEPASS MODAL -->

		<!-- Change Display Picture Modal -->
		@include('_ChangeDp')
				<!-- END OF Change DP MODAL -->
		<!-- Modal -->
<div id="OBmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Official Bussiness Schedule</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['method'=> 'PATCH','url'=>'/user']) !!}
        <div class="Form-group">
        {!! Form::label('Date','Date:') !!}
        {!! Form::input('date','Date', date('Y-m-d') ,['class' => 'form-control']) !!}
    </div>
    <div class="Form-group">
   {!! Form::label('time_in','From:') !!}
        {!! Form::input('time','time_in',  time('h:i a') ,['class' => 'form-control','id'=>'time_in']) !!}
    </div>
 <div class="Form-group">
   {!! Form::label('time_out','To:') !!}
        {!! Form::input('time','time_out', time('h:i a') ,['class' => 'form-control','id'=>'time_out']) !!}
    </div>

  </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Confirm</button>
         <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
      </div>
  </div>
</div>
</div>
	@if(Session::has('flash_message_error'))
	     <div class="alert alert-info slim-panel">
	     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	     <p>{{ Session::get('flash_message_error') }}</p>
	    </div>
	@endif


	<div class="container">
		<div class="row">
			<div class="col-lg-12">
					<table class="table table-hover">
    <thead>
      <tr>
        <th class="TbHeader">Date</th>
        <th class="TbHeader">Time In</th>
        <th class="TbHeader">Remarks</th>
        <th class="TbHeader">Time Out</th>

      </tr>
    </thead>
    <tbody>
					  <tbody>

					  	@foreach($attendance as $att)
				
					  	@if(\Carbon\Carbon::today()->toDateString() == $att->date && Auth::user()->id == $att->id)
						<tr>
<!-- 						  <td>{{ $att->fname.' '.$att->mname.' '.$att->sname }}</td> -->
						  <td>{{ \Carbon\Carbon::parse($att->date)->format('M d, Y')  }}</td>
						  <td>{{ \Carbon\Carbon::parse($att->time_in)->format('h:i:s A') }}</td>
						  <td>{{ $att->stat_name }}</td>
						@if($att->time_out == '00:00:00')
						  <td>---------------</td>
						@else
						  <td>{{ \Carbon\Carbon::parse($att->time_out)->format('h:i:s A') }}</td>
						@endif
						</tr>
						@endif
						@endforeach
					  </tbody>
					</table>
				</div>

		</div>
	</div>
			@if ($errors->any())
						<div class="alert alert-warning">
							@foreach ($errors->all() as $error)
								<i class="fa fa-exclamation-triangle"></i> {{ $error }}<br />
							@endforeach
						</div>
					@endif
@endsection




						