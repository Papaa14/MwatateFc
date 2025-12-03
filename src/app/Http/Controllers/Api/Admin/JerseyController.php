<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

use App\Models\Jersey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JerseyController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Jersey::latest()->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Store in storage/app/public/jerseys
            $path = $request->file('image')->store('jerseys', 'public');

            $jersey = Jersey::create([
                'image_path' => $path,
                'price' => $request->price,
            ]);

            return response()->json(['message' => 'Jersey created', 'data' => $jersey], 201);
        }

        return response()->json(['message' => 'Image upload failed'], 400);
    }

    public function update(Request $request, $id)
    {
        $jersey = Jersey::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $data = ['price' => $request->price];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($jersey->image_path && Storage::disk('public')->exists($jersey->image_path)) {
                Storage::disk('public')->delete($jersey->image_path);
            }
            // Store new image
            $data['image_path'] = $request->file('image')->store('jerseys', 'public');
        }

        $jersey->update($data);

        return response()->json(['message' => 'Jersey updated', 'data' => $jersey]);
    }

    public function destroy($id)
    {
        $jersey = Jersey::findOrFail($id);

        // Delete image file
        if ($jersey->image_path && Storage::disk('public')->exists($jersey->image_path)) {
            Storage::disk('public')->delete($jersey->image_path);
        }

        $jersey->delete();

        return response()->json(['message' => 'Jersey deleted']);
    }
}
