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
        Schema::create('result', function (Blueprint $table) {
            $table->id('result_id'); // Primary key
            $table->unsignedBigInteger('student_id'); // Foreign key for students
            $table->foreign('student_id') // Foreign key constraint
                ->references('student_id') // References 'student_id' in 'students' table
                ->on('students') // Parent table
                ->onDelete('cascade'); // Cascade on delete

            $table->unsignedBigInteger('course_id'); // Foreign key for courses
            $table->foreign('course_id') // Foreign key constraint
                ->references('course_id') // References 'course_id' in 'courses' table
                ->on('course') // Parent table
                ->onDelete('cascade'); // Cascade on delete

            $table->float('cgpa'); // Enrollment date
            $table->string('grade'); // Status
            $table->timestamps(); // Timestamps

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result');
    }
};
