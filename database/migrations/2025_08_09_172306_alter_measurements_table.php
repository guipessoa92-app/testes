<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            // Removendo colunas antigas que não usaremos mais
            $table->dropColumn('body_fat');
            $table->dropColumn('arms');

            // Adicionando as novas colunas
            $table->decimal('biceps_contracted', 5, 2)->nullable()->after('waist');
            $table->decimal('biceps_relaxed', 5, 2)->nullable()->after('biceps_contracted');
            $table->integer('age')->nullable()->after('thighs');
            $table->string('sex')->nullable()->after('age');
            $table->decimal('pectorals', 5, 2)->nullable()->after('sex');
            $table->decimal('midaxillary', 5, 2)->nullable()->after('pectorals');
            $table->decimal('triceps', 5, 2)->nullable()->after('midaxillary');
            $table->decimal('subscapular', 5, 2)->nullable()->after('triceps');
            $table->decimal('abdominal', 5, 2)->nullable()->after('subscapular');
            $table->decimal('suprailiac', 5, 2)->nullable()->after('abdominal');
        });
    }

    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            // Revertendo as alterações (caso necessário)
            $table->decimal('body_fat', 4, 2)->nullable();
            $table->decimal('arms', 5, 2)->nullable();
            $table->dropColumn('biceps_contracted');
            $table->dropColumn('biceps_relaxed');
            $table->dropColumn('age');
            $table->dropColumn('sex');
            $table->dropColumn('pectorals');
            $table->dropColumn('midaxillary');
            $table->dropColumn('triceps');
            $table->dropColumn('subscapular');
            $table->dropColumn('abdominal');
            $table->dropColumn('suprailiac');
        });
    }
};
