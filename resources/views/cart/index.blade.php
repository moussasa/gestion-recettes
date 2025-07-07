@extends('layouts.app')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <h2 class="text-2xl font-bold text-center mb-8">Votre panier</h2>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white shadow rounded p-4">
                @if($cart->items->isEmpty())
                    <div class="text-center py-5">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">Votre panier est vide</h3>
                        <p class="text-gray-500">Commencez par ajouter quelques recettes à votre panier.</p>
                        <div class="mt-4">
                            <a href="{{ route('recipes.index') }}" class="btn btn-primary">
                                Voir les recettes
                            </a>
                        </div>
                    </div>
                @else
                    <div class="row g-4">
                        <!-- Cart Items -->
                        <div class="col-md-8">
                            <h4 class="mb-4 fw-semibold">Vos recettes sélectionnées</h4>

                            @foreach($cart->items as $item)
                                <div class="d-flex align-items-center border-bottom py-3">
                                    <div class="flex-shrink-0">
                                        @if($item->recipe->image)
                                            <img src="{{ asset('storage/' . $item->recipe->image) }}" alt="{{ $item->recipe->title }}" class="rounded object-fit-cover" width="80" height="80">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <small class="text-muted">Pas d'image</small>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ $item->recipe->title }}</h6>
                                            <span class="text-muted">{{ $item->quantity }} x</span>
                                        </div>
                                        <small class="text-muted">{{ $item->recipe->type }}</small>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Mettre à jour</button>
                                            </form>
                                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h5 class="fw-bold mb-3">Récapitulatif</h5>
                                <ul class="list-unstyled mb-4">
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Nombre de recettes</span>
                                        <span>{{ $cart->items->count() }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total des quantités</span>
                                        <span>{{ $cart->totalItems() }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-top pt-3">
                                        <span class="fw-semibold">Total</span>
                                        <span class="fw-semibold">{{ $cart->totalItems() }} recette(s)</span>
                                    </li>
                                </ul>

                                <a href="{{ route('cart.checkout') }}" class="btn btn-success w-100 mb-2">
                                    Passer la commande
                                </a>
                                <div class="text-center">
                                    <a href="{{ route('recipes.index') }}" class="text-decoration-none text-primary">
                                        Continuer vos achats
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
