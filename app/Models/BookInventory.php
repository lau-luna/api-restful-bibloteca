<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookInventory extends Model
{
    use HasFactory;

    protected $table = 'book_inventory';

    protected $fillable = [
        'book_id',
        'quantity_total',
        'quentity_available'
    ];

    public function books(){
        return $this->hasMany(Book::class, 'book_id', 'id');
    }
}
