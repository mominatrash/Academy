<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->hasOne('App\Models\myQuiz')->where('user_id', Auth::guard('api')->user()->id);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

}
