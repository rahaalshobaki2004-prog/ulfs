<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Message;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_posts'      => Post::count(),
            'pending_posts'    => Post::where('status', 'pending')->count(),
            'approved_posts'   => Post::where('status', 'approved')->count(),
            'rejected_posts'   => Post::where('status', 'rejected')->count(),
            'total_users'      => User::where('role', 'student')->count(),
            'total_messages'   => Message::count(),
        ];

        $pendingPosts = Post::with('user')->where('status', 'pending')->latest()->get();
        $recentPosts  = Post::with('user')->where('status', 'approved')->latest()->take(10)->get();
        $users        = User::where('role', 'student')->latest()->take(20)->get();

        return view('admin.dashboard', compact('stats', 'pendingPosts', 'recentPosts', 'users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'لا يمكن حذف حساب أدمن!');
        }
        $user->delete();
        return back()->with('success', 'تم حذف المستخدم بنجاح');
    }




}
