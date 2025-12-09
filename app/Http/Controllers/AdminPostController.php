<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{

public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(5);

        return view('admin.posts.index', compact('posts'));
    }


        public function approve(Post $post)
    {
        $post->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'تم تفعيل الإعلان بنجاح');
    }

    public function reject(Post $post)
    {
        $post->update([
            'status' => 'rejected',
            'approved_by' => Auth::user()->id,
        ]);

        return back()->with('success', 'تم رفض الإعلان');
    }



    public function destroy(Post $post)
{
    $post->delete();
    return back()->with('success', 'تم حذف الإعلان بنجاح');
}


}
