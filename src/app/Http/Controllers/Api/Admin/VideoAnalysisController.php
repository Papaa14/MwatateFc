<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller;
use App\Models\VideoAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoAnalysisController extends Controller
{
    public function index() {
        return response()->json(['data' => VideoAnalysis::latest()->get()]);
    }

    public function show($id) {
        $video = VideoAnalysis::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }
        return response()->json(['data' => $video]);
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

    public function update(Request $request, $id) {
        $video = VideoAnalysis::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'sometimes|string',
            'video' => 'sometimes|file|mimetypes:video/mp4,video/avi|max:20480'
        ]);

        // Update title and description
        if ($request->filled('title')) {
            $video->title = $request->title;
        }
        if ($request->filled('description')) {
            $video->description = $request->description;
        }

        // Handle new video upload
        if ($request->hasFile('video')) {
            // Delete old video if it exists
            if ($video->video_path && Storage::disk('public')->exists($video->video_path)) {
                Storage::disk('public')->delete($video->video_path);
            }
            $path = $request->file('video')->store('videos', 'public');
            $video->video_path = $path;
        }

        $video->save();

        return response()->json(['message' => 'Video updated successfully', 'data' => $video]);
    }

    public function destroy($id) {
        $video = VideoAnalysis::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        // Delete video file from storage
        if ($video->video_path && Storage::disk('public')->exists($video->video_path)) {
            Storage::disk('public')->delete($video->video_path);
        }

        $video->delete();

        return response()->json(['message' => 'Video deleted successfully']);
    }
}
