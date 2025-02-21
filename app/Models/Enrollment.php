<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Enrollment extends Model
{
   protected $primaryKey = 'enrollment_id';


   protected $fillable = [
       'student_id',
       'session_id',
       'semester_id',

       'status'
   ];


   public function student()
   {
       return $this->belongsTo(Student::class, 'student_id');
   }


   public function session()
   {
       return $this->belongsTo(AcademicSession::class, 'session_id');
   }


   public function semester()
   {
       return $this->belongsTo(AcademicSemester::class, 'semester_id');
   }


   public function results()
   {
       return $this->hasMany(Result::class, 'enrollment_id', 'enrollment_id');
   }
}

