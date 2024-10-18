<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamps();

            
            // Clave foránea tabla users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Clave foránea tabla categories
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropForeign(['user_id']);
        Schema::dropForeign(['category_id']);
    }
};
