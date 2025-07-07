@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Commande #{{ $order->id }}</h1>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Détails de la commande</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Recette</th>
                                    <th>Quantité</th>
                                    {{-- <th>Prix unitaire</th> --}}
                                    {{-- <th>Total</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('recipes.show', $item->recipe) }}">
                                            {{ $item->recipe->title }}
                                        </a>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    {{-- <td>0 FCFA</td>
                                    <td>0 FCFA</td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>{{ $order->items->sum('quantity') }} recette(s)</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations client</h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $order->customer_name }}</h5>
                    <p class="card-text">
                        <strong>Téléphone:</strong> {{ $order->customer_phone }}<br>
                        @if($order->customer_email)
                            <strong>Email:</strong> {{ $order->customer_email }}<br>
                        @endif
                        <strong>Adresse:</strong> {{ $order->customer_address }}
                    </p>
                    <hr>
                    <strong>Statut:</strong>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Complétée</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations supplémentaires</h6>
                </div>
                <div class="card-body">
                    <p><strong>Date de commande:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    @if($order->notes)
                        <p><strong>Notes:</strong> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection