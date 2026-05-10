<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;

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

        // Generar notificación si el usuario las tiene activadas
        if ($user->notifications_enabled) {
            Notification::create([
                'title' => 'Perfil Actualizado',
                'message' => 'Los datos de tu perfil han sido modificados exitosamente.',
                'type' => 'success'
            ]);
        }

        return redirect()->route('settings')->with('success', 'Perfil actualizado correctamente.');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar && !str_contains($user->avatar, 'googleusercontent')) {
            $oldPath = str_replace('/storage/', 'public/', $user->avatar);
            Storage::delete($oldPath);
        }

        $user->update(['avatar' => null]);

        return redirect()->route('settings')->with('success', 'Foto de perfil eliminada.');
    }

    public function updateSecurity(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'two_factor_enabled' => $request->has('two_factor_enabled')
        ]);

        if ($user->notifications_enabled) {
            Notification::create([
                'title' => 'Seguridad Actualizada',
                'message' => 'Tus preferencias de seguridad han sido actualizadas.',
                'type' => 'success'
            ]);
        }

        return redirect()->route('settings')->with('success', 'Configuración de seguridad actualizada.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        if ($user->notifications_enabled) {
            Notification::create([
                'title' => 'Seguridad Actualizada',
                'message' => 'Tu contraseña ha sido cambiada exitosamente.',
                'type' => 'success'
            ]);
        }

        return redirect()->route('settings')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function updateCareer(Request $request)
    {
        $request->validate([
            'career_id' => 'required|exists:careers,id',
        ]);

        $user = Auth::user();
        $user->update(['career_id' => $request->career_id]);

        $careerName = \App\Models\Career::find($request->career_id)->name;

        if ($user->notifications_enabled) {
            Notification::create([
                'title' => 'Carrera Asignada',
                'message' => "Te has inscrito exitosamente en la carrera de {$careerName}.",
                'type' => 'success'
            ]);
        }

        return back()->with('success', 'Carrera asignada correctamente.');
    }
}
