<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    public function index()
    {
        return $this->sendResponse(Stadium::all(), 'Stadiums retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $stadium = Stadium::create($request->all());
        return $this->sendResponse($stadium, 'Stadium created successfully');
    }

    public function update(Request $request, $id)
    {
        $stadium = Stadium::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $stadium->update($request->all());
        return $this->sendResponse($stadium, 'Stadium updated successfully');
    }

    public function destroy($id)
    {
        Stadium::destroy($id);
        return $this->sendResponse(null, 'Stadium deleted successfully');
    }
}
