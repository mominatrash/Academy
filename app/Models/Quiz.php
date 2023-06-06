<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quizzes';
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }


    public function myquizzes()
    {
        return $this->hasOne('App\Models\myQuiz');
    }

}
