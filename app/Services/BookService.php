<?php

namespace App\Services;

use App\Models\Book;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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

    public static function update(array $data, Book $book)
    {
        DB::beginTransaction();
        try {
            if (array_key_exists('cover_image', $data)) {
                $temporaryImagePath = 'temporary/' . basename($book->cover_image);
                Storage::disk('public')->move($book->cover_image, $temporaryImagePath);
                $coverImagePath = self::uploadImage($data['cover_image']);
                $data['cover_image'] = $coverImagePath;
            }

            $book->isbn = $data['isbn'];

            if ($book->isDirty('isbn')) {
                $validator = Validator::make(
                    ['isbn' => $data['isbn']],
                    ['isbn' => ['required', 'alpha_num', Rule::unique('books', 'isbn')]],
                );
                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
            }

            $book->update($data);

            $book->authors()->detach();
            // Check if 'authors' key exists in the data array before attaching
            if (array_key_exists('authors', $data)) {
                $book->authors()->attach($data['authors']);
            }

            DB::commit();

            if (array_key_exists('cover_image', $data)) {
                Storage::disk('public')->delete($temporaryImagePath);
            }
            return $book;

        } catch (\Exception $e) {

            DB::rollback();
            if (isset($coverImagePath) && isset($temporaryImagePath)) {
                Storage::disk('public')->delete($coverImagePath);
                Storage::disk('public')->move($temporaryImagePath, $book->cover_image);
            }

            throw $e; // Rethrow the exception

        }
    }
}
