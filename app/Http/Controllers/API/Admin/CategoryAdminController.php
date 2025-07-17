<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
class CategoryAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(["message" => "returned all categories", "categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategory $request)
    {
        $category = Category::create($request->validated());
        return response()->json(["message" => "created new category", "new category" => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategory $request, string $id)
    {
        $category = Category::find($id);
        $category->update($request->validated());
        return response()->json(["message" => "updated category successfully by admin", "category" => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json(["message"=> "this category is not found"],404);
        }
        $category->delete();
        return response()->json(["message"=> "deleted category successfully by admin", "category" => $category]);
    }
}
