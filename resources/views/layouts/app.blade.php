<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts (Nunito) -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


</head>

<body style="background-color: #f8fafc;">
    <nav class="navbar navbar-expand-lg navbar-light  bg-primary border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recipes.index') ? 'active' : '' }}"
                            href="{{ route('recipes.index') }}">Recettes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">À propos</a>
                    </li>
                    <!-- Panier -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            🛒
                            @auth
                                @if (auth()->user()->cart)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ auth()->user()->cart->totalItems() }}
                                    </span>
                                @endif
                            @else
                                @if (session('cart_session_id'))
                                    @php
                                        $cart = \App\Models\Cart::where(
                                            'session_id',
                                            session('cart_session_id'),
                                        )->first();
                                    @endphp
                                    @if ($cart)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $cart->totalItems() }}
                                        </span>
                                    @endif
                                @endif
                            @endauth
                        </a>
                    </li>
                </ul>

                <!-- Right -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                        {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                            </li>
                        @endif --}}
                    @endauth


                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-white shadow-sm mb-4">
        <div class="container py-4">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                <br>
            @endif
            @yield('header') {{-- Utilise @section('header') dans tes vues --}}
        </div>
    </header>

    <!-- Main content -->
    <main class="container pb-5">
        @yield('content') {{-- Utilise @section('content') dans tes vues --}}
    </main>

    <!-- Bootstrap JS (via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Scripts compilés -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Footer -->
    <footer class="bg-white border-top shadow-sm mt-5">
        <div class="container py-4">
            <div class="row">
                <!-- Colonne 1 : logo et nom -->
                <div class="col-md-4 mb-3 text-center text-md-start">
                    <h5 class="text-indigo-700">{{ config('app.name', 'Laravel') }}</h5>
                    <p class="small text-muted">Partagez, cuisinez, régalez-vous ! Explorez nos meilleures recettes
                        maison.</p>
                </div>

                <!-- Colonne 2 : navigation -->
                <div class="col-md-4 mb-3 text-center">
                    <h6 class="text-muted">Navigation</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('home') }}" class="text-decoration-none text-muted">Accueil</a></li>
                        <li><a href="{{ route('recipes.index') }}" class="text-decoration-none text-muted">Recettes</a>
                        </li>
                        <li><a href="{{ route('about') }}" class="text-decoration-none text-muted">À propos</a></li>
                        @auth
                            <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Tableau de
                                    bord</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Colonne 3 : contact -->
                <div class="col-md-4 mb-3 text-center text-md-end">
                    <h6 class="text-muted">Contact</h6>
                    @php
                        $company = \App\Models\CompanySetting::first();
                    @endphp
                    @if ($company)
                        <p class="small text-muted mb-1">{{ $company->address }}</p>
                        <p class="small text-muted mb-1">{{ $company->phone }}</p>
                        <p class="small text-muted">{{ $company->email }}</p>
                    @else
                        <p class="small text-muted">Entreprise non renseignée.</p>
                    @endif
                </div>
            </div>

            <hr class="my-3">

            <div class="text-center small text-muted">
                &copy; {{ now()->year }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.
            </div>
        </div>
    </footer>

</body>

</html>
