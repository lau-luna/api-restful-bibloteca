<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
    ];

    // Relacion de uno a muchos inversa (Loan, User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relacion de uno a muchos inversa (Loan, Book)
    public function book()
    {
        return $this->belongsTo(User::class, 'book_id', 'id');
    }
}
