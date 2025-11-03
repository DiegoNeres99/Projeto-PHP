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
        // Envia uma nova instância vazia para o mesmo form (reuso de view)
        $category = new Category();
        return view('categories.create_update', compact('category'));
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
            'status' => 'required|in:ativo,inativo',



        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'stock.required' => 'O campo Estoque é obrigatório.',
            'stock.numeric' => 'O campo Estoque deve ser numérico.',
            'status.required' => 'O campo Status é obrigatório.',
        ]);

        // Atualiza os campos diretamente
        $category->name = $request->name;
        $category->status = $request->status;
        $category->stock = $request->stock; // <-- Agora substitui o valor, não soma

        $category->save();

        return redirect()->route('categories.index')
                         ->with('success', 'Categoria atualizada com sucesso!');
    }

    // Remove uma categoria
    public function destroy($id)
{
    try {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Categoria removida com sucesso!');
    } catch (\Illuminate\Database\QueryException $e) {
        // Código 23000 = erro de integridade (foreign key)
        if ($e->getCode() == '23000') {
            return redirect()->route('categories.index')
                             ->with('error', '❌ Não é possível excluir esta categoria, pois ela está sendo utilizada por um ou mais produtos.');
        }

        // Outros erros, apenas relança
        throw $e;
    }
}

}
