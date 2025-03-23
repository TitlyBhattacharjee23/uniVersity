<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;




class AcademicCourse extends Model
{
   protected $primaryKey = 'course_id';


   protected $fillable = [
       'name',
       'code',
       'credit',
       'semester_id',
       'teacher_id'
   ];


   public function semester()
   {
       return $this->belongsTo(AcademicSemester::class, 'semester_id');
   }


   public function teacher()
   {
       return $this->belongsTo(Teacher::class, 'teacher_id');
   }
}
