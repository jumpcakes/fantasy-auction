<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>
        
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet" type="text/css">
        <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    </head>
    <body>
        <div id="app" class="full-height">
            <div class="main-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="/images/main-logo.png">
                        </div>
                        <div class="col-md-6">
                            <h1>Fantasy Football Auction</h1>
                        </div>
                        <div class="col-md-4">
                            @if (Route::has('login'))
                                <div class="top-right links">
                                    @auth
                                        <a href="{{ url('/home') }}">Your Are Logged In As<br> {{Auth::user()->name}} - {{Auth::user()->team_name}}</a>
                                    @else
                                        <a href="{{ route('login') }}">Login</a>
                                        <a href="{{ route('register') }}">Register</a>
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="admin-menu">
                @if(Auth::user()) 
                    @if(Auth::user()->id ===1)
                        <button @click="startDraft" class="btn btn-primary">Prompt Next Pick</button>
                    @endif
                @endif
            </div>
            @yield('content')
            <footer>
                &copy; SportsCarnival
            </footer>
        </div>
        <script type="text/javascript" src="/js/app.js"></script>
        @yield('footer')
        
    </body>
</html>