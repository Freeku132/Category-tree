<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $category = \App\Models\Category::query()->where('category_parent', NULL)->with('allSubCategories')->orderBy('order')->get();


        return Inertia::render('Category',[
            'categories' => $category,
        ]);
    }

    public function store(Request $request)
    {

        $attributes = $request->validate([
            'name' => 'required',
            'order' => 'numeric',
            'category_parent_id' => 'nullable|numeric'
        ]);

        Category::create([
            'name' => $attributes['name'],
            'order' => $attributes['order'],
            'category_parent' => $attributes['category_parent_id']
        ]);

        return back()->with('success');
    }

    public function destroy(Request $request)
    {
        $category = Category::query()->findOrFail($request->id);
        $categories = Category::query()->where('category_parent' , $category->id)->get();


        if($request->delete_sub) {

            DB::select('CALL DropSubCategory('.$category->id.');');

        } else {
            foreach ($categories as $cat){
                $cat->update([
                    'category_parent' => $category->category_parent,
                    'order' => $category->order,
                ]);
            }
            $category->deleteOrFail();
        }




        return back()->with('success');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'id' => 'required'
        ]);

         Category::query()
            ->find($attributes['id'])
            ->update([
                'name' => $attributes['name']
            ]);

        return back()->with('success');
    }
}
