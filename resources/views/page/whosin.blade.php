@extends('masterAdmin')
	
	@section('body')


 	<div class="con container">
		<div class="row">		
			<div class="col-lg-12">


			<div class="EmployeeImaage" style="margin-top:30pt;">
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

<!-- changepass modal -->

@include('_ChangePassForm')
@include('_ChangeDp')
		<!-- END OF CHANGEPASS MODAL -->	
				<div class="center">
					<br><h2>Who's In?</h2><br>
					<table class="table table-condensed" id="example" data-height="200"  data-toggle="table" data-pagination="true">
					  <thead>
						<tr>
						    <th class="mdl-data-table__cell--non-numeric">Name</th>
						    <th class="mdl-data-table__cell--non-numeric">Time in</th>
						</tr>
					  </thead>
					  <tbody>
					  	@foreach($attendance as $att)
					  	<tr>
					  		<td>{{ $att->fname .' '. $att->mname .' '. $att->sname }}</td>
					  		<td>{{ \Carbon\Carbon::parse($att->time_in)->format('h:i:s A') }}</td>	
					  	</tr>
					  	@endforeach  
					  </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection