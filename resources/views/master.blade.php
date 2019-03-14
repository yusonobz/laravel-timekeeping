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
        <!-- for JQuery-ui-->
        <link rel="stylesheet" href="jquery/jquery-ui.css">

        <link rel="stylesheet" href="/resources/demos/style.css">
    </head>
    <body class = "md1">
        <footer class="footer"style="width:100%;">
      <div class="container">
<marquee style="color:white;overflow:hidden;" behavior="scroll" direction="left">Created by OJT Interns ( Kenneth Azarcon, Aubrey Yuson, Jonathan Roque, Patricia Franchette Gaerlan, Chez Vidal and Carl Roncal )</marquee>
      </div></footer>
  <center>
<nav class="navbar navbar-default navbar-fixed-bottom" style=" background-color: #c1c1c0;">
  <div class="container"style=" background-color: #c1c1c0; margin:0px;width:100%;">
    <ul class="nav navbar-nav" style="width:100%;">
        <li class="col-md-4 col-sm-4 col-xs-4"><a href="{{ url('/user') }}" style="color:purple;"><i class="fa fa-home menuIcon" style="color:white;" aria-hidden="true"></i>&nbsp;<span>Attendance</span></a></li>
        <li class="col-md-4 col-sm-4 col-xs-4"><a href="{{ url('/history/'.Auth::user()->id) }}"style="color:purple;"><i class="fa fa-history menuIcon" style="color:white;" aria-hidden="true"></i>&nbsp;History</a></li>
         <li class="col-md-4 col-sm-4 col-xs-4"><a href="{{ url('/obrequestlist') }}" style="color:purple;"><i class="fa fa-briefcase menuIcon" style="color:white;" aria-hidden="true"></i>&nbsp;<span>Official Business Request</span></a></li>

    </ul>
  </div>
</nav>
        @yield('body')   
                <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
                   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
         <link rel="stylesheet" href="jquery/jquery-ui.css">
        <script src="jquery/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
              <script src="{{ asset('mdlfile/material.min.js') }}"></script>
                  <script>
            $(function() {
              $( "#datepicker" ).datepicker({
                  changeYear: true,
                  yearRange: '2010:2016',
                  changeMonth: true,
                  dateFormat: 'yy-mm-dd'
              });
            });

            $(function() {
              $( "#datepicker1" ).datepicker({
                  changeYear: true,
                  yearRange: '2010:2016',
                  changeMonth: true,
                  dateFormat: 'yy-mm-dd'
              });
            });

            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
        </script>   
    </body>
</html>