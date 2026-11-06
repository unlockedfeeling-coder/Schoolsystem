<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->text('teacher_remark')->nullable()->after('section_id');
            $table->text('principal_remark')->nullable()->after('teacher_remark');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['teacher_remark', 'principal_remark']);
        });
    }
};