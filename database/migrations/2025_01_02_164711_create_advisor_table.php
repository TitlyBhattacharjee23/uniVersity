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
        Schema::create('advisor', function (Blueprint $table) {
            $table->id('advisor_id'); // Primary key
            $table->unsignedBigInteger('student_id'); // Foreign key for students
            $table->foreign('student_id') // Foreign key constraint
                ->references('student_id') // References 'student_id' in 'students' table
                ->on('students') // Parent table
                ->onDelete('cascade'); // Cascade on delete

            $table->unsignedBigInteger('teacher_id'); // Foreign key for courses
            $table->foreign('teacher_id') // Foreign key constraint
                ->references('teacher_id') // References 'course_id' in 'courses' table
                ->on('teacher') // Parent table
                ->onDelete('cascade'); // Cascade on delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisor');
    }
};
