
<?php
$set;
$btnView;
$view;
	if(Auth::user()->accesslvl_id == 1){
		
		$set = 'masterAdmin';
		$view = 'All';
		$btnView = 'visibility:visible;';

	}else{
		$set = 'master';
			$view = 'My';
$btnView = 'visibility:hidden;';

	}


?>
@extends($set)
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
<h3 style="float:left;"><strong>{{$view}} Official Business Request</strong></h3>
</div>
<!-- changepass modal -->

@include('_ChangePassForm')
	@include('_ChangeDp')
		<!-- END OF CHANGEPASS MODAL -->
		<!-- Modal -->

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
      	<th class="TbHeader">Name</th>
        <th class="TbHeader">Date</th>
        <th class="TbHeader">Request In</th>
        <th class="TbHeader">Request Out</th>
        <th class="TbHeader">Remarks</th>
        @if($set == 'masterAdmin')
        <th style="<?php echo $btnView ?>" class="TbHeader">Action</th>
        @else

        @endif
      </tr>
    </thead>
    <tbody>
					  <tbody>

					  	@foreach($OBattendance as $OBatt)
					<tr>
							<td>{{ $OBatt->fname . ' ' . $OBatt->sname }}</td>			
						  <td>{{ \Carbon\Carbon::parse($OBatt->Date)->format('M d, Y')  }}</td>
						  <td>{{ \Carbon\Carbon::parse($OBatt->Request_In)->format('h:i:s A') }}</td>	
						  <td>{{ \Carbon\Carbon::parse($OBatt->Request_Out)->format('h:i:s A') }}</td>
						  <td>{{ $OBatt->Request_Status }}</td>
						
				
						        @if($set == 'masterAdmin' && $OBatt->Request_Status == 'Pending'  )
						      <td>
						  	  <a style="background-color:#9259a1;color:white;<?php echo $btnView ?>" class="btn btn-sm" href="{{ url('/ObRequest/Grant/'.$OBatt->emp_id) }}" ><i class="fa fa-check-circle-o"></i> Grant</a>
						  	  <a style="background-color:#9259a1;color:white;<?php echo $btnView ?>" class="btn btn-sm" href="{{ url('/ObRequest/Deny/'.$OBatt->emp_id) }}" ><i class="fa fa-times-circle-o"></i> Deny</a></td>
							    @else
        
       							 @endif
				       </tr>
						@endforeach
					  </tbody>
					</table>
					<br><br><br><br>
				</div>
			{{ $OBattendance->render() }} 
		</div>
	</div>
	
	@endsection