<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel = "icon" href = "/storage/lecco_logo.jpg">
        <title>{{ config('app.name', 'LECCO Lending System') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body {
                background: linear-gradient(rgba(10,10,10,0.5), rgba(10,10,10,0.5)), url('/storage/leyeco.png');
                color: #636b6f;
                /*font-family: 'Raleway', sans-serif;*/
                font-family: arial black;
                margin: 0;
				position: relative;
				background-repeat: no-repeat;
				background-position: center;
				background-size: 110%;
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
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" style="font-size: 20px;font-weight: 100;color:white">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="font-size: 20px;font-weight: 100;color:white">Login</a>
                        <a href="{{ route('register') }}" style="font-size: 20px;font-weight: 100;color:white">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md" style="font-weight: 100;color:white">
                    {{ config('app.name', 'LECCO Lending System') }}
                </div>

                <div class="links">
                    <!--<a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>-->
                </div>
            </div>
        </div>
    </body>
</html>
