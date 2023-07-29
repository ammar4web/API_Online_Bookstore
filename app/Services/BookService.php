<?php

namespace App\Services;

use App\Models\Book;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookService
{
    use ImageUploadTrait;

    public static function create(array $data)
    {
        DB::beginTransaction();
        try {

            $book = new Book($data);
            $coverImagePath = self::uploadImage($data['cover_image']);
            $book->cover_image = $coverImagePath;
            $book->save();

            // Check if 'authors' key exists in the data array before attaching
            if (array_key_exists('authors', $data)) {
                $book->authors()->attach($data['authors']);
            }

            DB::commit();
            return $book;

        } catch (\Exception $e) {

            DB::rollback();
            Storage::disk('public')->delete($coverImagePath);

            throw $e; // Rethrow the exception

        }
    }
}
