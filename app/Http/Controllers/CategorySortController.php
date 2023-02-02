<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategorySortController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach ($request->categories as $category) {
            Category::find($category['id'])->update([
                'order' => $category['order'],
                'category_parent' => $request->category_parent
            ]);
        }
//        return back();
    }
}
