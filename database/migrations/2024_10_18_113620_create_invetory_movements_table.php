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
        Schema::create('invetory_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->string('movement_type', 10);
            $table->unsignedInteger('quantity');
            $table->string('user_name', 50);
            $table->string('user_surname', 100);
            $table->string('user_email', 255);
            $table->string('book_title', 255);
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('book_ISBN')->nullable();
            $table->string('book_image')->nullable();
            $table->unsignedBigInteger('book_google_books_id')->nullable();
            $table->timestamps();

            // Clave foránea para tabla users
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            // Clave foránea para tabla books
            $table->foreign('book_id')
                ->references('id')
                ->on('books');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invetory_movements');
    }
};
