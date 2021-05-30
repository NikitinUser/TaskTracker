<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TaskTracker</title>

    <!-- Scripts -->

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">
     <a name="top"></a>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <a class="navbar-brand" href="{{ route('home') }}">TaskTracker</a>
            <div class="container">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('demo') }}">Без регистрации</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Вход') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('demo') }}">Без регистрации</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">TaskTracker</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ route('done') }}" class="nav-link" >Выплненное</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ route('archive') }}" class="nav-link" >Архив</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ route('bookmarks') }}" class="nav-link" >Закладки</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->login }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выход') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div id="returnMessages">
            @if( isset($errors) )
                @if( !empty($errors->all()))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <center>
                            {{ $errors->all()[0] }}
                        </center>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endif
            @if( Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <center>
                        {{ Session::get('success') }}
                    </center>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
       
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="page-footer mt-2 mb-3">
    @auth
        <center>
            <a href="#top" class="btn btn-outline-secondary btn-sm ">Наверх</a>
        </center>
    @endauth
    </footer>
    <script src="{{ mix('js/app.js') }}" ></script>
    <script src="{{ asset('js/Task.js') }}" ></script>
    <script src="{{ asset('js/main.js') }}" ></script>
</body>
</html>
