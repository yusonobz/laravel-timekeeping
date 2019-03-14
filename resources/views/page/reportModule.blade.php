@extends('master')

	@section('body')
	<div class="demo-layout mdl-layout--fixed-header mdl-js-layout">
		<header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
			<!-- Title -->
			<span class="mdl-layout-title">
				<!--<img class="android-logo-image" src="icon.png"> -->
				<span class="mdl-layout__title__haha">PurpleBug</span>

			</span>
			<!-- Add spacer, to align navigation to the right -->
			<div class="mdl-layout-spacer"></div>
			<!-- Navigation -->
			<nav class="mdl-navigation">
				<!-- Right aligned menu below button -->
				<button id="demo-menu-lower-right"
					class="mdl-button mdl-js-button mdl-button--icon">
					<i class="material-icons">more_vert</i>
				</button>

				<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
					for="demo-menu-lower-right">
				<li class="mdl-menu__item"><i class="fa fa-sign-out"></i>Logout</li>
				</ul>

			</nav>
			</div>
		</header>
		<div class="mdl-layout__drawer">
			<div class="mdl-layout__drawer-button" style="padding-top: 0px;">
  				<i class="material-icons">menu</i>
  			</div>
			<span class="mdl-layout-title">
			<i class="fa fa-user fa-5x"></i>
			</span>
			<nav class="mdl-navigation">
				<a href="{{ url('/purpleBugTK') }}" class="mdl-navigation__link"><i class="material-icons md-dark md-36">home</i>Home</a>
				<a href="{{ url('/timeKeeping') }}" class="mdl-navigation__link"><i class="material-icons md-dark md-36 ">today</i>Timekeeping</a>
				<a href="{{ url('/recordM') }}" class="mdl-navigation__link"><i class="material-icons md-dark md-36">folder</i>Record Module</a>
				<a href="{{ url('/reportModule') }}" class="mdl-navigation__link"><i class="material-icons  md-dark md-36">insert_drive_file</i>Report Module</a>
				<a href="#" class="mdl-navigation__link"><i class="material-icons md-dark md-36">settings</i>Settings</a>
			</nav>
		</div>
	
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="intenthead"><strong>Summary Report</strong></h3>
					<h5 class="intentheadh2">Display the total time worked by each employee</h5>
					<h5 class="intentheadh2">Current week</h5>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="bs-example">
			<table class="table table-condensed" id="example" data-height="200"  data-toggle="table" data-pagination="true">
				<thead>
					<tr>
						<th>Name</th>
						<th>Mon</th>
						<th>Tue</th>
						<th>Wed</th>
						<th>Thu</th>
						<th>Fri</th>
						<th class="centerheader">Total hrs.</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Johanna Chua</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td  class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Johanna Chua</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td  class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Johanna Chua</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td  class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Lyzel Ventura</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Mimi Dipol</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Thea Bunyi</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Thea Bunyi</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Aubs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td>Kenneth</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td class="centerheader">40 hrs.</td>
					</tr>
					<tr>
						<td class="clickable-row">Gerlie Mae</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td>8hrs</td>
						<td class="centerheader">40 hrs.</td>
					</tr>
				</tbody>
			</table>
		</div>
				</div>
			</div>
		</div>
	</div>
@endsection