<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
    use HasFactory;

    protected $table = 'categories';

    // Relacion de uno a muchos (Category, Post)
    public function post(){
        return $this->hasMany(Post::class, 'id', 'category_id');
    }
}
