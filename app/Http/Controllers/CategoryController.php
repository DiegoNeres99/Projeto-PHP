<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Lista todas as categorias
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        return view('categories.create_update');
    }

    // Armazena uma nova categoria
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'status' => 'required|in:Ativa,Inativa',
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'stock.required' => 'O campo Estoque é obrigatório.',
            'stock.numeric' => 'O campo Estoque deve ser numérico.',
            'status.required' => 'O campo Status é obrigatório.',
        ]);

        // Salva o valor digitado no estoque (não somamos aqui, é criação)
        Category::create($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Categoria criada com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.create_update', compact('category'));
    }

    // Atualiza a categoria existente
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'status' => 'required|in:Ativa,Inativa',
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'stock.required' => 'O campo Estoque é obrigatório.',
            'stock.numeric' => 'O campo Estoque deve ser numérico.',
            'status.required' => 'O campo Status é obrigatório.',
        ]);

        // Atualiza os campos
        $category->name = $request->name;
        $category->status = $request->status;

        // Aqui você decide:
        // 1) Para substituir o estoque digitado:
        // $category->stock = $request->stock;
        // 2) Para somar ao estoque atual:
        $category->stock += $request->stock;

        $category->save();

        return redirect()->route('categories.index')
                         ->with('success', 'Categoria atualizada com sucesso!');
    }

    // Remove uma categoria
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('categories.index')
                         ->with('success', 'Categoria removida com sucesso!');
    }
}
