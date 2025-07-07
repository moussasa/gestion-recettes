@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">{{ isset($ingredient) ? 'Modifier' : 'Ajouter' }} un Ingrédient</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($ingredient) ? route('admin.ingredients.update', $ingredient) : route('admin.ingredients.store') }}" method="POST">
                @csrf
                @if(isset($ingredient))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="name">Nom *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                           value="{{ old('name', $ingredient->name ?? '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unit">Unité de mesure *</label>
                    <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" 
                           value="{{ old('unit', $ingredient->unit ?? '') }}" required>
                    <small class="text-muted">Ex: g, ml, cuillères à soupe, etc.</small>
                    @error('unit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($ingredient) ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                    <a href="{{ route('admin.ingredients.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection