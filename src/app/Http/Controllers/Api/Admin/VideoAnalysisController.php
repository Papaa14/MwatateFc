<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller;
use App\Models\VideoAnalysis;
use Illuminate\Http\Request;

class VideoAnalysisController extends Controller
{
    public function index() {
        return response()->json(['data' => VideoAnalysis::latest()->get()]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required', 'video' => 'required|file|mimetypes:video/mp4,video/avi|max:20480'
        ]);

        $path = $request->file('video')->store('videos', 'public');

        $video = VideoAnalysis::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_path' => $path
        ]);
        return response()->json(['message' => 'Video uploaded', 'data' => $video]);
    }
}
