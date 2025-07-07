@extends('layouts.app')

@section('header')
    <h1>À propos de nous</h1>
@endsection

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="card mb-5">
        <div class="row g-0 align-items-center">
            @if($company?->logo)
            <div class="col-md-4 text-center">
                <img src="{{ asset('storage/' . $company?->logo) }}" class="img-fluid p-4" alt="Logo {{ $company?->name }}">
            </div>
            @endif
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title fw-bold">{{ $company?->name }}</h2>
                    <p class="card-text">{{ $company?->about }}</p>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="bi bi-book-fill text-primary me-2"></i>Plus de {{ App\Models\Recipe::count() }} recettes</li>
                        <li><i class="bi bi-people-fill text-primary me-2"></i>Une communauté de passionnés</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Notre Histoire -->
    <div class="card mb-5">
        <div class="card-body">
            <h2 class="fw-bold mb-4">Notre histoire</h2>
            <p>Notre aventure a commencé en 2010 avec une simple passion pour la cuisine et le partage...</p>
            <p>Aujourd'hui, notre plateforme rassemble des milliers de recettes testées et approuvées par notre communauté...</p>
            <p>Notre mission est d'inspirer, d'éduquer et de créer des liens à travers la cuisine...</p>
        </div>
    </div>

    <!-- Notre Équipe -->
    <div class="card mb-5">
        <div class="card-body">
            <h2 class="fw-bold mb-4">Notre équipe</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col text-center">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="rounded-circle img-fluid mb-3" style="height: 150px; width: 150px; object-fit: cover;">
                    <h5>Marie Dupont</h5>
                    <p class="text-primary">Chef cuisinière</p>
                    <small class="text-muted">15 ans d'expérience en gastronomie française</small>
                </div>
                <div class="col text-center">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="rounded-circle img-fluid mb-3" style="height: 150px; width: 150px; object-fit: cover;">
                    <h5>Jean Martin</h5>
                    <p class="text-primary">Expert en pâtisserie</p>
                    <small class="text-muted">Spécialiste des desserts et viennoiseries</small>
                </div>
                <div class="col text-center">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="rounded-circle img-fluid mb-3" style="height: 150px; width: 150px; object-fit: cover;">
                    <h5>Sophie Leroy</h5>
                    <p class="text-primary">Nutritionniste</p>
                    <small class="text-muted">Recettes équilibrées et adaptées à tous</small>
                </div>
                <div class="col text-center">
                    <img src="https://images.unsplash.com/photo-1562788869-4ed32648eb72?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="rounded-circle img-fluid mb-3" style="height: 150px; width: 150px; object-fit: cover;">
                    <h5>Thomas Moreau</h5>
                    <p class="text-primary">Développeur web</p>
                    <small class="text-muted">Crée l'expérience utilisateur idéale</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Nos Valeurs -->
    <div class="card mb-5">
        <div class="card-body">
            <h2 class="fw-bold mb-4">Nos valeurs</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded">
                        <h5 class="fw-bold">Qualité</h5>
                        <p>Chaque recette est testée et approuvée avant publication.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded">
                        <h5 class="fw-bold">Authenticité</h5>
                        <p>Nous valorisons les recettes traditionnelles tout en innovant.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded">
                        <h5 class="fw-bold">Partage</h5>
                        <p>Nous croyons au pouvoir rassembleur de la cuisine.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div class="card">
        <div class="card-body">
            <h2 class="fw-bold mb-4">Nous contacter</h2>
            <div class="row g-5">
                <div class="col-md-6">
                    <h5 class="fw-bold">Coordonnées</h5>
                    <p><i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ $company?->address }}</p>
                    <p><i class="bi bi-telephone-fill text-primary me-2"></i>{{ $company?->phone }}</p>
                    <p><i class="bi bi-envelope-fill text-primary me-2"></i>{{ $company?->email }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold">Horaires</h5>
                    <ul class="list-unstyled">
                        <li class="d-flex justify-content-between"><span>Lundi - Vendredi</span><span>9h - 18h</span></li>
                        <li class="d-flex justify-content-between"><span>Samedi</span><span>10h - 16h</span></li>
                        <li class="d-flex justify-content-between"><span>Dimanche</span><span>Fermé</span></li>
                    </ul>
                    <div class="mt-4">
                        <h6>Suivez-nous</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-primary"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-facebook"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
