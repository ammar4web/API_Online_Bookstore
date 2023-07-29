<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all()->load(['publisher', 'category', 'authors']);
        return $books;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getBookFormData()
    {
        $authors = Author::all();
        $categories = Category::all();
        $publishers = Publisher::all();

        $data = [
            'authors' => $authors,
            'categories' => $categories,
            'publishers' => $publishers,
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        try {

            $book = BookService::create($request->validated());

            session()->flash('flash_message', 'تمت إضافة الكتاب بنجاح');

            return $book->load(['publisher', 'category', 'authors']);

        } catch (\Exception $e) {

            return response()->json([
                'Message' => 'Failed to add the book.',
                'The erorr' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return $book->load(['publisher', 'category', 'authors']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }

    public function details(Book $book)
    {
        return $book->load(['publisher', 'category', 'authors']);
    }
}
