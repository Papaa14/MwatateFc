<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Fixture;
use App\Models\News;

class UploadController extends Controller
{
    public function addFixture(Request $request)
    {
        $request->validate([
            'home_team' => 'required|string|max:255',
            'away_team' => 'required|string|max:255',
            'match_date' => 'required|date',
            'venue' => 'required|string|max:255'
        ]);

        $fixture = Fixture::create([
            'home_team' => $request->home_team,
            'away_team' => $request->away_team,
            'match_date' => $request->match_date,
            'venue' => $request->venue
        ]);

        return $this->sendResponse($fixture, 'Fixture added successfully');
    }

    public function addVideo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'thumbnail' => 'nullable|string'
        ]);

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
            'thumbnail' => $request->thumbnail
        ]);

        return $this->sendResponse($video, 'Video added successfully');
    }

    public function addNews(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'featured_image' => 'nullable|string'
        ]);

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'featured_image' => $request->featured_image
        ]);

        return $this->sendResponse($news, 'News added successfully');
    }
}