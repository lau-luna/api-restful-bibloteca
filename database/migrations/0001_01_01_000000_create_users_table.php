<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna auto_increment y clave primaria
            $table->string('name', 50);
            $table->string('surname', 100);
            $table->string('email', 255)->unique();
            $table->unsignedBigInteger('telephone'); // Usar unsignedBigInteger para un número de teléfono
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('role', 20);
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Columna email como clave primaria
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Columna id como clave primaria
            $table->foreignId('user_id')->nullable()->index(); // Clave foránea a la tabla users
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions'); // Primero eliminar sesiones por dependencia
        Schema::dropIfExists('password_reset_tokens'); // Luego eliminar tokens de reinicio de contraseña
        Schema::dropIfExists('users'); // Finalmente eliminar la tabla de usuarios
    }
};
