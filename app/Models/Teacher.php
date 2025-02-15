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
}
