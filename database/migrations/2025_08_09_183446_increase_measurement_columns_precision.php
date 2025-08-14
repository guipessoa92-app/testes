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
            $columns = [
                'weight',
                'shoulders',
                'chest',
                'biceps_right_contracted',
                'biceps_right_relaxed',
                'biceps_left_contracted',
                'biceps_left_relaxed',
                'forearm_right',
                'forearm_left',
                'waist',
                'abdomen',
                'hips',
                'gluteos',
                'thigh_right',
                'thigh_left',
                'calf_right',
                'calf_left',
                'pectorals',
                'midaxillary',
                'triceps',
                'subscapular',
                'abdominal',
                'suprailiac',
            ];

            foreach ($columns as $column) {
                $table->decimal($column, 8, 2)->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            $columns = [
                'weight',
                'shoulders',
                'chest',
                'biceps_right_contracted',
                'biceps_right_relaxed',
                'biceps_left_contracted',
                'biceps_left_relaxed',
                'forearm_right',
                'forearm_left',
                'waist',
                'abdomen',
                'hips',
                'gluteos',
                'thigh_right',
                'thigh_left',
                'calf_right',
                'calf_left',
                'pectorals',
                'midaxillary',
                'triceps',
                'subscapular',
                'abdominal',
                'suprailiac',
            ];

            foreach ($columns as $column) {
                $table->decimal($column, 5, 2)->nullable()->change();
            }
        });
    }
};
