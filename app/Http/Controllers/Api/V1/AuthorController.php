<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequestest;
use App\Http\Requests\UpdateAuthorRequestest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Author::all()->load(['books']);
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequestest $request)
    {
        try {

            $author = new Author($request->validated());
            $author->save();

            $data = [
                'message' => 'Author was added successfully',
                'author' => $author,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the Author.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return $author->load(['books']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequestest $request, Author $author)
    {
        try {

            $author->update($request->validated());
            $data = [
                'message' => 'Author was updated successfully',
                'newAuthor' => $author,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the Author.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        try {

            $author_delete = $author;
            $author->delete();
            $data = [
                'message' => 'Author was deleted successfully',
                'newAuthor' => $author_delete,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the Author.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    public function result(Author $author)
    {
        $books = $author->books()->paginate(12)->load(['publisher','category']);
        $title = 'الكتب التابعة للمؤلف: ' . $author->name;

        $data = [
            'title' => $title,
            'books' => $books,
        ];

        return $data;
    }

    public function list()
    {
        $authors = Author::all()->sortBy('name')->load(['books']);
        $title = 'المؤلفون';

        $data = [
            'title' => $title,
            'authors' => $authors,
        ];

        return $data;
    }

    public function search(Request $request)
    {
        $authors = Author::where('name', 'like', "%{$request->term}%")->get()->sortBy('name')->load(['books']);
        $title = ' نتائج البحث عن: ' . $request->term;

        $data = [
            'title' => $title,
            'authors' => $authors,
        ];

        return $data;
    }
}
