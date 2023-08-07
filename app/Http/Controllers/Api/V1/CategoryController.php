<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all()->load(['books']);
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {

            $category = new Category($request->validated());
            $category->save();

            $data = [
                'message' => 'Category was added successfully',
                'category' => $category,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the Category.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $category->load(['books']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {

            $category->update($request->validated());
            $data = [
                'message' => 'Category was updated successfully',
                'newCategory' => $category,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the Category.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {

            $category_delete = $category;
            $category->delete();
            $data = [
                'message' => 'Category was deleted successfully',
                'newCategory' => $category_delete,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the Category.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    public function result(Category $category)
    {
        $books = $category->books()->paginate(12)->load(['publisher', 'authors']);
        $title = 'الكتب التابعة لتصنيف: ' . $category->name;

        $data = [
            'title' => $title,
            'books' => $books,
        ];

        return $data;
    }

    function list() {
        $categories = Category::all()->sortBy('name')->load(['books']);
        $title = 'التصنيفات';

        $data = [
            'title' => $title,
            'categories' => $categories,
        ];

        return $data;
    }

    public function search(Request $request)
    {
        $categories = Category::where('name', 'like', "%{$request->term}%")->get()->sortBy('name')->load(['books']);
        $title = ' نتائج البحث عن: ' . $request->term;

        $data = [
            'title' => $title,
            'categories' => $categories,
        ];

        return $data;
    }
}
