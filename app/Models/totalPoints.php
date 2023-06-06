<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class totalPoints extends Model
{
    use HasFactory;
    protected $table = 'replies';
    protected $guarded = [];
}
