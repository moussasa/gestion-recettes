@extends('layouts.admin')

@section('header')
<div class="bg-primary text-white py-5 px-4">
    <div class="container">
        <h1 class="display-5 fw-bold">Tableau de bord</h1>
    </div>
</div>
@endsection

@section('content')
<div class="py-5">
    <div class="container">
        <!-- Cards -->
        <div class="row g-4 mb-5">
            <!-- Recettes -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                            <i class="bi bi-book fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Recettes</h6>
                            <h4 class="fw-bold">{{ App\Models\Recipe::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Utilisateurs -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Utilisateurs</h6>
                            <h4 class="fw-bold">{{ App\Models\User::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commandes -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3">
                            <i class="bi bi-cart fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Commandes</h6>
                            <h4 class="fw-bold">{{ App\Models\Order::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Avis -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-3 me-3">
                            <i class="bi bi-chat-dots fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Avis</h6>
                            <h4 class="fw-bold">{{ App\Models\Review::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Commandes récentes</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                    Voir tout <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(App\Models\Order::latest()->take(5)->get() as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $order->status == 'pending' ? 'warning' : 
                                    ($order->status == 'completed' ? 'success' : 'danger') 
                                }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-link text-decoration-none">
                                    <i class="bi bi-eye"></i> Détails
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune commande trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Avis récents -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Avis récents</h5>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-primary">
                    Voir tout <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="list-group list-group-flush">
                @forelse(App\Models\Review::with(['recipe', 'user'])->latest()->take(3)->get() as $review)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $review->author_name ?? $review->user->name }}</strong><br>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            <div class="mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : '' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('recipes.show', $review->recipe) }}" class="text-decoration-none text-primary">
                                {{ $review->recipe->title }}
                            </a>
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="mt-2 mb-0 text-muted">{{ Str::limit($review->comment, 100) }}</p>
                    @endif
                </div>
                @empty
                <div class="list-group-item text-center text-muted">Aucun avis trouvé</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
