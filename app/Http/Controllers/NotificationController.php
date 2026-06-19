<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'unread_count' => Notification::where('user_id', Auth::id())->where('is_read', false)->count()
        ]);
    }

    public function unread()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->latest()
            ->get();
            
        return response()->json([
            'unread_count' => $notifications->count(),
            'notifications' => $notifications
        ]);
    }

    public function toggleSettings(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'notifications_enabled' => $request->has('notifications_enabled') ? true : false
        ]);

        return redirect()->route('settings')->with('success', 'Preferencias de notificaciones actualizadas.');
    }
}
