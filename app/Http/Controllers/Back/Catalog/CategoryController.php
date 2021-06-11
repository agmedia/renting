<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = new Category();

        $categories = collect();
        $groups = $category->groups()->pluck('group');

        foreach ($groups as $group) {
            $categories->put($group,
                $category->topList($group)->with('subcategories')->get()
            );
        }
        
        return view('back.catalog.category.index', compact('categories'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Category::groups()->pluck('group');
        $parents = Category::topList()->pluck('title', 'id');
        
        return view('back.catalog.category.edit', compact('parents', 'groups'));
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();

        $stored = $category->validateRequest($request)->create();

        if ($stored) {
            $category->resolveImage($stored);

            return redirect()->route('category.edit', ['category' => $stored])->with(['success' => 'Category was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the category.']);
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $groups = Category::groups()->pluck('group');
        $parents = Category::topList()->pluck('title', 'id');
        
        return view('back.catalog.category.edit', compact('category', 'parents', 'groups'));
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category                 $category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $updated = $category->validateRequest($request)->edit();

        if ($updated) {
            $category->resolveImage($updated);

            return redirect()->route('category.edit', ['category' => $updated])->with(['success' => 'Category was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the category.']);
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $destroyed = Category::destroy($category->id);

        if ($destroyed) {
            return redirect()->route('categories')->with(['success' => 'Category was succesfully deleted!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error deleting the category.']);
    }
}
