<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            // Adiciona a coluna que guardará a data/hora da conclusão
            $table->timestamp('completed_at')->nullable()->after('notes');

            // Adiciona a coluna para o feedback do usuário
            $table->text('feedback')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropColumn(['completed_at', 'feedback']);
        });
    }
};