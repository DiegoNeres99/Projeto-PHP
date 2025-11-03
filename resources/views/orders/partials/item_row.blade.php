<tr class="item-row">
    <td>
        <select name="items[{{ $index }}][product_id]" class="form-select form-select-sm product-select">
            <option value="">Selecione o Produto</option>
            @foreach($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $selectedProduct == $product->id ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="number" name="items[{{ $index }}][unit_price]" value="0.00" readonly class="form-control form-control-sm unit-price" />
    </td>
    <td>
        <input type="number" name="items[{{ $index }}][quantity]" value="{{ $quantity ?: 1 }}" min="1" class="form-control form-control-sm quantity-input" />
    </td>
    <td class="item-subtotal">0.00</td>
    <td>
        <button type="button" class="btn btn-danger btn-sm remove-item-btn text-white">
            Remover
        </button>
    </td>
</tr>