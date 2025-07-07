@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">Gestion des Commandes</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Recettes</th>
                            <th>Total</th>
                            {{-- <th>Statut</th> --}}
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                {{ $order->customer_name }}<br>
                                <small class="text-muted">{{ $order->customer_phone }}</small>
                            </td>
                            <td>
                                {{ $order->items->sum('quantity') }} recette(s)
                            </td>
                            <td>
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            {{-- <td>
                                <span class="badge badge-{{ 
                                    $order->status == 'pending' ? 'warning' : 
                                    ($order->status == 'completed' ? 'success' : 'danger') 
                                }}">
                                    {{ $order->status }}
                                </span>
                            </td> --}}
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            },
            "order": [[5, "desc"]]
        });
    });
</script>
@endsection