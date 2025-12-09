<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post ;
class MyPostController extends Controller
{
    public function index()
    {
        $posts = Auth::user()
            ->posts()
            ->withCount('messages') // عدد الرسايل لكل بوست
            ->latest()
            ->paginate(12);

        return view('my-posts', compact('posts'));
    }


    public function destroy(Post $post)
{
    $post->delete();
    return back()->with('success', 'تم حذف الإعلان بنجاح');
}
}
