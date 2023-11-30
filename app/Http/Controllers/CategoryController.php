<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Policies\CategoryPolicy;
class CategoryController extends Controller
{
 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // Obtén solo las categorías del usuario autenticado
        $categories = auth()->user()->categories;
        
        return view('category.category-index', compact('categories'));
       
    }
    


    /**
     * Show the form for creating a new resource.
     *x
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $request->validate([
            'name' => 'required|string|min:1|max:255'
        ]);
    
        $category = new Category($request->all());
        $category->user_id = auth()->id(); // Asigna el ID del usuario autenticado
        $category->save();
    
        return redirect()->route('category.index')->with('message', 'Categoria creada exitosamente');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    { 
        return view('category.category-index', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {     
        $request->validate([
            'name' => 'required|string|min:1|max:255'
        ]);   
        Category::where('id', $category->id)->update($request->except('_token', '_method'));
        return redirect()->route('category.index')->with('message', 'Categoria actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {        
    
        $category->delete();
        return redirect()->route('category.index')->with('message', 'Categoria eliminada exitosamente');
    }
}
