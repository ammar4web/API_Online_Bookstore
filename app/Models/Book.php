<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'cover_image', 'isbn', 'category_id', 'publisher_id', 'description', 'publish_year', 'number_of_pages', 'number_of_copies', 'price'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function publisher()
    {
        return $this->belongsTo('App\Models\Publisher');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Models\Author', 'book_author');
    }
}
