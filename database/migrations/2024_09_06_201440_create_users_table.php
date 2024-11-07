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
        Schema::create(table: 'users', callback: function (Blueprint $table): void {
            $table->id();
            $table->string(column: 'first_name',length: 60);
            $table->string(column: 'last_name',length: 60);
            $table->string(column: 'email')->unique();
            $table->timestamp(column: 'email_verified_at')->nullable();
            $table->string(column: 'password');
            $table->rememberToken();
            $table->foreignId('image_id')->nullable()->constrained('images')->onDelete('cascade');
            $table->foreignId(column: 'rol_id')->constrained(table: 'roles');
            $table->foreignId(column: 'professional_id')->nullable()->constrained(table: 'professionals')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create(table: 'password_reset_tokens', callback: function (Blueprint $table): void {
            $table->string(column: 'email')->primary();
            $table->string(column: 'token');
            $table->timestamp(column: 'created_at')->nullable();
        });

        Schema::create(table: 'sessions', callback: function (Blueprint $table): void {
            $table->string(column: 'id')->primary();
            $table->foreignId(column: 'user_id')->nullable()->index();
            $table->string(column: 'ip_address', length: 45)->nullable();
            $table->text(column: 'user_agent')->nullable();
            $table->longText(column: 'payload');
            $table->integer(column: 'last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'users');
        Schema::dropIfExists(table: 'password_reset_tokens');
        Schema::dropIfExists(table: 'sessions');
    }
};
