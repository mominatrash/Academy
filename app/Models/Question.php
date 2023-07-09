<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz');
    }

}
