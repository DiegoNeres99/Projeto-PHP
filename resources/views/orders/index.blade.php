@extends('layout')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-cart-check me-2 text-primary"></i> Gerenciamento de Pedidos
        </h2>
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Pedido
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body bg-light p-4">
            <table class="table table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th><i class="bi bi-person"></i> Cliente</th>
                        <th><i class="bi bi-calendar"></i> Data</th>
                        <th><i class="bi bi-list-ol"></i> Itens</th>
                        <th><i class="bi bi-cash-coin"></i> Total</th>
                        <th><i class="bi bi-info-circle"></i> Status</th>
                        <th><i class="bi bi-gear"></i> Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                    <tr class="bg-white border-bottom">
                        <td class="fw-semibold">{{ $order->id }}</td>
                        {{-- **CAMPO ATUALIZADO** --}}
                        <td>{{ $order->customer->name ?? 'Cliente Removido' }}</td> 
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td class="text-success fw-bold">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status === 'Pendente' ? 'warning text-dark' : 'success' }} px-3 py-2">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>

                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja deletar este pedido?')">
                                    <i class="bi bi-trash3"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($orders->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-exclamation-circle fs-3"></i>
                    <p class="mt-2">Nenhum pedido cadastrado.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection