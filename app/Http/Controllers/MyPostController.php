<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;//بححدد مكان الكنترولر
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post ;
use Illuminate\Support\Facades\Storage;
class MyPostController extends Controller
{
    public function index()//عرض المنشورات
    {
        $posts = Auth::user()//بجيب الاعلانات الخاصة بالمستخدم
            ->posts()//علاقة ون تو مني
            ->withCount('messages') // عدد الرسائل لكل بوست
            ->latest()
            ->paginate(12);

        return view('my-posts', compact('posts'));

    }


    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('edit-post', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) { // بتأكد  ان اليوزر اللي مسجل دخول حاليا هو صاحب البوست
            abort(403);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:lost,found',
            'location'    => 'nullable|string|max:255',
            'contact_info'=> 'nullable|string|max:255',
            'image'       => 'nullable',
        ]);

        // التعامل مع الصورة إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($post->image) {
                Storage::delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        // إعادة تعيين الحالة لـ pending بعد التعديل (اختياري)
        $validated['status'] = 'pending';

        $post->update($validated);

        return redirect()->route('my.posts')
            ->with('success', 'تم تعديل الإعلان بنجاح، سيتم مراجعته من جديد');
    }

    public function destroy(Post $post)
{
    $post->delete();
    return back()->with('success', 'تم حذف الإعلان بنجاح');
}
}
