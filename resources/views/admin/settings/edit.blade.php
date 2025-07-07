@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">Paramètres de l'Entreprise</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nom de l'entreprise *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                   value="{{ old('name', $company->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                   value="{{ old('email', $company->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Téléphone *</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" 
                                   value="{{ old('phone', $company->phone) }}" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Adresse *</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $company->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control-file @error('logo') is-invalid @enderror" id="logo" name="logo">
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if($company->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo actuel" width="100" class="img-thumbnail">
                                    
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="about">À propos de l'entreprise *</label>
                    <textarea class="form-control @error('about') is-invalid @enderror" id="about" name="about" rows="5" required>{{ old('about', $company->about) }}</textarea>
                    @error('about')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection