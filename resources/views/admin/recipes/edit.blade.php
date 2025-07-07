@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">{{ isset($recipe) ? 'Modifier' : 'Ajouter' }} une Recette</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($recipe) ? route('admin.recipes.update', $recipe) : route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($recipe))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Titre *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" 
                                   value="{{ old('title', $recipe->title ?? '') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Type *</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="Entrée" {{ old('type', $recipe->type ?? '') == 'Entrée' ? 'selected' : '' }}>Entrée</option>
                                <option value="Plat principal" {{ old('type', $recipe->type ?? '') == 'Plat principal' ? 'selected' : '' }}>Plat principal</option>
                                <option value="Dessert" {{ old('type', $recipe->type ?? '') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                                <option value="Boisson" {{ old('type', $recipe->type ?? '') == 'Boisson' ? 'selected' : '' }}>Boisson</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if(isset($recipe) && $recipe->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="Image actuelle" width="100" class="img-thumbnail">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                        <label class="form-check-label" for="remove_image">
                                            Supprimer l'image actuelle
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prep_time">Temps de préparation (minutes)</label>
                            <input type="number" class="form-control @error('prep_time') is-invalid @enderror" id="prep_time" name="prep_time" 
                                   value="{{ old('prep_time', $recipe->prep_time ?? '') }}">
                            @error('prep_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cook_time">Temps de cuisson (minutes)</label>
                            <input type="number" class="form-control @error('cook_time') is-invalid @enderror" id="cook_time" name="cook_time" 
                                   value="{{ old('cook_time', $recipe->cook_time ?? '') }}">
                            @error('cook_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="servings">Nombre de portions</label>
                            <input type="number" class="form-control @error('servings') is-invalid @enderror" id="servings" name="servings" 
                                   value="{{ old('servings', $recipe->servings ?? '') }}">
                            @error('servings')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $recipe->description ?? '') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instructions">Instructions *</label>
                    <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="6" required>{{ old('instructions', $recipe->instructions ?? '') }}</textarea>
                    @error('instructions')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Ingredients Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Ingrédients</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($ingredients as $ingredient)
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input ingredient-checkbox" 
                                           type="checkbox" 
                                           name="ingredients[{{ $ingredient->id }}][selected]"
                                           id="ingredient-{{ $ingredient->id }}"
                                           @if(isset($recipe) && $recipe->ingredients->contains($ingredient->id)) checked @endif>
                                    
                                    <label class="form-check-label" for="ingredient-{{ $ingredient->id }}">
                                        {{ $ingredient->name }} ({{ $ingredient->unit }})
                                    </label>
                                </div>
                                
                                <div class="input-group mt-2 quantity-group" 
                                     style="@if(!isset($recipe) || !$recipe->ingredients->contains($ingredient->id)) display:none; @endif">
                                    <span class="input-group-text">Quantité</span>
                                    <input type="number" 
                                           step="0.01" 
                                           class="form-control" 
                                           name="ingredients[{{ $ingredient->id }}][quantity]"
                                           value="{{ isset($recipe) ? $recipe->ingredients->find($ingredient->id)->pivot->quantity ?? 1 : 1 }}"
                                           min="0.1">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($recipe) ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                    <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Afficher/masquer le champ quantité quand la checkbox est cliquée
        $(document).on('change', '.ingredient-checkbox', function() {
            $(this).closest('.col-md-6').find('.quantity-group').toggle(this.checked);
        });
    });
</script>
@endsection