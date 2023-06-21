<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDegree extends Model
{
    use HasFactory;
    protected $table = 'students_degrees';
    protected $guarded = [];

}
