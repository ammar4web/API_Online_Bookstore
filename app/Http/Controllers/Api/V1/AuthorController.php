<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
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
