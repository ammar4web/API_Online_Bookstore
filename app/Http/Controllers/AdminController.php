<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;

class AdminController extends Controller
{
    public function index()
    {
        $number_of_books = Book::count();
        $number_of_categories = Category::count();
        $number_of_authors = Author::count();
        $number_of_publishers = Publisher::count();

        $data = [
            'number_of_books' => $number_of_books,
            'number_of_categories' => $number_of_categories,
            'number_of_authors' => $number_of_authors,
            'number_of_publishers' => $number_of_publishers,
        ];

        return $data;
    }
}
