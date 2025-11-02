@extends('layout')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-people me-2 text-primary"></i> Clientes
        </h2>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Cliente
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body bg-light p-4">

            {{-- ✅ Alertas de sucesso ou erro --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <table class="table table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th><i class="bi bi-person"></i> Nome</th>
                        <th><i class="bi bi-credit-card-2-front"></i> CPF</th>
                        <th><i class="bi bi-envelope"></i> Email</th>
                        <th><i class="bi bi-telephone"></i> Telefone</th>
                        <th><i class="bi bi-house"></i> Endereço</th>
                        <th><i class="bi bi-gear"></i> Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr class="bg-white border-bottom">
                        <td class="fw-semibold">{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->cpf }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>

                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja deletar este cliente?')">
                                    <i class="bi bi-trash3"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-exclamation-circle fs-4"></i><br>
                            Nenhum cliente cadastrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">