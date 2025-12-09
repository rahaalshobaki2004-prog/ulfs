<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function show(Post $post)
    {
        // تحقق من صلاحية الرؤية
        if ($post->status !== 'approved') {
            if (!Auth::check() || (Auth::id() !== $post->user_id && !Auth::user()?->isAdmin())) {
                abort(404);
            }
        }

        $post->load('user'); // جيب بيانات صاحب البوست

        return view('contact-user', compact('post'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'sender_name'    => 'required|string|max:100',
            'sender_contact' => 'required|string|max:255',
            'message'        => 'required|string|max:1000',
        ]);

        Message::create([
            'post_id'        => $post->id,
            'sender_name'    => $request->sender_name,
            'sender_contact' => $request->sender_contact,
            'message'        => $request->message,
        ]);

        return back()->with('success', 'تم إرسال رسالتك بنجاح !');
    }

    public function userDeleteMessage($id)
    {
        Message::where('id',$id)->delete();
        return back()->with('success','تم حذف الرسالة بنجاح !');
    }
}
