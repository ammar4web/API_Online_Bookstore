<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Rating;
use App\Services\BookService;
use Illuminate\Support\Facades\Storage;
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
    public function update(UpdateBookRequest $request, Book $book)
    {
        // return $request->all();
        $book = BookService::update($request->all(), $book);


        session()->flash('flash_message', 'تم تعديل الكتاب بنجاح');

        $data = [
            'message' => 'Book data has been updated',
            'updated_book' => $book->load(['publisher', 'category', 'authors']),
        ];

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {

        $deleted_book = $book->load(['publisher', 'category', 'authors']);
        Storage::disk('public')->delete($book->cover_image);

        $book->delete();

        session()->flash('flash_message','تم حذف الكتاب بنجاح');

        $data = [
            'message' => 'The Book has been deleted successfully',
            'deleted_book' => $deleted_book,
        ];

        return $data;
    }

    public function details(Book $book)
    {
        $book->load(['publisher', 'category', 'authors', 'ratings']);
        return $date = [
            $book,
            $book->rate()
        ];
    }

    public function rate(Request $request, Book $book)
    {
        if(auth()->user()->rated($book)) {
            $rating = Rating::where(['user_id' => auth()->user()->id, 'book_id' => $book->id])->first();
            $rating->value = $request->value;
            $rating->save();
        } else {
            $rating = new Rating;
            $rating->user_id = auth()->user()->id;
            $rating->book_id = $book->id;
            $rating->value = $request->value;
            $rating->save();
        }
        return redirect()->route('book.details', $book->id);
    }
}
