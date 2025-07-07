@extends('layouts.app')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <h2 class="text-2xl font-bold text-center mb-8">Finaliser votre commande</h2>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white shadow rounded p-4">
                <div class="row g-4">
                    <!-- Customer Information -->
                    <div class="col-md-8">
                        <h4 class="mb-4 fw-semibold">Informations client</h4>
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="customer_name" class="form-label">Nom complet *</label>
                                    <input type="text" name="customer_name" id="customer_name" required class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label for="customer_email" class="form-label">Email</label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label for="customer_phone" class="form-label">Téléphone *</label>
                                    <input type="text" name="customer_phone" id="customer_phone" required class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="customer_address" class="form-label">Adresse *</label>
                                    <textarea name="customer_address" id="customer_address" rows="3" required class="form-control"></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="notes" class="form-label">Notes supplémentaires</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Retour au panier</a>
                                <button type="submit" class="btn btn-primary ms-3">Valider la commande</button>
                            </div>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-md-4">
                        <div class="bg-light p-4 rounded">
                            <h5 class="fw-bold mb-3">Votre commande</h5>
                            <ul class="list-unstyled mb-4">
                                @foreach($cart->items as $item)
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">{{ $item->recipe->title }}</span>
                                        <span class="text-muted">x{{ $item->quantity }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">Total</span>
                                    <span class="fw-semibold">{{ $cart->totalItems() }} recette(s)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- @extends('layouts.app')

@section('content')
   Finaliser votre commande
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Customer Information -->
                        <div class="md:w-2/3">
                            <h3 class="text-lg font-medium mb-6">Informations client</h3>
                            
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="customer_name" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                                        <input type="text" name="customer_name" id="customer_name" required
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    
                                    <div class="sm:col-span-3">
                                        <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="customer_email" id="customer_email"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    
                                    <div class="sm:col-span-3">
                                        <label for="customer_phone" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                                        <input type="text" name="customer_phone" id="customer_phone" required
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    
                                    <div class="sm:col-span-6">
                                        <label for="customer_address" class="block text-sm font-medium text-gray-700">Adresse *</label>
                                        <textarea id="customer_address" name="customer_address" rows="3" required
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    
                                    <div class="sm:col-span-6">
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes supplémentaires</label>
                                        <textarea id="notes" name="notes" rows="3"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                                
                                <div class="mt-8 border-t border-gray-200 pt-5">
                                    <div class="flex justify-end">
                                        <a href="{{ route('cart.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Retour au panier
                                        </a>
                                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Valider la commande
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="md:w-1/3">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Votre commande</h3>
                                
                                <div class="space-y-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        @foreach($cart->items as $item)
                                            <div class="flex justify-between py-2">
                                                <div class="flex items-center">
                                                    <span class="text-gray-600">{{ $item->recipe->title }}</span>
                                                    <span class="ml-1 text-gray-500">x{{ $item->quantity }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between">
                                            <span class="text-base font-medium">Total</span>
                                            <span class="text-base font-medium">{{ $cart->totalItems() }} recette(s)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@endsection --}}