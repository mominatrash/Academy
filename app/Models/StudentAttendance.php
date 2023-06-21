<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;
    protected $table = 'students_attendance';
    protected $guarded = [];

    public function lecture()
    {
        return $this->belongsTo('App\Models\Lecture');
    }

}
