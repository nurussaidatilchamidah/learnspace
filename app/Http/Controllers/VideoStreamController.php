<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoStreamController extends Controller
{
    public function __invoke(Video $video)
    {
        $video->load('lesson.course');

        if (! auth()->user()->isAdmin()) {
            abort_unless(
                $video->status === 'ready' && $video->lesson->course->status === 'published',
                403
            );
        }

        $disk = Storage::disk('local');
        abort_unless($video->video_path && $disk->exists($video->video_path), 404);

        return response()->file($disk->path($video->video_path), [
            'Content-Type' => $disk->mimeType($video->video_path),
        ]);
    }
}