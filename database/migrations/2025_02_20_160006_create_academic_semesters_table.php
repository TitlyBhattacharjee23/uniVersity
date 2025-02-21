<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up(): void
   {
       Schema::create('academic_semesters', function (Blueprint $table) {
           $table->id('semester_id');
           $table->string('name');
           $table->foreignId('advisor_id')->constrained('teachers', 'teacher_id');
           $table->timestamps();
       });
   }


   public function down(): void
   {
       Schema::dropIfExists('academic_semesters');
   }
};
