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
            // Remover colunas antigas se existirem
            if (Schema::hasColumn('measurements', 'height')) {
                $table->dropColumn('height');
            }
            if (Schema::hasColumn('measurements', 'thighs')) {
                $table->dropColumn('thighs');
            }
            if (Schema::hasColumn('measurements', 'biceps_contracted')) {
                $table->dropColumn('biceps_contracted');
            }
            if (Schema::hasColumn('measurements', 'biceps_relaxed')) {
                $table->dropColumn('biceps_relaxed');
            }
            if (Schema::hasColumn('measurements', 'arms')) {
                $table->dropColumn('arms');
            }

            // Adicionar novas colunas se não existirem
            if (! Schema::hasColumn('measurements', 'shoulders')) {
                $table->decimal('shoulders', 5, 2)->nullable()->after('weight');
            }
            if (! Schema::hasColumn('measurements', 'chest')) {
                $table->decimal('chest', 5, 2)->nullable()->after('shoulders');
            }
            if (! Schema::hasColumn('measurements', 'biceps_right_contracted')) {
                $table->decimal('biceps_right_contracted', 5, 2)->nullable()->after('chest');
            }
            if (! Schema::hasColumn('measurements', 'biceps_right_relaxed')) {
                $table->decimal('biceps_right_relaxed', 5, 2)->nullable()->after('biceps_right_contracted');
            }
            if (! Schema::hasColumn('measurements', 'biceps_left_contracted')) {
                $table->decimal('biceps_left_contracted', 5, 2)->nullable()->after('biceps_right_relaxed');
            }
            if (! Schema::hasColumn('measurements', 'biceps_left_relaxed')) {
                $table->decimal('biceps_left_relaxed', 5, 2)->nullable()->after('biceps_left_contracted');
            }
            if (! Schema::hasColumn('measurements', 'forearm_right')) {
                $table->decimal('forearm_right', 5, 2)->nullable()->after('biceps_left_relaxed');
            }
            if (! Schema::hasColumn('measurements', 'forearm_left')) {
                $table->decimal('forearm_left', 5, 2)->nullable()->after('forearm_right');
            }
            if (! Schema::hasColumn('measurements', 'abdomen')) {
                $table->decimal('abdomen', 5, 2)->nullable()->after('waist');
            }
            if (! Schema::hasColumn('measurements', 'gluteos')) {
                $table->decimal('gluteos', 5, 2)->nullable()->after('hips');
            }
            if (! Schema::hasColumn('measurements', 'thigh_right')) {
                $table->decimal('thigh_right', 5, 2)->nullable()->after('gluteos');
            }
            if (! Schema::hasColumn('measurements', 'thigh_left')) {
                $table->decimal('thigh_left', 5, 2)->nullable()->after('thigh_right');
            }
            if (! Schema::hasColumn('measurements', 'calf_right')) {
                $table->decimal('calf_right', 5, 2)->nullable()->after('thigh_left');
            }
            if (! Schema::hasColumn('measurements', 'calf_left')) {
                $table->decimal('calf_left', 5, 2)->nullable()->after('calf_right');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            // Adicionar colunas antigas de volta
            if (! Schema::hasColumn('measurements', 'height')) {
                $table->decimal('height', 5, 2)->nullable();
            }
            if (! Schema::hasColumn('measurements', 'thighs')) {
                $table->decimal('thighs', 5, 2)->nullable();
            }
            if (! Schema::hasColumn('measurements', 'biceps_contracted')) {
                $table->decimal('biceps_contracted', 5, 2)->nullable();
            }
            if (! Schema::hasColumn('measurements', 'biceps_relaxed')) {
                $table->decimal('biceps_relaxed', 5, 2)->nullable();
            }
            if (! Schema::hasColumn('measurements', 'arms')) {
                $table->decimal('arms', 5, 2)->nullable();
            }

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
        });
    }
};
