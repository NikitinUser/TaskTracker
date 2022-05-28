<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="32x32" href="/task-tracker.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TaskTracker</title>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('bootstrap/js/bootstrap.min.js') }}" ></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}">
</head>
<body>
    <div id="app">
        <a name="top"></a>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm p-3">
            <a class="navbar-brand" href="{{ route('home') }}">TaskTracker</a>
            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="nav nav-pills ml-auto">
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
                                <a class="nav-link @if(Request::is('home')) active @endif" href="{{ route('home') }}">
                                    TaskTracker
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Request::is('done')) active @endif" href="{{ route('done') }}">
                                    Выплненное
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Request::is('archive')) active @endif" href="{{ route('archive') }}">
                                    Архив
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Request::is('bookmarks')) active @endif" href="{{ route('bookmarks') }}">
                                    Закладки
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Request::is('statistic')) active @endif" href="{{ route('statistic') }}">
                                    Статистика
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" role="button">
                                    {{ Auth::user()->login }} <span class="caret"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Выход') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @role('admin')
        <div id="AdminSideBar">
            <div style="float: left; height: 200vh !important;  min-height: 100vh !important; width: 15%;" class="bg-dark" id="sideBarMain"> </div>

            <div style="float: left; height: 100vh !important;   min-height: 100vh !important; width: 15%; position:fixed;" >
                @include('layouts.side_bar')
            </div>
        </div>
        @endrole


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
       
        <main class="py-4 bg-dark-theme">
            @yield('content')
        </main>
    </div>
    
    <!-- Modal -->
    <div class="modal" id="modalWaitingServer" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Загрузка</h5>
          </div>
          <div class="modal-body">
            <center>
                <div class="spinner-border text-warning" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
            </center>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.4/mobile-detect.min.js"></script>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            const pageHeight = document.documentElement.scrollHeight;
            document.querySelector('#sideBarMain').style.height = (pageHeight + 100) + "px";
          });
    </script>
</body>
</html>
