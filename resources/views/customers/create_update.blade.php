@extends('layout')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top-4 py-2 px-3">
            <h6 class="mb-0">
                <i class="bi bi-person me-2"></i>
                {{ isset($customer) ? 'Editar Cliente' : 'Adicionar Cliente' }}
            </h6>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Voltar
            </a>
        </div>

        <div class="card-body bg-light px-4 py-3">
            <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST">
                @csrf
                @if (isset($customer))
                    @method('PUT')
                @endif

                <!-- Nome -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-dark">
                        <i class="bi bi-person me-1 text-primary"></i> Nome
                    </label>
                    <input type="text" class="form-control form-control-sm" id="name" name="name"
                        value="{{ old('name', $customer->name ?? '') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- CPF -->
                <div class="mb-3">
                    <label for="cpf" class="form-label fw-semibold text-dark">
                        <i class="bi bi-credit-card-2-front me-1 text-primary"></i> CPF
                    </label>
                    <input type="text" class="form-control form-control-sm" id="cpf" name="cpf"
                        value="{{ old('cpf', $customer->cpf ?? '') }}">
                    @error('cpf')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-dark">
                        <i class="bi bi-envelope me-1 text-primary"></i> Email
                    </label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email"
                        value="{{ old('email', $customer->email ?? '') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Telefone -->
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold text-dark">
                        <i class="bi bi-telephone me-1 text-primary"></i> Telefone
                    </label>
                    <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                        value="{{ old('phone', $customer->phone ?? '') }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Endereço -->
                <div class="mb-4">
                    <label for="address" class="form-label fw-semibold text-dark">
                        <i class="bi bi-house me-1 text-primary"></i> Endereço
                    </label>
                    <input type="text" class="form-control form-control-sm" id="address" name="address"
                        value="{{ old('address', $customer->address ?? '') }}">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success btn-sm px-3 me-2">
                        <i class="bi bi-save2"></i> Salvar
                    </button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
