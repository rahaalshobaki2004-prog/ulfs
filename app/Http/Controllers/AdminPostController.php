<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller//عرض الاعلانات والموافقة عليها رفضها وحذفها جزء من لوحة تحكم الادمن
{

public function __construct()
    {
        $this->middleware(['auth', 'admin']);//لازم اكون مسجلة دخول يمنع اي  شخص غير مسجل دخول
    }

    public function index()
    {
        $posts = Post::with('user')//بجيب الاعللانات مع صاحب الاعلان
            ->latest()//ترتيب الاعلانات من الاحد للاقدم
            ->paginate(5);//عرض 5 اعلانات ففقط في كل صفحة

        return view('admin.posts.index', compact('posts'));//يرسل البيانات الى واجهة اللادمن
    }


        public function approve(Post $post)//الموافقة على المنشور
    {
        $post->update([//حالة البوست
            'status' => 'approved',
            'approved_by' => Auth::user()->id,//تخزين رقم الادمن  الي وافق عليه
            'approved_at' => now(),//تسجيل وقت الموفقة
        ]);

        return back()->with('success', 'تم تفعيل الإعلان بنجاح');
    }

    public function reject(Post $post)//رفض البوست
    {
        $post->update([//
            'status' => 'rejected',
            'approved_by' => Auth::user()->id,
        ]);

        return back()->with('success', 'تم رفض الإعلان');
    }



    public function destroy(Post $post)//حذف البوست من الداتا
{
    $post->delete();
    return back()->with('success', 'تم حذف الإعلان بنجاح');
}


}
//ليش الحذف للادمن بس ؟ مشان يحافظ على النظام وما يلعب بالبيانات
