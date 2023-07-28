<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
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
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        //
    }

    public function result(Publisher $publisher)
    {
        $books = $publisher->books()->paginate(12)->load(['category', 'authors']);
        $title = 'الكتب التابعة للناشر: ' . $publisher->name;

        $data = [
            'title' => $title,
            'books' => $books,
        ];

        return $data;
    }

    public function list()
    {
        $publishers = Publisher::all()->sortBy('name')->load(['books']);
        $title = 'الناشرون';

        $data = [
            'title' => $title,
            'publishers' => $publishers,
        ];

        return $data;
    }

    public function search(Request $request)
    {
        $publishers = Publisher::where('name', 'like', "%{$request->term}%")->get()->sortBy('name')->load(['books']);
        $title = ' نتائج البحث عن: ' . $request->term;

        $data = [
            'title' => $title,
            'publishers' => $publishers,
        ];

        return $data;
    }
}
