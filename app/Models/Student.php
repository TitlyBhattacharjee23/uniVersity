<?php


namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Student extends Authenticatable
{
   use Notifiable;


   protected $primaryKey = 'student_id';

   protected $fillable = [
       'name',
       'email',
       'password',
       'dob',
       'address'
   ];


   protected $hidden = [
       'password',
       'remember_token',
   ];
}

