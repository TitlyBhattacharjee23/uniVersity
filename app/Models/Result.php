<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Result extends Model
{
   protected $primaryKey = 'result_id';
   protected $fillable = ['enrollment_id', 'course_id', 'marks', 'grade', 'remarks'];


   public function enrollment()
   {
       return $this->belongsTo(Enrollment::class, 'enrollment_id');
   }


   public function course()
   {
       return $this->belongsTo(AcademicCourse::class, 'course_id');
   }



}
