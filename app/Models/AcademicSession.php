<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class AcademicSession extends Model
{
   protected $primaryKey = 'session_id';


   protected $fillable = [
       'name',
       'start_date',
       'end_date'
   ];


   protected $dates = [
       'start_date',
       'end_date'
   ];
}
