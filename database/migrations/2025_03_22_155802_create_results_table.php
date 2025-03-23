<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up()
   {
       Schema::create('results', function (Blueprint $table) {
           $table->id('result_id');
           $table->foreignId('enrollment_id')->constrained('enrollments', 'enrollment_id');
           $table->foreignId('course_id')->constrained('academic_courses', 'course_id');
           $table->decimal('marks', 5, 2)->nullable();
           $table->string('grade', 2)->nullable();
           $table->string('remarks')->nullable();
           $table->timestamps();
       });
   }


   public function down()
   {
       Schema::dropIfExists('results');
   }
};
