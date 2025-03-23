<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up(): void
   {
       Schema::create('enrollments', function (Blueprint $table) {
           $table->id('enrollment_id');
           $table->foreignId('student_id')->constrained('students', 'student_id');
           $table->foreignId('session_id')->constrained('academic_sessions', 'session_id');
           $table->foreignId('semester_id')->constrained('academic_semesters', 'semester_id');
           $table->boolean('requirements_checked')->default(false);
           $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
           $table->timestamps();
       });
   }


   public function down(): void
   {
       Schema::dropIfExists('enrollments');
   }
};
