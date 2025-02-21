<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class AcademicSemester extends Model
{
   protected $primaryKey = 'semester_id';


   protected $fillable = [
       'name',
       'advisor_id'
   ];



   public function courses()
   {
       return $this->hasMany(AcademicCourse::class, 'semester_id');
   }


   public function advisor()
   {
       return $this->belongsTo(Teacher::class, 'advisor_id', 'teacher_id');
   }


   public function enrollments()
   {
       return $this->hasMany(Enrollment::class, 'semester_id', 'semester_id');
   }
}

