<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     
    public function index()
    {
        $products = Product::get();
        return view('products.index', compact('products'));
    }

    
    public function create()
    {
        $categories = Category::get();
        return view('products.create_update', compact('categories'));
    }
  
    public function store(Request $request)
    {    
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'description.required' => 'O campo Descrição é obrigatório.',
            'price.required' => 'O campo Preço é obrigatório.',
        ]);      

        Product::create($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'O id do usuário é: ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)

    {
        $product = Product::find($id);
        $categories = Category::get();
        return view('products.create_update', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Product::find($id)->update($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::find($id)->delete();
        return redirect()->route('products.index');
    }
}
