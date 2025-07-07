@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold text-center mb-6 text-indigo-700">{{ $recipe->title }}</h2>

    <div class="row g-4">
        <!-- Image + Infos -->
        <div class="col-md-6">
            @if($recipe->image)
                <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="img-fluid rounded mb-3" style="max-height: 250px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex justify-content-center align-items-center mb-3" style="height: 250px;">
                    <span class="text-muted">Pas d'image</span>
                </div>
            @endif

            <!-- Note et ajout panier -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <svg class="text-warning me-1" width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292..." />
                    </svg>
                    <span class="text-muted">{{ number_format($recipe->averageRating(), 1) }} ({{ $recipe->reviews->count() }} avis)</span>
                </div>
                <form action="{{ route('recipes.add-to-cart') }}" method="POST" class="d-flex">
                    @csrf
                    
                    <input type="hidden" id="addToCartFormRecetteId" name="addToCartFormRecetteId"  class="form-control" value="{{$recipe->id}}" required>

                    <input type="number" name="quantity" min="1" value="1" class="form-control form-control-sm w-auto me-2">
                    <button type="submit" class="btn btn-sm btn-primary">Ajouter</button>
                </form>
            </div>

            <!-- Infos recette -->
            <div class="d-flex justify-content-between text-center mb-4">
                <div>
                    <div class="small text-muted">Préparation</div>
                    <strong>{{ $recipe->prep_time }} min</strong>
                </div>
                <div>
                    <div class="small text-muted">Cuisson</div>
                    <strong>{{ $recipe->cook_time }} min</strong>
                </div>
                <div>
                    <div class="small text-muted">Portions</div>
                    <strong>{{ $recipe->servings }}</strong>
                </div>
            </div>

            <div>
                <h4 class="h6 mb-2">Description</h4>
                <p class="text-muted">{{ $recipe->description }}</p>
            </div>
        </div>

        <!-- Ingrédients & instructions -->
        <div class="col-md-6">
            <h4 class="h6 mb-3">Ingrédients</h4>
            <ul class="list-unstyled mb-5">
                @foreach($recipe->ingredients as $ingredient)
                    <li class="d-flex align-items-start mb-2">
                        <span class="me-2 text-indigo-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="..." clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>{{ $ingredient->pivot->quantity }} {{ $ingredient->unit }} de {{ $ingredient->name }}</span>
                    </li>
                @endforeach
            </ul>

            <h4 class="h6 mb-3">Instructions</h4>
            <div class="text-muted" style="white-space: pre-line;">{!! nl2br(e($recipe->instructions)) !!}</div>
        </div>
    </div>

    <!-- Avis -->
    <div class="mt-5 pt-4 border-top">
        <h4 class="h5 mb-4">Avis et commentaires</h4>

        <!-- Formulaire -->
        <div class="bg-light p-4 rounded mb-4">
            <h5 class="h6 mb-3">Laisser un avis</h5>
            <form action="{{ route('reviews.store', $recipe) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="author_name" class="form-control" required value="{{ auth()->user()?->name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Note</label>
                    <div class="d-flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" class="btn-check" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                            <label class="btn btn-outline-warning btn-sm" for="star{{ $i }}">{{ $i }}★</label>
                        @endfor
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Commentaire</label>
                    <textarea name="comment" rows="3" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>

        <!-- Liste des avis -->
        @forelse($reviews as $review)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong>{{ $review->author_name }}</strong>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                <div class="d-flex mb-1">
                    @for($i = 1; $i <= 5; $i++)
                        {{-- <svg class="w-4 h-4 me-1 {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="..." /> --}}
                        </svg>
                    @endfor
                </div>
                @if($review->comment)
                    <p class="text-muted">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <p class="text-muted">Aucun avis pour le moment.</p>
        @endforelse

        <!-- Pagination -->
        <div class="mt-3">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
