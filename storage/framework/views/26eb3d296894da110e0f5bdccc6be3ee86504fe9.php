<?php if(Route::has('login')): ?>
    <div class="top-left links">
        <a href="<?php echo e(url('/')); ?>" style="font-size: 20px;font-weight: 100;color:white;">LECCO Lending System</a>    
    </div>
    <div class="top-right links">
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(url('/home')); ?>" style="font-size: 20px;font-weight: 100;color:white">Home</a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" style="font-size: 20px;font-weight: 100;color:white">Login</a>
            <a href="<?php echo e(route('register')); ?>" style="font-size: 20px;font-weight: 100;color:white">Register</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<style>
    body {
        background: linear-gradient(rgba(10,10,10,0.5), rgba(10,10,10,0.5)), url('/storage/leyeco.png');
		color: #636b6f;
		margin: 0;
		position: relative;
		background-repeat: no-repeat;
		background-position: center;
		background-size: 110%;     
    }

    html {
        margin-bottom: 0;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        font-family: sans-serif; 
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .panel, .panel-default {
        background: rgba(250,250,250,0.8);
    }

    .panel-default>.panel-heading {
        background: rgba(250,250,250,0.4);
    }
</style>