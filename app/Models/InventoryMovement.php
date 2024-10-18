<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $table = 'inventory_movement';

    protected $fillable = [
        'user_id',
        'book_id',
        'movement_type',
        'quantity',
        'movement_date',
        'user_name',
        'user_surname',
        'user_email',
        'book_title',
        'author_id',
        'publisher_id',
        'category_id',
        'book_ISBN',
        'book_image',
        'book_google_books_id'
    ];

    // Relacion de uno a muchos inversa (InventoryMovement, User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relacion de uno a muchos inversa (InventoryMovement, Book)
    public function book()
    {
        return $this->belongsTo(User::class, 'book_id', 'id');
    }
}
