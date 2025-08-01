<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;

class RegisterController extends Controller
{
    public function Register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', new Enum(UserRole::class)]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->value
        ];

        return $this->sendResponse($userData, ucfirst($user->role->value) . ' registered successfully');
    }

    public function getUserCounts()
    {
        $counts = [
            'coaches' => User::where('role', UserRole::COACH)->count(),
            'players' => User::where('role', UserRole::PLAYER)->count(),
            'fans' => User::where('role', UserRole::FAN)->count()
        ];

        return $this->sendResponse($counts, 'User counts retrieved successfully');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return $this->sendError('User not found', [], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'role' => ['sometimes', new Enum(UserRole::class)]
        ]);

        $updateData = $request->only(['name', 'email', 'role']);
        
        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->value
        ];

        return $this->sendResponse($userData, 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return $this->sendError('User not found', [], 404);
        }

        $user->delete();

        return $this->sendResponse(null, 'User deleted successfully');
    }
}
