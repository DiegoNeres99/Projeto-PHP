<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Lista todos os clientes
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        return view('customers.create_update');
    }

    // Armazena um novo cliente
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'email.required' => 'O campo Email é obrigatório.',
            'email.email' => 'O campo Email deve ser um endereço válido.',
            'phone.required' => 'O campo Telefone é obrigatório.',
            'address.required' => 'O campo Endereço é obrigatório.',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
                         ->with('success', 'Cliente cadastrado com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.create_update', compact('customer'));
    }

    // Atualiza um cliente existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Customer::findOrFail($id)->update($request->all());

        return redirect()->route('customers.index')
                         ->with('success', 'Cliente atualizado com sucesso!');
    }

    // Remove um cliente
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return redirect()->route('customers.index')
                             ->with('success', 'Cliente removido com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Código 23000 = violação de chave estrangeira
            if ($e->getCode() == '23000') {
                return redirect()->route('customers.index')
                                 ->with('error', '❌ Não é possível excluir este cliente, pois ele está vinculado a outros registros.');
            }
            throw $e;
        }
    }
}
