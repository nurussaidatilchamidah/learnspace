<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    protected $fillable = ['lesson_id', 'video_path', 'original_filename', 'status'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function deleteFile(): void
    {
        if ($this->video_path) {
            Storage::disk('local')->delete($this->video_path);
        }
    }
}