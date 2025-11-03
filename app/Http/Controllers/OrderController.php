<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer; // Usando Customer no lugar de Client
use App\Models\Product;
use App\Models\OrderItem;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class OrderController extends Controller
{
    public function index()
    {
        // Carrega os pedidos com os clientes e itens
        $orders = Order::with('customer', 'items.product')->get(); 
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $clients = Customer::get(); // Lista de clientes (Customers)
        $products = Product::get(); // Lista de produtos
        return view('orders.create_update', compact('clients', 'products'));
    }

    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            // 1. Cria o Pedido (Order) com customer_id
            $order = Order::create([
                'customer_id' => $request->customer_id, // Campo atualizado
                'order_date' => now()->toDateString(), 
                'status' => 'Pendente', 
            ]);

            // 2. Cria os Itens do Pedido (OrderItems)
            $itemsToStore = [];
            foreach ($request->items as $itemData) {
                $itemsToStore[] = new OrderItem([
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                ]);
            }
            
            $order->items()->saveMany($itemsToStore);

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Pedido criado com sucesso!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Erro ao criar o pedido: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $clients = Customer::get(); // Lista de clientes (Customers)
        $products = Product::get();
        
        return view('orders.create_update', compact('order', 'clients', 'products'));
    }

    public function update(UpdateOrderRequest $request, string $id)
    {
        $order = Order::findOrFail($id);

        DB::beginTransaction();
        try {
            // 1. Atualiza o Pedido (Order) com customer_id
            $order->update([
                'customer_id' => $request->customer_id, // Campo atualizado
            ]);

            // 2. Remove e recria os itens
            $order->items()->delete(); 

            $itemsToStore = [];
            foreach ($request->items as $itemData) {
                $itemsToStore[] = new OrderItem([
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                ]);
            }

            $order->items()->saveMany($itemsToStore);

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Pedido atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Erro ao atualizar o pedido: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->route('orders.index')->with('success', 'Pedido deletado com sucesso!');
    }
    
    public function show(string $id)
    {
        return 'Detalhes do pedido: ' . $id;
    }
}