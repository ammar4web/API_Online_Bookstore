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
}
