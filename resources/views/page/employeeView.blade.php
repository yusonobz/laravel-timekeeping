@extends('master')
	

	@section('body')
	<div class="mdl-layout mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
			   <span class="mdl-layout-title">
				<!--<img class="android-logo-image" src="icon.png"> -->
				<span class="mdl-layout__title__haha">PurpleBug</span>

			  </span>
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
					  <li class="mdl-menu__item"><i class="fa fa-sign-out"></i><a href="{{ url('/logout') }}" style="text-decoration:none;" ><font color="black">Logout</font></a></li>
					</ul>

				 </nav>
			</div>
			
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
				  <a href="#fixed-tab-1" class="mdl-tabs__tab is-active">Starks</a>
				  <a href="#fixed-tab-2" class="mdl-tabs__tab">Lannisters</a>
				</div>
			</div>
		</header>
		
		<main class="mdl-layout__content">
			<section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
			  <div class="page-content"><!-- Your content goes here -->
				<h2>hfdhfhdjhfjhjfd</h2>
			  </div>
			</section>
			
			<section class="mdl-layout__tab-panel" id="fixed-tab-2">
			  <div class="page-content"><!-- Your content goes here -->
				<h2>hfdhfhdjhfjhhhffhdgjdfkkkjfd</h2>
			  </div>
			</section>
		</main>
	</div>
@endsection