@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Détails de la recette</h1>
                <div>
                    <a href="{{ route('admin.recipes.edit', $recipe) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $recipe->title }}</h6>
                </div>
                <div class="card-body">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="img-fluid mb-4 rounded">
                    @endif

                    <h5>Description</h5>
                    <p>{{ $recipe->description }}</p>

                    <h5 class="mt-4">Instructions</h5>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($recipe->instructions)) !!}
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Temps de préparation</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $recipe->prep_time ? $recipe->prep_time . ' min' : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Temps de cuisson</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $recipe->cook_time ? $recipe->cook_time . ' min' : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Portions</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $recipe->servings ?: 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ingrédients</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($recipe->ingredients as $ingredient)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $ingredient->name }}
                            <span class="badge badge-primary badge-pill">
                                {{ $ingredient->pivot->quantity }} {{ $ingredient->unit }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistiques</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Type:</strong> {{ $recipe->type }}
                    </div>
                    <div class="mb-3">
                        <strong>Note moyenne:</strong>
                        <div class="mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $recipe->averageRating() ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                            <small class="text-muted">({{ $recipe->reviews->count() }} avis)</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Date de création:</strong> {{ $recipe->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="mb-3">
                        <strong>Dernière modification:</strong> {{ $recipe->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Avis récents</h6>
                </div>
                <div class="card-body">
                    @forelse($recipe->reviews->take(3) as $review)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->author_name ?? $review->user->name }}</strong>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="mt-1 mb-0">{{ Str::limit($review->comment, 100) }}</p>
                        @endif
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    @empty
                    <p class="text-muted">Aucun avis pour cette recette</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection