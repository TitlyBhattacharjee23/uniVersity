<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class AcademicCourse extends Model
{
   protected $primaryKey = 'course_id';


   protected $fillable = [
       'name',
       'code',
       'semester_id',
       'teacher_id'
   ];


   public function semester()
   {
       return $this->belongsTo(Semester::class, 'semester_id');
   }


   public function teacher()
   {
       return $this->belongsTo(Teacher::class, 'teacher_id');
   }
}

