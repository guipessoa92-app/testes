<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Importante para o Seeder

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cria a tabela de referência para os dias da semana
        Schema::create('day_of_weeks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex: 'segunda', 'terca'
        });

        // 2. Insere os dias da semana na nova tabela
        DB::table('day_of_weeks')->insert([
            ['name' => 'segunda'], ['name' => 'terca'], ['name' => 'quarta'],
            ['name' => 'quinta'], ['name' => 'sexta'], ['name' => 'sabado'],
            ['name' => 'domingo'],
        ]);

        // 3. Cria a tabela pivô para a relação muitos-para-muitos
        Schema::create('day_of_week_training', function (Blueprint $table) {
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->foreignId('day_of_week_id')->constrained()->onDelete('cascade');
            $table->primary(['training_id', 'day_of_week_id']); // Chave primária composta
        });

        // 4. Remove a coluna antiga da tabela de treinos
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('day_of_week');
        });
    }

    public function down(): void
    {
        // Desfaz as operações na ordem inversa
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('day_of_week')->nullable();
        });
        Schema::dropIfExists('day_of_week_training');
        Schema::dropIfExists('day_of_weeks');
    }
};