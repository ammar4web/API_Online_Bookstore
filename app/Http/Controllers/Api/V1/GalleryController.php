<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $books = Book::paginate(12);
        $title = 'معرض الكتب';

        $data = [
            'title' => $title,
            'books' => $books,
        ];

        return $data;
    }

    public function search(Request $request)
    {
        $books = Book::where('title', 'like', "%{$request->term}%")->paginate(12);
        $title = 'نتائج البحث عن: '. $request->term;

        $data = [
            'title' => $title,
            'books' => $books,
        ];

        return $data;
    }
}
