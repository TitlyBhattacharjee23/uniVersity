<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up(): void
   {
       Schema::create('academic_sessions', function (Blueprint $table) {
           $table->id('session_id');
           $table->string('name');
           $table->date('start_date');
           $table->date('end_date');
           $table->timestamps();
       });
   }


   public function down(): void
   {
       Schema::dropIfExists('academic_sessions');
   }
};

