@extends('layouts.app')

@section('content')
    <div class="container py-5 animate__animated animate__fadeIn">
        <div class="text-center mb-5">
            <svg class="mx-auto mb-3" width="50" height="50" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="text-success">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <h2 class="fw-bold text-success">Commande confirmée !</h2>
            <p class="text-muted">Votre commande #{{ $order->id }} a été enregistrée avec succès.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="bg-light p-4 rounded shadow animate__animated animate__fadeInUp">
                    <h4 class="fw-semibold mb-4">Récapitulatif de la commande</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="text-muted">Nom :</span>
                            <span>{{ $order->customer_name }}</span>
                        </li>
                        @if ($order->customer_email)
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Email :</span>
                                <span>{{ $order->customer_email }}</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="text-muted">Téléphone :</span>
                            <span>{{ $order->customer_phone }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="text-muted">Adresse :</span>
                            <span>{{ $order->customer_address }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="text-muted">Nombre de recettes :</span>
                            <span>{{ $order->items->count() }}</span>
                        </li>
                        
                        <br>
                        <hr>
                        <span >Les recettes :</span>
                        
                        @forelse ($order->items as $orders)
                        <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">{{ $orders->recipe->title}} :</span>
                                <span>{{ $orders->quantity }}</span>
                            </li>
                            @empty
                            <li class="list-group-item d-flex justify-content-between">

                                <span class="text-muted">Aucune recettes</span>
                        </li>
                            @endforelse

                    </ul>

                    <div class="mt-4 text-center">
                        <a href="{{ route('recipes.index') }}" class="btn btn-primary shadow-sm">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @extends('layouts.app')

@section('header')
    <h2>
        Confirmation de commande
    </h2>
@section('content')


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>

                    <h3 class="mt-2 text-lg font-medium text-gray-900">Commande confirmée!</h3>
                    <p class="mt-1 text-gray-600">Votre commande #{{ $order->id }} a été enregistrée avec succès.</p>

                    <div class="mt-6 bg-gray-50 p-6 rounded-lg text-left max-w-md mx-auto">
                        <h4 class="font-medium mb-4">Récapitulatif de la commande</h4>

                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nom:</span>
                                <span>{{ $order->customer_name }}</span>
                            </div>
                            @if ($order->customer_email)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span>{{ $order->customer_email }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Téléphone:</span>
                                <span>{{ $order->customer_phone }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Adresse:</span>
                                <span>{{ $order->customer_address }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nombre de recettes:</span>
                                <span>{{ $order->items->sum('quantity') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Statut:</span>
                                <span class="capitalize">{{ $order->status }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('recipes.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
