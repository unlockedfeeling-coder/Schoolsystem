<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->integer('subject_position')->nullable()->after('position');
        });
    }

    public function down(): void {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->dropColumn('subject_position');
        });
    }
};