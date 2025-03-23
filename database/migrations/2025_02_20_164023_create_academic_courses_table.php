<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up(): void
   {
       Schema::create('academic_courses', function (Blueprint $table) {
           $table->id('course_id');
           $table->string('name');
           $table->string('code')->unique();
           $table->decimal('credit', 3, places: 1)->default(3.0);
           $table->foreignId('semester_id')->constrained('academic_semesters', 'semester_id');
           $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id');
           $table->timestamps();
       });
   }


   public function down(): void
   {
       Schema::dropIfExists('academic_courses');
   }
};
