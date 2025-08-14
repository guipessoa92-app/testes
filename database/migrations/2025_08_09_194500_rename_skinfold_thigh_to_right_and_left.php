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
            $table->dropColumn('skinfold_thigh');
            $table->decimal('skinfold_thigh_right', 5, 2)->nullable()->after('suprailiac');
            $table->decimal('skinfold_thigh_left', 5, 2)->nullable()->after('skinfold_thigh_right');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            $table->dropColumn('skinfold_thigh_right');
            $table->dropColumn('skinfold_thigh_left');
            $table->decimal('skinfold_thigh', 5, 2)->nullable()->after('suprailiac');
        });
    }
};
