<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author_id',
        'publisher_id',
        'category_id',
        'ISBN',
        'year_published',
        'description',
        'image',
        'google_books_id'
    ];

    // Relacion de uno a muchos inversa (Book, Author)
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
    

    // Relacion de uno a muchos inversa (Book, Category)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    
}
