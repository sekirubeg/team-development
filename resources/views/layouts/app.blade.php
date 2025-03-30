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

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('styles')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-black text-white shadow-sm">
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
                    <ul class="navbar-nav ms-auto">
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

                        {{-- <div class="profile-image">
                            <img src="{{ asset('storage/' . $user->image_at) }}" alt="プロフィール画像">
                        </div> --}}

                                    <li class="nav-item dropdown mb-0">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end bg-white" aria-labelledby="navbarDropdown">
                                    <a href="{{ url('/tasks') }}" class="block px-4 py-2 text-black bg-white transition duration-150 ease-in-out text-decoration-none">
                                        {{ __('トップページ') }}
                                    </a>

                                    <a href="#" class="block px-4 py-2 text-black bg-white transition duration-150 ease-in-out text-decoration-none">
                                        {{ __('新規タスク追加') }}
                                    </a>

                                    <a href="{{ route('my_page') }}" class="block px-4 py-2 text-black bg-white transition duration-150 ease-in-out text-decoration-none">
                                        {{ __('マイページ') }}
                                    </a>

                                    <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 text-black bg-white transition duration-150 ease-in-out text-decoration-none">
                                        {{ __('ログアウト') }}
                                    </a>
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
