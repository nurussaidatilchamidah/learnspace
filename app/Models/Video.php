<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
        protected $fillable = ['lesson_id', 'video_path', 'original_filename', 'status'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
