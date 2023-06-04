<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_Reply_Like extends Model
{
    use HasFactory;
    protected $table = 'comment_reply_likes';
    protected $guarded = [];
}
