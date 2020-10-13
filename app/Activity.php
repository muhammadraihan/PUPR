<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity_log';
    protected $fillable = ['*'];


   public function getUser(){
       return $this->belongsTo(User::class,'causer_id','id');
   }

   public function getSubject(){
       return $this->belongsTo(User::class,'subject_id','id');
   }
}
