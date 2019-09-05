<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel = "icon" href = "/storage/lecco_logo.ico">

    <title>
		@if(isset($page_title))
			{{ $page_title . ' : ' }}
		@endif
		{{ config('app.name', 'LECCO Lending System') }}
	</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<style>
		.img-rounded {
			border-radius: 50%;
			width: auto;
			height: 100%;
			min-width:100px;
			min-height:100px;
			max-width:300px;
			max-height:300px;
		}

		.justify-content-center {
			margin: auto;
			width: 50%;
			padding: 10px;
		}

		#side-menu a {
			display: block;
		}

		#side-menu::-webkit-scrollbar-track {
			background: rgba(225,225,225,0.8);
		}

		#side-menu::-webkit-scrollbar-thumb:hover {
			background: #888; 
			visibility: visible;
		}

		#side-menu::-webkit-scrollbar-thumb:active {
			background: #555;
			visibility: visible;
		}

		.hide-scrollbar::-webkit-scrollbar-thumb {
			background: #f1f1f1; 
			visibility: hidden;
		}

		.show-scrollbar::-webkit-scrollbar-thumb {
			background: #888;
			visibility: visible;
		}
		
		#printOnly {
			display:none;
		}
		
		@media print {
		  .no-print {
			display: none;
		  }
		  .no-break {
			page-break-inside: avoid;
			font-size: 10px;
			padding: 0;
		  }
		  #printOnly {
			  display: block;
		  }
		  
		  .format-print {
			display:none;
			border:0;
		  }
		}
	</style>
</head>
<body>
    <div id="app">
    	@auth
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" id="home_a">
                        {{ config('app.name', 'LECCO Lending System') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
						<ul class="nav navbar-nav">
							@auth
								<li>
								<a class="navbar-brand" href="{{ route('home') }}">
									Home
								</a>
								</li>
							@endauth
						</ul>
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }}
									<img class="img-rounded" src="/storage/avatars/{{ Auth::User()->avatar }}" style="min-height:25px;min-width:25px;max-width:25px;max-height:25px;"/>
									<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
										<a href="/profile">
                                        User Profile
										</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endauth
		<div align="center" id="printOnly">
			<div style="display: -webkit-inline-box;">
			<img src="/storage/lecco_logo.jpg" style="max-width: 80px; max-height: 80px; margin-right: 20px">
			</div>
			<label>LEYECO II CREDIT COOPERATIVE<br>Tacloban City</label>
		</div>
		@yield('content')
		@auth
			<div id ="side-menu" style="overflow-y:auto;display:inline-block;position:fixed;top:0;left:-170px;width:175px;height:100%;z-index:1000;background-color:rgba(225,225,225,0.8);" onmouseleave="hide()" onmouseenter="show()" onscroll="listenScroll()">
				<div class="no-print" style="float:left;margin-left:10px;width:150px;padding-bottom:15px;" onmouseenter="show()">
					
					@if(Auth::User()->access_rights()->users_view)
						<h4>Users</h4>
						@if(Auth::User()->access_rights()->users_view)
							<a href="{{ route('users.index') }}" class="link-tag view-a"> View Users </a>
						@endif
					@endif
					@if(Auth::User()->access_rights()->member_view or
						Auth::User()->access_rights()->member_create )
						<h4>Members</h4>
						@if(Auth::User()->access_rights()->member_view)
							<a href="{{ route('members.index') }}" class="link-tag view-a"> View Members </a>
						@endif
						@if(Auth::User()->access_rights()->member_create)
							<a href="{{ route('members.create') }}" class="link-tag add-a"> Add Member </a>
						@endif
					@endif
					@if(Auth::User()->access_rights()->loans_view or
						Auth::User()->access_rights()->loans_create )
						<h4>Loans</h4>
						@if(Auth::User()->access_rights()->loans_view)
							<a href="{{ route('loans.index') }}" class="link-tag view-a"> View Loans </a>
						@endif
						@if(Auth::User()->access_rights()->loans_create)
							<a href="{{ route('loans.create') }}" class="link-tag add-a"> Add Loan </a>
						@endif
					@endif
					
					@if(Auth::User()->access_rights()->loans_view or
						Auth::User()->access_rights()->loans_create )
						<h4>Loan Types</h4>
						@if(Auth::User()->access_rights()->loans_view)
							<a href="{{ route('loan_types.index') }}" class="link-tag view-a"> View Loan Types </a>
						@endif
						@if(Auth::User()->access_rights()->loans_create)
							<a href="{{ route('loan_types.create') }}" class="link-tag add-a"> Add Loan Type </a>
						@endif
					@endif
					
					@if(Auth::User()->access_rights()->shares_view or
						Auth::User()->access_rights()->shares_create )
						<h4>Shares</h4>
						@if(Auth::User()->access_rights()->shares_view)
							<a href="{{ route('shares.index') }}" class="link-tag view-a"> View Shares </a>
						@endif
						@if(Auth::User()->access_rights()->shares_create)
							<a href="{{ route('shares.create') }}" class="link-tag add-a">Add Shares</a>
						@endif
					@endif
					
					@if(Auth::User()->access_rights()->coa_view or
						Auth::User()->access_rights()->coa_create )
						<h4>Chart of Accounts</h4>
						@if(Auth::User()->access_rights()->coa_view)
							<a href="{{ route('coa.index') }}" class="link-tag view-a"> View Chart </a>
						@endif
						@if(Auth::User()->access_rights()->coa_create)
							<a href="{{ route('coa.create') }}" class="link-tag add-a">Add Item</a>
						@endif
					@endif
					
					@if(Auth::User()->access_rights()->signatories_view or
						Auth::User()->access_rights()->signatories_create )
						<h4>Signatories</h4>
						@if(Auth::User()->access_rights()->signatories_view)
							<a href="{{ route('signatories.index') }}" class="link-tag view-a"> View Signatories </a>
						@endif
						@if(Auth::User()->access_rights()->signatories_create)
							<a href="{{ route('signatories.create') }}" class="link-tag add-a">Add Signatory</a>
						@endif
					@endif
					
					@if(Auth::User()->access_rights()->check_voucher_view or
						Auth::User()->access_rights()->check_voucher_create )
						<h4>Check Vouchers</h4>
						@if(Auth::User()->access_rights()->check_voucher_view)
							<a href="{{ route('check_voucher.index') }}" class="link-tag view-a"> View Check Voucher </a>
						@endif
						@if(Auth::User()->access_rights()->check_voucher_create)
							<a href="{{ route('check_voucher.create') }}" class="link-tag add-a">Add Check Voucher</a>
						@endif
					@endif
				</div>
			</div>
		</div>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}"></script>
		<script>
			var animating = false;
			var side_menu = document.getElementById('side-menu');
			// var home_a = document.getElementById('home_a');

			function show(){
				if(animating){
					return;
				}
				animating = true;
				var id = setInterval(frame, 10);
				var left = Number(side_menu.style.left.substr(0,side_menu.style.left.length-2));

				function frame() {
					if (left > 0) {
						clearInterval(id);
						animating = false;
						
					} else {
						side_menu.style.left = left+'px';
						left += 5;
					}
				}
			}
			
			function hide(){
				if(animating){
					return;
				}
				animating = true;
				var id = setInterval(frame, 10);
				var left = Number(side_menu.style.left.substr(0,side_menu.style.left.length-2));
				var width = Number(side_menu.style.width.substr(0,side_menu.style.width.length-2));

				function frame() {
					if (left <= 0-width) {
						clearInterval(id);
						animating = false;
					} else {
						side_menu.style.left = left+'px';
						left -= 5;
					}
				}
			}

			function listenScroll() {		
	   	   	    $('#side-menu').removeClass('hide-scrollbar');
	   	   	    $('#side-menu').addClass('show-scrollbar');

	   	   	    var id = setInterval(frame, 10);
	   	   	    function frame() {
					clearInterval(id);
					$('#side-menu').removeClass('show-scrollbar');
	   	   	    	$('#side-menu').addClass('hide-scrollbar');
				}
			}
		</script>
	@endauth
</body>
</html>
