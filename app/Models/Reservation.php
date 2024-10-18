<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'user_id',
        'book_id',
        'reservation_date',
        'status',
    ];

    // Relacion de uno a muchos inversa (Reservation, User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relacion de uno a muchos inversa (Reservation, Book)
    public function book()
    {
        return $this->belongsTo(User::class, 'book_id', 'id');
    }
}
