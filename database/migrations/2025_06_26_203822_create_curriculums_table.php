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
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('major'); // e.g., 'Web Technology Track', 'Network Security Track'
            $table->string('subject_code'); // e.g., 'CS101', 'MATH201'
            $table->string('subject_name'); // e.g., 'Introduction to Programming'
            $table->integer('year'); // 1, 2, 3, 4
            $table->integer('trimester')->nullable(); // 1, 2, 3 (NULL for 4th year)
            $table->integer('units'); // credit units
            $table->string('prerequisite')->nullable(); // prerequisite subject codes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};
