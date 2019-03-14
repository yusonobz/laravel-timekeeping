<!DOCTYPE html>
<html>
<title>PB Timekeeping</title>
    <head>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('mdlfile/material.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css" type="text/css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('TimeKeepingCustomCss.css') }}">
        <link rel="stylesheet" href="jquery/jquery-ui.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
    </head>
    <body>  <footer class="footer"style="width:100%;">
      <div class="container">
<marquee style="color:white;overflow:hidden;" behavior="scroll" direction="left">Created by OJT Interns ( Kenneth Azarcon, Aubrey Yuson, Jonathan Roque, Patricia Franchette Gaerlan, Chez Vidal and Carl Roncal )</marquee>
      </div></footer>
    <div class="container md1">
        <div class="row">

    <center>
<div class="demo-card-square mdl-card  col-md-4 col-md-offset-4" style="margin-top:190pt;padding:10pt;">
    <img src="pblogo.png" width='200pt' class="Login_Logo"/>
    <hr/>

    {!!Form::open(['method'=>'Post','url' => '/loguserin'])!!}
<div class="form-group">

{!! Form::text('email',null, ['class' => 'form-control','placeholder'=>'Email', 'style'=>'text-align:center;']) !!}
</div>
<div class="form-group">

{!! Form::password('password', ['class'=>'form-control','placeholder'=>'Password', 'style'=>'text-align:center;']) !!}
</div>
			@if(Session::has('flash_message_error'))
			     <div class="alert alert-danger slim-panel">
			     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			     <p>{{ Session::get('flash_message_error') }}</p>
			    </div>
			@endif
			@if($message)
			<div class="alert alert-danger slim-panel">
			<?php echo $message; ?>
			</div>
			@endif			  
   	<div class="form-group">
{!! Form::submit( 'Login', ['class'=>'btn form-control LoginBtn']) !!}
</div>
	{!! Form::close() !!}
	</div>
