<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create_update');
    }

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
            'phone.required' => 'O campo Telefone é obrigatório.',
            'address.required' => 'O campo Endereço é obrigatório.',
        ]);  
        Customer::create($request->all());
        return redirect()->route('customers.index');
    }

     public function show(string $id)
    {
        return 'O id do usuário é: ' . $id;
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.create_update', compact('customer'));
    }

    public function update(Request $request, $id)
    {
       Customer::find($id)->update($request->all());
        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
      Customer::find($id)->delete();
        return redirect()->route('customers.index');
    }
}
