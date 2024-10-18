<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('ISBN')->nullable();
            $table->unsignedInteger('year_published');
            $table->text('description');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('google_books_id')->nullable();
            $table->timestamps();

            // Clave foránea tabla authors
            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onUpdate('cascade');
            
            // Clave foránea tabla publishers
            $table->foreign('publisher_id')
                ->references('id')
                ->on('publishers')
                ->onUpdate('cascade');

            // Clave foránea tabla category
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropForeign(['author_id']);
        Schema::dropForeign(['publisher_id']);
        Schema::dropForeign(['category_id']);

    }
};
