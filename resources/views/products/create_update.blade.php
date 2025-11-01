@extends('layout')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top-4 py-3 px-4">
            <h5 class="mb-0">
                <i class="bi bi-cpu me-2"></i>
                {{ isset($product) ? 'Editar Produto' : 'Adicionar Produto' }}
            </h5>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Voltar
            </a>
        </div>

        <div class="card-body bg-light px-4 py-4">
            <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST">
                @csrf
                @if (isset($product))
                    @method('PUT')
                @endif

                <!-- Nome -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-dark">
                        <i class="bi bi-box-seam me-1 text-primary"></i> Nome do Produto
                    </label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Ex: Fone Bluetooth JBL" value="{{ $product->name ?? '' }}" />
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold text-dark">
                        <i class="bi bi-card-text me-1 text-primary"></i> Descrição
                    </label>
                    <textarea name="description" rows="3" class="form-control"
                        placeholder="Ex: Fone com cancelamento de ruído e bateria de 30h.">{{ $product->description ?? '' }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Preço -->
                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold text-dark">
                        <i class="bi bi-cash-coin me-1 text-primary"></i> Preço (R$)
                    </label>
                    <input type="number" step="0.01" name="price" class="form-control"
                        placeholder="Ex: 499.90" value="{{ $product->price ?? '' }}" />
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Categoria -->
                <div class="mb-4">
                    <label for="category_id" class="form-label fw-semibold text-dark">
                        <i class="bi bi-tags me-1 text-primary"></i> Categoria
                    </label>
                    <select name="category_id" class="form-select">
                        <option value="">Selecione</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4 me-2">
                        <i class="bi bi-save2"></i> Salvar
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary px-3">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
