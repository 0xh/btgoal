<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Get all of the categories.
     *
     * @return Response
     */
    public function all(Request $request)
    {
        return Category::all();
    }

    /**
     * Create a new Category.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        return Category::create(['name' => $request->name]);
   
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();
        return $category;
    }

    /**
     * Destroy the given Category.
     *
     * @param  Request  $request
     * @param  Category  $category
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        return Category::destroy($id);
    }
}


