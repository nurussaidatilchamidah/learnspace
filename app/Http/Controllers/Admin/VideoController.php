<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request, Lesson $lesson)
    {
        $request->validate([
            'video' => ['required', 'file', 'mimetypes:video/mp4,video/quicktime,video/webm', 'max:512000'],
        ]);

        $file = $request->file('video');

        $video = $lesson->video ?? new Video(['lesson_id' => $lesson->id]);
        $video->deleteFile();
        $video->fill([
            'video_path' => null,
            'original_filename' => $file->getClientOriginalName(),
            'status' => 'uploading',
        ])->save();

        try {
            $path = $file->store('videos/'.$lesson->id, 'local');
            $video->update(['video_path' => $path, 'status' => 'ready']);
        } catch (\Throwable $e) {
            report($e);
            $video->update(['status' => 'failed']);

            return response()->json(['message' => 'Video gagal disimpan di server.'], 500);
        }

        return response()->json(['status' => 'ready', 'filename' => $video->original_filename]);
    }
}