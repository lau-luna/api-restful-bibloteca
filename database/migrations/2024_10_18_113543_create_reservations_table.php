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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->date('reservation_date');
            $table->string('status', 50);
            $table->timestamps();

            // Clave foránea para tabla users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

            // Clave foránea para tabla books
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
