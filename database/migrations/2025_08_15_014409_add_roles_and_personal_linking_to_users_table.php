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
        Schema::table('users', function (Blueprint $table) {
            // Adiciona a coluna 'role' para definir o tipo de usuário.
            // O padrão será 'aluno'.
            $table->string('role')->default('aluno')->after('id');

            // Adiciona a chave estrangeira para o personal.
            // É anulável, pois um aluno pode não ter um personal.
            $table->foreignId('personal_id')->nullable()->constrained('users')->onDelete('set null')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove as colunas na ordem inversa para segurança
            $table->dropForeign(['personal_id']);
            $table->dropColumn(['role', 'personal_id']);
        });
    }
};