<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'lessons';
    protected $guarded = [];


    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function attachments(){
        return $this->hasMany('App\Models\Lesson_attachment');
    }
}
