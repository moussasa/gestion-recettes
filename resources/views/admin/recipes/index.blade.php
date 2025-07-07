
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Gestion des Recettes</h1>
                <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Note moyenne</th>
                            <th>Date création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recipes as $recipe)
                        <tr>
                            <td>
                                @if($recipe->image)
                                <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" width="60" class="img-thumbnail">
                                @else
                                <span class="text-muted">Aucune image</span>
                                @endif
                            </td>
                            <td>{{ $recipe->title }}</td>
                            <td>{{ $recipe->type }}</td>
                            <td>
                                {{ number_format($recipe->averageRating(), 1) }}
                                <small class="text-muted">({{ $recipe->reviews_count }} avis)</small>
                            </td>
                            <td>{{ $recipe->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.recipes.edit', $recipe) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
            }
        });
    });
</script>
@endsection