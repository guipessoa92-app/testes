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
        Schema::table('measurements', function (Blueprint $table) {
            // Removendo a coluna de altura, como você solicitou
            if (Schema::hasColumn('measurements', 'height')) {
                $table->dropColumn('height');
            }

            // Removendo colunas genéricas que serão substituídas por específicas
            if (Schema::hasColumn('measurements', 'shoulders')) {
                $table->dropColumn('shoulders');
            }
            if (Schema::hasColumn('measurements', 'chest')) {
                $table->dropColumn('chest');
            }
            if (Schema::hasColumn('measurements', 'biceps_right_contracted')) {
                $table->dropColumn('biceps_right_contracted');
            }
            if (Schema::hasColumn('measurements', 'biceps_right_relaxed')) {
                $table->dropColumn('biceps_right_relaxed');
            }
            if (Schema::hasColumn('measurements', 'biceps_left_contracted')) {
                $table->dropColumn('biceps_left_contracted');
            }
            if (Schema::hasColumn('measurements', 'biceps_left_relaxed')) {
                $table->dropColumn('biceps_left_relaxed');
            }
            if (Schema::hasColumn('measurements', 'forearm_right')) {
                $table->dropColumn('forearm_right');
            }
            if (Schema::hasColumn('measurements', 'forearm_left')) {
                $table->dropColumn('forearm_left');
            }
            if (Schema::hasColumn('measurements', 'abdomen')) {
                $table->dropColumn('abdomen');
            }
            if (Schema::hasColumn('measurements', 'gluteos')) {
                $table->dropColumn('gluteos');
            }
            if (Schema::hasColumn('measurements', 'thigh_right')) {
                $table->dropColumn('thigh_right');
            }
            if (Schema::hasColumn('measurements', 'thigh_left')) {
                $table->dropColumn('thigh_left');
            }
            if (Schema::hasColumn('measurements', 'calf_right')) {
                $table->dropColumn('calf_right');
            }
            if (Schema::hasColumn('measurements', 'calf_left')) {
                $table->dropColumn('calf_left');
            }

            // Adicionando as novas colunas detalhadas
            $table->decimal('shoulders', 5, 2)->nullable()->after('weight');
            $table->decimal('chest', 5, 2)->nullable()->after('shoulders');
            $table->decimal('biceps_right_contracted', 5, 2)->nullable()->after('chest');
            $table->decimal('biceps_right_relaxed', 5, 2)->nullable()->after('biceps_right_contracted');
            $table->decimal('biceps_left_contracted', 5, 2)->nullable()->after('biceps_right_relaxed');
            $table->decimal('biceps_left_relaxed', 5, 2)->nullable()->after('biceps_left_contracted');
            $table->decimal('forearm_right', 5, 2)->nullable()->after('biceps_left_relaxed');
            $table->decimal('forearm_left', 5, 2)->nullable()->after('forearm_right');
            $table->decimal('abdomen', 5, 2)->nullable()->after('waist');
            $table->decimal('gluteos', 5, 2)->nullable()->after('hips');
            $table->decimal('thigh_right', 5, 2)->nullable()->after('gluteos');
            $table->decimal('thigh_left', 5, 2)->nullable()->after('thigh_right');
            $table->decimal('calf_right', 5, 2)->nullable()->after('thigh_left');
            $table->decimal('calf_left', 5, 2)->nullable()->after('calf_right');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            // Remover novas colunas
            $table->dropColumn([
                'shoulders',
                'chest',
                'biceps_right_contracted',
                'biceps_right_relaxed',
                'biceps_left_contracted',
                'biceps_left_relaxed',
                'forearm_right',
                'forearm_left',
                'abdomen',
                'gluteos',
                'thigh_right',
                'thigh_left',
                'calf_right',
                'calf_left',
            ]);

            // Re-adicionar colunas antigas que foram removidas no up()
            if (!Schema::hasColumn('measurements', 'height')) {
                $table->decimal('height', 5, 2)->nullable();
            }
            // Note: The original migration dropped 'shoulders', 'chest', etc. and then re-added them.
            // In the down method, we only drop the ones added by this migration.
            // The previous state of 'shoulders', 'chest' etc. would be handled by earlier migrations.
        });
    }
};