@extends('masterAdmin')

	@section('body')

		 <div class="col-lg-10 col-md-8 col-md-offset-1 ">
			<h1> Edit Employee </h1>	
			<br>
				
						{!!Form::open(['url' => '/modifyEmployee','method' => 'POST']) !!}
								<div class="form-group col-xs-4">
									 <input type="hidden" name="id" id="id" value="{{ $user[0]->id }}">
										{!! Form::label('fname', 'First Name:') !!}
								
										 <input class="form-control" type="text" value="{{ $user[0]->fname }}" id="fname" name="fname">
										
										</div>
										<div class="form-group col-xs-4">
										{!! Form::label('mname', 'Middle Name:') !!}
										<!-- {!! Form::text('mname', '', ['class'=>'form-control', 'placeholder'=>'Middle Name']) !!} -->
										<input class="form-control" placeholder="Middle Name" name="mname" type="text" value="{{ $user[0]->mname }}" id="mname">
										</div>
										<div class="form-group col-xs-4">
										{!! Form::label('sname', 'Last Name:') !!}
										<!-- {!! Form::text('sname', '', ['class'=>'form-control', 'placeholder'=>'Last Name']) !!} -->
										<input class="form-control" placeholder="Last Name" name="sname" type="text" value="{{ $user[0]->sname }}" id="sname">
										</div>
										<div class="form-group col-xs-4">
										 {!! Form::label('department', 'Department:') !!}
										<select class="form-control" name="department">
											@foreach($department as $departments)

										 	<option value="{{ $departments->dep_id }}" <?= $user[0]->dep_id == $departments->dep_id ? "selected" : ""; ?> >{{ $departments->dep_name }}</option>
										 	@endforeach
										 </select>
										</div>
										<div class="form-group col-xs-4">
										 {!! Form::label('classification', 'Employment Classification:') !!}

										 <select class="form-control col-xs-4" name="classification">
											@foreach($classification as $class)	
										 	<option value="{{$class->class_id}}" <?= $user[0]->class_id == $class->class_id ? "selected" : ""; ?> >{{$class->class_name }}</option>
										 	@endforeach
										 </select>
										</div>

										<div class="form-group col-xs-4">
										 {!! Form::label('position', 'Position:') !!}

										 <select class="form-control col-xs-4" name="position">
											@foreach($position as $pos)	
										 	<option value="{{$pos->id}}" <?= $user[0]->position_id == $pos->id ? "selected" : ""; ?> >{{ $pos->position_description }}</option>
										 	@endforeach
										 </select>
										</div>
										<!-- cannot retrieve option value-->
										<div class="form-group col-xs-4">
											{!! Form::label('start', 'Start of Employment:') !!}

										<input type="text" class="form-control " id="datepicker" name="start_of_employment" value="{{ $user[0]->start_of_employment }}" readonly> 
										</div>

										<div class="form-group col-xs-4">
										{!! Form::label('email', 'E-mail:') !!}
					
									<input class ="form-control" value="{{ $user[0]->email }}" type="email" name="email">
										</div>


										<div class="form-group col-xs-4">
										 {!! Form::label('accesslevel', 'Access Level:') !!}

										 <select class="form-control" name="accesslvl_id">
											@foreach($accesslevel as $acc)	
										 	<option value="{{$acc->acclvl_id}}" <?= $user[0]->accesslvl_id == $acc->acclvl_id ? "selected" : ""; ?> >{{ $acc->access_name }}</option>
										 	@endforeach
										 </select>
										</div>

										<div class="form-group col-xs-4">
										 {!! Form::label('schedule', 'Schedule:') !!}

										 <select class="form-control" name="sched_id">
									 		@foreach($schedule as $sched)	
										 	<option value="{{$sched->id}}" <?= $user[0]->sched_id == $sched->id ? "selected" : ""; ?> >{{ \Carbon\Carbon::parse($sched->time_in)->format('h:i:s A') . ' - ' . \Carbon\Carbon::parse($sched->time_out)->format('h:i:s A')}}</option>
										 	@endforeach
										 </select>
										</div>								
										<div class="form-group col-xs-4"><br><br><br><br>
											{!! Form::submit('Save', ['class'=>'btn btn-success btn-md ']) !!}
					
										<a href="{{ url('/recordM') }}" class="btn btn-primary" role="button">Back</a>
										</div>
								</div>
								{!! Form::close() !!}	
				</div>

	@endsection