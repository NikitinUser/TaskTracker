<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TaskTracker</title>

    <script type="text/javascript" src="{{ asset('js/localization.js') }}" ></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.7.0-cut/css/font-awesome.min.css') }}">
</head>
<body>
    <div id="main-app">
        <nav class="navbar navbar-dark bg-dark shadow-sm p-3">
          <!-- Right Side Of Navbar -->
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a class="nav-link without_registration_nav @if(Request::is('demo')) active @endif" href="{{ route('demo') }}">Без регистрации</a>
                </li>
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link login_nav @if(Request::is('login')) active @endif" href="{{ route('login') }}">Вход</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link registration_nav @if(Request::is('register')) active @endif" href="{{ route('register') }}">Регистрация</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link @if(Request::is('home') || Request::is('/')) active @endif" href="{{ route('home') }}">
                            TaskTracker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link done_tasks_nav @if(Request::is('done')) active @endif" href="{{ route('done') }}">
                            Выполненное
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link archive_tasks_nav @if(Request::is('archive')) active @endif" href="{{ route('archive') }}">
                            Архив
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bookmark_tasks_nav @if(Request::is('bookmarks')) active @endif" href="{{ route('bookmarks') }}">
                            Закладки
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="button">
                            {{ Auth::user()->login }} <span class="caret"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout_nav" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Выход
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">@csrf</form>
                    </li>
                    @role('admin')
                        @include('user-management-module::sidebar')
                    @endrole
                @endguest
                <li class="nav-item">
                    <select class="nav-link" id="localization_language"
                        onchange="changeLocalization(this.value)">
                        <option value="ru">RU</option>
                        <option value="en">EN</option>
                    </select>    
                </li>
            </ul>
        </nav>
       
        <main class="py-4 bg-dark-theme">
            @yield('content')
        </main>
    </div>
</body>
</html>
