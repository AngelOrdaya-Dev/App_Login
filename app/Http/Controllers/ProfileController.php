<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it's a local file
            if ($user->avatar && !str_contains($user->avatar, 'googleusercontent')) {
                $oldPath = str_replace('/storage/', 'public/', $user->avatar);
                Storage::delete($oldPath);
            }

            $path = $request->file('avatar')->store('public/avatars');
            $data['avatar'] = Storage::url($path);
        }

        $user->update($data);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar && !str_contains($user->avatar, 'googleusercontent')) {
            $oldPath = str_replace('/storage/', 'public/', $user->avatar);
            Storage::delete($oldPath);
        }

        $user->update(['avatar' => null]);

        return back()->with('success', 'Foto de perfil eliminada.');
    }
}
