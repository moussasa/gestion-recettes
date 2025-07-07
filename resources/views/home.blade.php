@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-2xl font-bold text-center text-indigo-700">Toutes nos recettes</h2>

<!-- Présentation du site -->
<div class="mb-5 text-center">
    <p class="text-muted lead">
        Bienvenue sur <strong>{{ $company?->name ?? 'notre plateforme culinaire' }}</strong> !
        Découvrez des centaines de recettes savoureuses, notées par la communauté.
    </p>
    <p class="text-muted small">
        Que vous soyez débutant ou chef expérimenté, explorez, cuisinez et partagez vos coups de cœur gourmands 🍲.
    </p>
</div>

<!-- Barre de recherche -->
<div class="mb-4">
    <form action="{{ route('recipes.index') }}" method="GET" class="d-flex gap-2">
        <input type="text"
               name="search"
               placeholder="Rechercher une recette..."
               value="{{ request()->query('search', '') }}"
               class="form-control rounded shadow-sm">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
</div>

<!-- Filtres par type -->
<div class="mb-4">
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('recipes.index') }}"
           class="btn btn-sm {{ !request('type') ? 'btn-indigo' : 'btn-light border' }}">
            Tous
        </a>
        @foreach(['Entrée', 'Plat principal', 'Dessert', 'Boisson'] as $type)
            <a href="{{ route('recipes.index', ['type' => $type]) }}"
               class="btn btn-sm {{ request('type') == $type ? 'btn-indigo' : 'btn-light border' }}">
                {{ $type }}
            </a>
        @endforeach
    </div>
</div>

<!-- Grille des recettes -->
<div class="row g-4">
    @forelse($recipes as $recipe)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 border-0 rounded-4 transition-transform hover:scale-105">
                @if($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="card-img-top object-cover" style="height: 9rem; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 9rem;">
                        <span class="text-muted small">Pas d’image</span>
                    </div>
                @endif

                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($recipe->description, 80) }}</p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">{{ $recipe->type }}</small>
                        <div class="d-flex align-items-center">
                            <svg class="text-warning me-1" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 
                                3.292a1 1 0 00.95.69h3.462c.969 0 
                                1.371 1.24.588 1.81l-2.8 
                                2.034a1 1 0 00-.364 1.118l1.07 
                                3.292c.3.921-.755 1.688-1.54 
                                1.118l-2.8-2.034a1 1 0 00-1.175 
                                0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 
                                1 0 00-.364-1.118L2.98 
                                8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 
                                1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-muted small">
                                {{ number_format($recipe->averageRating(), 1) }} ({{ $recipe->reviews->count() }})
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                        <button onclick="addToCart({{ $recipe->id }})" class="btn btn-sm btn-primary">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Aucune recette trouvée.</p>
        </div>
    @endforelse
</div>


<!-- Section entreprise -->
@if($company)
<div class="mt-5 py-5 bg-light rounded-4 px-4 px-md-5">

    {{-- Logo + nom --}}
    <div class="text-center mb-4">
        @if($company->logo)
            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo {{ $company->name }}"
                 class="mb-3" style="height: 60px;">
        @endif
        <h3 class="text-indigo-700">{{ $company->name }}</h3>
    </div>

    {{-- À propos --}}
    <p class="text-center text-muted mb-4 small">{{ $company->about }}</p>

    {{-- Infos détaillées --}}
    <div class="row text-sm">
        <div class="col-md-4 mb-3">
            <h6 class="text-muted">📍 Adresse</h6>
            <p>{{ $company->address }}</p>
        </div>
        <div class="col-md-4 mb-3">
            <h6 class="text-muted">📞 Contact</h6>
            <p>{{ $company->phone }}<br>{{ $company->email }}</p>
        </div>
        <div class="col-md-4 mb-3">
            <h6 class="text-muted">🕒 Horaires</h6>
            <p>Lundi - Vendredi : 9h - 18h<br>Samedi : 10h - 16h</p>
        </div>
    </div>
</div>
@endif


<!-- Modal d'ajout au panier -->
<div id="cartModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <h5 class="modal-title mb-3">Ajouter au panier</h5>
            <form id="addToCartForm" method="POST" action={{ route('recipes.add-to-cart') }}>

                @csrf
                 <div class="mb-3">
                    {{-- <label for="quantity" class="form-label">Id</label> --}}
                    <input type="hidden" id="addToCartFormRecetteId" name="addToCartFormRecetteId"  class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantité</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    function addToCart(recipeId) {
       // document.getElementById('addToCartForm').action = `/recipes/${recipeId}/add`;
        document.getElementById('addToCartFormRecetteId').value = recipeId;
        // alert(document.getElementById('addToCartFormRecetteId').value)
        let modal = new bootstrap.Modal(document.getElementById('cartModal'));
        modal.show();
    }
</script>
@endsection
