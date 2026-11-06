<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->integer('class_score')->default(0)->after('marks');
            $table->integer('exam_score')->default(0)->after('class_score');
            $table->integer('total_score')->default(0)->after('exam_score');
            $table->integer('position')->nullable()->after('total_score');
        });
    }

    public function down(): void {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->dropColumn(['class_score', 'exam_score', 'total_score', 'position']);
        });
    }
};