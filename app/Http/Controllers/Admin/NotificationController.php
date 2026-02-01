<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi dengan cursor pagination
     */
    public function index(): View
    {
        $notifications = auth()->user()
                            ->notifications()
                            ->cursorPaginate($this->getPerPage()) // Pakai cursorPaginate biar kenceng bro!
                            ->withQueryString();
        
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all unread notifications as read for the current employee.
     */
    public function markAllAsRead()
    {
        $user = auth()->guard('employee')->user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return back()->with('success', 'All notifications have been successfully marked as read.');
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy($id)
    {
        $user = auth()->guard('employee')->user();
        
        // Pastikan hanya menghapus notifikasi milik user yang sedang login
        $user->notifications()->where('id', $id)->delete();

        return to_route('admin.notifications.index')
                ->with('success', 'Notification has been successfully deleted.');
    }

    /**
     * Remove all notifications for the current user.
     */
    public function deleteAll()
    {
        $user = auth()->guard('employee')->user();
        
        $user->notifications()->delete();

        return to_route('admin.notifications.index')
                ->with('success', 'All notifications have been cleared.');
    }
}