<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<link rel = "icon" href = "/storage/lecco_logo.ico">

    <title>
		<?php if(isset($page_title)): ?>
			<?php echo e($page_title . ' : '); ?>

		<?php endif; ?>
		<?php echo e(config('app.name', 'LECCO Lending System')); ?>

	</title>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
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
		
		@media  print {
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
    	<?php if(auth()->guard()->check()): ?>
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
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>" id="home_a">
                        <?php echo e(config('app.name', 'LECCO Lending System')); ?>

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
							<?php if(auth()->guard()->check()): ?>
								<li>
								<a class="navbar-brand" href="<?php echo e(route('home')); ?>">
									Home
								</a>
								</li>
							<?php endif; ?>
						</ul>
                        <?php if(auth()->guard()->guest()): ?>
                            <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                            <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
                        <?php else: ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    <?php echo e(Auth::user()->name); ?>

									<img class="img-rounded" src="/storage/avatars/<?php echo e(Auth::User()->avatar); ?>" style="min-height:25px;min-width:25px;max-width:25px;max-height:25px;"/>
									<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
										<a href="/profile">
                                        User Profile
										</a>
                                        <a href="<?php echo e(route('logout')); ?>"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php endif; ?>
		<div align="center" id="printOnly">
			<div style="display: -webkit-inline-box;">
			<img src="/storage/lecco_logo.jpg" style="max-width: 80px; max-height: 80px; margin-right: 20px">
			</div>
			<label>LEYECO II CREDIT COOPERATIVE<br>Tacloban City</label>
		</div>
		<?php echo $__env->yieldContent('content'); ?>
		<?php if(auth()->guard()->check()): ?>
			<div id ="side-menu" style="overflow-y:auto;display:inline-block;position:fixed;top:0;left:-170px;width:175px;height:100%;z-index:1000;background-color:rgba(225,225,225,0.8);" onmouseleave="hide()" onmouseenter="show()" onscroll="listenScroll()">
				<div class="no-print" style="float:left;margin-left:10px;width:150px;padding-bottom:15px;" onmouseenter="show()">
					
					<?php if(Auth::User()->access_rights()->users_view): ?>
						<h4>Users</h4>
						<?php if(Auth::User()->access_rights()->users_view): ?>
							<a href="<?php echo e(route('users.index')); ?>" class="link-tag view-a"> View Users </a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(Auth::User()->access_rights()->member_view or
						Auth::User()->access_rights()->member_create ): ?>
						<h4>Members</h4>
						<?php if(Auth::User()->access_rights()->member_view): ?>
							<a href="<?php echo e(route('members.index')); ?>" class="link-tag view-a"> View Members </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->member_create): ?>
							<a href="<?php echo e(route('members.create')); ?>" class="link-tag add-a"> Add Member </a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(Auth::User()->access_rights()->loans_view or
						Auth::User()->access_rights()->loans_create ): ?>
						<h4>Loans</h4>
						<?php if(Auth::User()->access_rights()->loans_view): ?>
							<a href="<?php echo e(route('loans.index')); ?>" class="link-tag view-a"> View Loans </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->loans_create): ?>
							<a href="<?php echo e(route('loans.create')); ?>" class="link-tag add-a"> Add Loan </a>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if(Auth::User()->access_rights()->loans_view or
						Auth::User()->access_rights()->loans_create ): ?>
						<h4>Loan Types</h4>
						<?php if(Auth::User()->access_rights()->loans_view): ?>
							<a href="<?php echo e(route('loan_types.index')); ?>" class="link-tag view-a"> View Loan Types </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->loans_create): ?>
							<a href="<?php echo e(route('loan_types.create')); ?>" class="link-tag add-a"> Add Loan Type </a>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if(Auth::User()->access_rights()->shares_view or
						Auth::User()->access_rights()->shares_create ): ?>
						<h4>Shares</h4>
						<?php if(Auth::User()->access_rights()->shares_view): ?>
							<a href="<?php echo e(route('shares.index')); ?>" class="link-tag view-a"> View Shares </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->shares_create): ?>
							<a href="<?php echo e(route('shares.create')); ?>" class="link-tag add-a">Add Shares</a>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if(Auth::User()->access_rights()->coa_view or
						Auth::User()->access_rights()->coa_create ): ?>
						<h4>Chart of Accounts</h4>
						<?php if(Auth::User()->access_rights()->coa_view): ?>
							<a href="<?php echo e(route('coa.index')); ?>" class="link-tag view-a"> View Chart </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->coa_create): ?>
							<a href="<?php echo e(route('coa.create')); ?>" class="link-tag add-a">Add Item</a>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if(Auth::User()->access_rights()->signatories_view or
						Auth::User()->access_rights()->signatories_create ): ?>
						<h4>Signatories</h4>
						<?php if(Auth::User()->access_rights()->signatories_view): ?>
							<a href="<?php echo e(route('signatories.index')); ?>" class="link-tag view-a"> View Signatories </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->signatories_create): ?>
							<a href="<?php echo e(route('signatories.create')); ?>" class="link-tag add-a">Add Signatory</a>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if(Auth::User()->access_rights()->check_voucher_view or
						Auth::User()->access_rights()->check_voucher_create ): ?>
						<h4>Check Vouchers</h4>
						<?php if(Auth::User()->access_rights()->check_voucher_view): ?>
							<a href="<?php echo e(route('check_voucher.index')); ?>" class="link-tag view-a"> View Check Voucher </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->check_voucher_create): ?>
							<a href="<?php echo e(route('check_voucher.create')); ?>" class="link-tag add-a">Add Check Voucher</a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Scripts -->
		<script src="<?php echo e(asset('js/app.js')); ?>"></script>
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
	<?php endif; ?>
</body>
</html>
