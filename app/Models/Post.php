<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'category_id'
    ];

    // Relacion de uno a muchos inversa (Post, User)
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relacion de uno a muchos inversa (Post, Category)
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
