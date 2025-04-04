<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('styles')

    <style>
        .profile-icon-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.5em;
            vertical-align: middle;
        }

        .navbar .nav-link.dropdown-toggle {
            font-size: 16px;
            font-family: 'Nunito', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
        }

        /* h5, h6{
            font-family: 'Nunito', sans-serif;

            font-size: 15px;
        } */


        .navbar .navbar-brand,
        .navbar .nav-link,
        .navbar .dropdown-menu a {
            font-family: 'Nunito', sans-serif;
            font-size: 16px;
        }

    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md text-white shadow-sm" style="background-color: #f4cc70; ">
            <div class="container" >
                <a class="navbar-brand text-white" href="{{ url('/tasks') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto" >
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                        <a class="nav-link text-white" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                                </li>
                            @endif
                        @else

                        <li class="nav-item dropdown mb-0">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('storage/' . Auth::user()->image_at) }}" alt="プロフィール画像" class="profile-icon-small" style="margin-right: 15px;">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end bg-white" aria-labelledby="navbarDropdown">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <a href="{{ url('/tasks') }}" class="d-block px-4 py-2 text-black text-decoration-none">
                                                {{ __('トップページ') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/task/create') }}" class="d-block px-4 py-2 text-black text-decoration-none">
                                                {{ __('新規タスク追加') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('my_page') }}" class="d-block px-4 py-2 text-black text-decoration-none">
                                                {{ __('マイページ') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="d-block px-4 py-2 text-black text-decoration-none">
                                                {{ __('ログアウト') }}
                                            </a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
