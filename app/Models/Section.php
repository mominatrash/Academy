<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $guarded = [];

    public function lessons(){
        return $this->hasMany('App\Models\Lesson');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
