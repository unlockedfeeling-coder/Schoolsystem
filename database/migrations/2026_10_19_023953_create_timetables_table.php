<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->string('day'); // Monday, Tuesday, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_level_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->string('room')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('timetables');
    }
};