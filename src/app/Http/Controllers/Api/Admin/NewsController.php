<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        return $this->sendResponse(News::latest()->get(), 'News retrieved successfully');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'image' => 'nullable|image|max:2048',
            ]);

            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('news_images', 'public');
            }

            $news = News::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'image_path' => $path,
            ]);

            return $this->sendResponse($news, 'News created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create news: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'image' => 'nullable|image|max:2048',
            ]);

            $news = News::findOrFail($id);

            $updateData = [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ];

            if ($request->hasFile('image')) {
                if ($news->image_path)
                    Storage::disk('public')->delete($news->image_path);
                $updateData['image_path'] = $request->file('image')->store('news_images', 'public');
            }

            $news->update($updateData);

            return $this->sendResponse($news, 'News updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update news: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);
            if ($news->image_path)
                Storage::disk('public')->delete($news->image_path);
            $news->delete();

            return $this->sendResponse(null, 'News deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete news: ' . $e->getMessage());
        }
    }
}
