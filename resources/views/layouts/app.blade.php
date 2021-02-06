<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    {{-- <script src="{{ asset('js/client.js') }}" defer></script> --}}
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container" id="navbar">
                <a class="navbar-brand badge-pill" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-item nav-link active badge-pill" href="{{ url('/') }}">@lang('lang.home')</a>
                        <a class="nav-item nav-link active badge-pill" href="/wishlist">@lang('lang.wishlist')</a>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle badge-pill" id="language" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                @lang('lang.lang')
                            </a>
                            <div class="dropdown-menu" aria-labelledby="language">
                                <a class="dropdown-item" href={{ url('lang/en') }}>English</a>
                                <a class="dropdown-item" href={{ url('lang/es') }}>Español</a>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <button class="btn btn-outline-light badge-pill my-2 my-sm-0" data-toggle="modal" data-target="#login">@lang('lang.login')</button>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link active badge-pill" href="{{ route('register') }}">@lang('lang.signup')</a>
                                </li>
                            @endif

                            @php
                                if (session('cart')) {
                                    $sum_qty = array_column(session('cart'), "quantity");
                                    $sum = (array_sum($sum_qty));
                                    echo "<span id='count' class='px-2 pt-2'>$sum</span>";
                                } else {
                                    echo "<span id='count' class='px-2 pt-2'>0</span>";
                                }
                            @endphp

                            <li>
                                <a href="/cart" class="nav-item nav-link active badge-pill"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        @lang('lang.logout')
                                    </a>

                                    <a class="dropdown-item" href="/account">
                                        @lang('lang.account')
                                    </a>

                                    <a class="dropdown-item" href="/checkout">
                                        @lang('lang.checkout')
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @php
                                if (session('cart')) {
                                    $sum_qty = array_column(session('cart'), "quantity");
                                    $sum = (array_sum($sum_qty));
                                    echo "<span id='count' class='px-2 pt-2'>$sum</span>";
                                } else {
                                    echo "<span id='count' class='px-2 pt-2'>0</span>";
                                }
                            @endphp

                            <li>
                                <a href="/cart" class="nav-item nav-link active badge-pill"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <main class="py-4">
            @yield('loginModal')
        </main>

        <section>
            @yield('comments')
        </section>

        <footer>
            @yield('footer')
        </footer>
    </div>
</body>
</html>
