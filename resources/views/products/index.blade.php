@extends('layout')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-cpu me-2 text-primary"></i> Produtos Eletrônicos
        </h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Produto
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body bg-light p-4">
            <table class="table table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th><i class="bi bi-box-seam"></i> Nome</th>
                        <th><i class="bi bi-card-text"></i> Descrição</th>
                        <th><i class="bi bi-cash-coin"></i> Preço</th>
                        <th><i class="bi bi-tags"></i> Categoria</th>
                        <th><i class="bi bi-gear"></i> Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                    <tr class="bg-white border-bottom">
                        <td class="fw-semibold">{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td class="text-muted">{{ $product->description }}</td>
                        <td class="text-success fw-bold">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-info text-dark px-3 py-2">
                                {{ $product->category->name ?? 'Sem categoria' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja deletar este produto?')">
                                    <i class="bi bi-trash3"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($products->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-exclamation-circle fs-3"></i>
                    <p class="mt-2">Nenhum produto cadastrado.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
