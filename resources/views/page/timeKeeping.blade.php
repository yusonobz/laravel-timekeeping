@extends('masterAdmin')
		
	@section('body')

@include('_ChangePassForm')
@include('_ChangeDp')
		<div class="col-lg-12 col-md-12">
			<img src="{{ asset('pb_logo.png') }}" style="width:300pt;height:90pt;margin-bottom:45pt;"/>
		</div>
		<div class="container" style="margin-top:20pt;">
			<div class="row">
				<h2 style="color:gray;text-shadow: 1pt 1pt black;">Active Employees</h2>
			@foreach($users as $user)
			@if($user->Employee_Status == 'Active')
			<?php $userID = $user->id ?>
				<div class="col-lg-3 col-md-4">
					<div class="EmployeeImaage EmpPageDesign mdl-shadow--4dp" style="margin-top:10pt;">
					<button id="<?php echo $userID ?>" style="position:relative;float:right;background-color:transparent;border-width:0px;">
					<i class="fa fa-cogs"></i>
					</button>
<img src="{{ $user->DisplayPicture }}" alt="Image" width="140pt" height="140pt" class="img-circle"/><br>
<h3 style="color:white;">{{ $user->fname }}</h3>


<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="<?php echo $userID ?>" style="position:absolute;z-index:9999;">

    <li class="mdl-menu__item"><i class="fa fa-thumbs-up"></i><a href="{{ url('/timeKeeping/Activate/'.$user->id) }}" style="text-decoration:none;" ><font color="black">&nbsp;Active</font></a></li>
  <li class="mdl-menu__item"><i class="fa fa-thumbs-down"></i><a href="{{ url('/timeKeeping/Deactivate/'.$user->id) }}" style="text-decoration:none;" ><font color="black">&nbsp;Inactive</font></a></li>

</ul>
<a href="{{ url('/employeeRecord/'.$user->id) }}" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
							<font color="purple">view record</font>
							</a>

</div>
				</div>
				@endif
			@endforeach
		</div>
	</div>

<div class="col-lg-12 col-md-12">
		
		<div class="container" style="margin-top:20pt;">
			<div class="row">
		<h2 style="color:gray;text-shadow: 1pt 1pt black;">Inactive Employees</h2>
			@foreach($users as $user)
			@if($user->Employee_Status == 'Inactive' || $user->Employee_Status == '')
			<?php $userID = $user->id ?>
			<div class="col-lg-3 col-md-4">
					<div class="EmployeeImaage EmpPageDesign mdl-shadow--4dp" style="margin-top:10pt;">
					<button id="<?php echo $userID ?>" style="position:relative;float:right;background-color:transparent;border-width:0px;">
					<i class="fa fa-cogs"></i>
					</button>
					<img src="{{ $user->DisplayPicture }}" alt="Image" width="140pt" height="140pt" class="img-circle"/><br>
					<h3 style="color:white;">{{ $user->fname }}</h3>

					<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="<?php echo $userID ?>" style="position:absolute;z-index:9999;">
  						  <li class="mdl-menu__item"><i class="fa fa-thumbs-up"></i><a href="{{ url('/timeKeeping/Activate/'.$user->id) }}" style="text-decoration:none;" ><font color="black">&nbsp;Active</font></a></li>
 						  <li class="mdl-menu__item"><i class="fa fa-thumbs-down"></i><a href="{{ url('/timeKeeping/Deactivate/'.$user->id) }}" style="text-decoration:none;" ><font color="black">&nbsp;Inactive</font></a></li>
					</ul>
					<a href="{{ url('/employeeRecord/'.$user->id) }}" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
						<font color="purple">view record</font>
					</a>

				</div>
			</div>
			@endif
			@endforeach
			{{ $users->render() }}

			</div>
		</div>
	</div>
@endsection