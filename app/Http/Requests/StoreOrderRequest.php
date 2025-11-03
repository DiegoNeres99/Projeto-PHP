<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            // Cliente ID: obrigatório e deve existir na tabela 'customers'
            'customer_id' => 'required|exists:customers,id',
            
            // Itens do Pedido:
            'items' => 'required|array|min:1', 
            // Valida product_id na tabela 'product' (singular)
            'items.*.product_id' => 'required|exists:product,id', 
            'items.*.quantity' => 'required|numeric|min:1', 
            'items.*.unit_price' => 'required|numeric|min:0.01', 
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'O campo Cliente é obrigatório.',
            'customer_id.exists' => 'O Cliente selecionado é inválido.',
            
            'items.required' => 'O Pedido deve conter pelo menos um item.',
            'items.min' => 'O Pedido deve conter pelo menos um item.',
            'items.*.product_id.required' => 'O Produto de um item é obrigatório.',
            'items.*.product_id.exists' => 'O Produto de um item é inválido.',
            'items.*.quantity.required' => 'A Quantidade de um item é obrigatória.',
            'items.*.quantity.numeric' => 'A Quantidade deve ser um número.',
            'items.*.quantity.min' => 'A Quantidade deve ser positiva.',
            'items.*.unit_price.required' => 'O Preço Unitário de um item é obrigatório.',
            'items.*.unit_price.numeric' => 'O Preço Unitário deve ser um número.',
            'items.*.unit_price.min' => 'O Preço Unitário deve ser positivo.',
        ];
    }
}