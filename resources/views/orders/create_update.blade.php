@extends('layout')

@section('content')

<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top-4 py-3 px-4">
            <h5 class="mb-0">
                <i class="bi bi-cpu me-2"></i>
                {{ isset($order) ? 'Editar Pedido #' . $order->id : 'Adicionar Novo Pedido' }}
            </h5>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Voltar
            </a>
        </div>

        <div class="card-body bg-light px-4 py-4">
            <form id="order-form" action="{{ isset($order) ? route('orders.update', $order->id) : route('orders.store') }}" method="POST">
                @csrf
                @if(isset($order))
                @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Cliente</label>
                    <select name="customer_id" class="form-select">
                        <option value="">Selecione o Cliente</option>
                        @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ old('customer_id', $order->customer_id ?? '') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-2">Itens do Pedido</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Preço Unitário</th>
                                <th>Quantidade</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="order-items-container">
                            @if(old('items'))
                            @foreach(old('items') as $i => $item)
                            @include('orders.partials.item_row', [
                            'index' => $i,
                            'products' => $products,
                            'selectedProduct' => $item['product_id'] ?? '',
                            'quantity' => $item['quantity'] ?? 1
                            ])
                            @endforeach
                            @elseif(isset($order) && $order->items)
                            @foreach($order->items as $i => $item)
                            @include('orders.partials.item_row', [
                            'index' => $i,
                            'products' => $products,
                            'selectedProduct' => $item->product_id,
                            'quantity' => $item->quantity
                            ])
                            @endforeach
                            @else
                            @include('orders.partials.item_row', [
                            'index' => 0,
                            'products' => $products,
                            'selectedProduct' => '',
                            'quantity' => 1
                            ])
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td id="total-price" class="fw-bold">0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-item-btn">
                        <i class="bi bi-plus-circle"></i> Adicionar Produto
                    </button>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save2"></i> Salvar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template invisível para clonar -->
<table class="d-none">
    <tbody id="item-template">
        @include('orders.partials.item_row', ['index' => 'INDEX_PLACEHOLDER', 'products' => $products, 'selectedProduct' => '', 'quantity' => 1])
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('order-items-container');
        const addBtn = document.getElementById('add-item-btn');
        const templateHtml = document.getElementById('item-template').innerHTML;
        const totalEl = document.getElementById('total-price');
        let itemIndex = container.children.length;

        function calculateTotal() {
            let total = 0;
            container.querySelectorAll('tr.item-row').forEach(row => {
                const price = parseFloat(row.querySelector('.unit-price').value) || 0;
                const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const subtotal = price * qty;
                row.querySelector('.item-subtotal').textContent = subtotal.toFixed(2);
                total += subtotal;
            });
            totalEl.textContent = total.toFixed(2);
        }

        function updateUnitPrice(row) {
            const select = row.querySelector('.product-select');
            const price = parseFloat(select.options[select.selectedIndex]?.dataset.price || 0);
            row.querySelector('.unit-price').value = price.toFixed(2);
            calculateTotal();
        }

        function addItem() {
            const div = document.createElement('tbody');
            div.innerHTML = templateHtml.replace(/INDEX_PLACEHOLDER/g, itemIndex);
            const newRow = div.querySelector('tr');
            container.appendChild(newRow);
            itemIndex++;

            newRow.querySelector('.product-select').addEventListener('change', () => updateUnitPrice(newRow));
            newRow.querySelector('.quantity-input').addEventListener('input', calculateTotal);
            newRow.querySelector('.remove-item-btn').addEventListener('click', () => {
                newRow.remove();
                calculateTotal();
            });

            updateUnitPrice(newRow);
        }

        // Inicializa eventos das linhas existentes
        container.querySelectorAll('tr.item-row').forEach(row => {
            row.querySelector('.product-select').addEventListener('change', () => updateUnitPrice(row));
            row.querySelector('.quantity-input').addEventListener('input', calculateTotal);
            const removeBtn = row.querySelector('.remove-item-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    row.remove();
                    calculateTotal();
                });
            }
            updateUnitPrice(row);
        });

        addBtn.addEventListener('click', addItem);
        calculateTotal();
    });
</script>
@endsection