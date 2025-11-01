@extends('layout')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-tags me-2 text-primary"></i> Categorias
        </h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Categoria
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body bg-light p-4">
            <table class="table table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th><i class="bi bi-tags"></i> Nome</th>                        
                        <th><i class="bi-basket"></i> Estoque</th>
                        <th><i class="bi bi-house"></i> Status</th>
                        <th><i class="bi bi-gear"></i> Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                    <tr class="bg-white border-bottom">
                        <td class="fw-semibold">{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count ?? 0 }}</td> <!-- Estoque -->
                        <td>
                            @if($category->status == 'Ativa')
                                <span class="badge bg-success">Ativa</span>
                            @else
                                <span class="badge bg-danger">Inativa</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja deletar esta categoria?')">
                                    <i class="bi bi-trash3"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($categories->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-exclamation-circle fs-3"></i>
                    <p class="mt-2">Nenhuma categoria cadastrada.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
