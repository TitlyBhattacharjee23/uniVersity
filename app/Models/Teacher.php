<?php


namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Teacher extends Authenticatable
{
   use Notifiable;


   protected $primaryKey = 'teacher_id';

   protected $fillable = [
       'name',
       'email',
       'password',
   ];


   protected $hidden = [
       'password',
       'remember_token',
   ];


   public function advisedSemesters()
   {
       return $this->hasMany(AcademicSemester::class, 'advisor_id', 'teacher_id');
   }


   public function courses()
   {
       return $this->hasMany(AcademicCourse::class, 'teacher_id', 'teacher_id');
   }
}

