@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">{{ isset($user) ? 'Modifier' : 'Ajouter' }} un Utilisateur</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="name">Nom complet *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                           value="{{ old('name', $user->name ?? '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                           value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ isset($user) ? 'Nouveau mot de passe' : 'Mot de passe' }}</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if(isset($user))
                        <small class="text-muted">Laisser vide pour ne pas modifier</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

               

                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($user) ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection