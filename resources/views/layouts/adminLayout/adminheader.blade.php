<style>

.navbar-brand {

  font-size: 15px;

}

.logo-default{max-width: 175px; max-height: 50px; width: 100%; margin-top: -3px !important; min-height: 75px;}

.logo-default img{max-width: 100%; max-height: 100%; display: inline-block; float: none; margin-top: 15px}

</style>

<div class="page-header navbar navbar-fixed-top">

	<div class="page-header-inner">

		<div class="page-logo">

			<a href="{{url('/admin/dashboard')}}" class="navbar-brand logo-default" style=" margin-left: 5px;">
			Maxx Response
				<!-- <img src="{{asset('images/max-logo.png')}}"/> -->

			</a>

			<div class="menu-toggler sidebar-toggler">

			</div>

		</div>

		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">

		</a>

		<div class="page-top">

			<div class="top-menu">

				<ul class="nav navbar-nav pull-right">

					<li class="dropdown dropdown-user dropdown-dark">

						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

						<span class="username username-hide-on-mobile">

						{{ Session::get('adminSession')['username'] }} </span>

						<img alt="" class="img-circle" src="{{ asset('images/AdminImages/'.Session::get('adminSession')['image']) }}"/>

						</a>

						<ul class="dropdown-menu dropdown-menu-default">

							<li>

								<a href="{{ action('AdminController@profile') }}">

									<i class="icon-user"></i> My Profile 

								</a>

							</li>

							<li>

								<a href="{{ action('AdminController@logout') }}">

								<i class="icon-key"></i> Log Out </a>

							</li>

						</ul>

					</li>

				</ul>

			</div>

		</div>

	</div>

</div>