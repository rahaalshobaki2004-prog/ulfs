<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    // الصفحة الرئيسية + فلاتر
    public function index(Request $request)
    {
        $type = $request->query('type'); // ?type=lost أو found أو all

        $posts = Post::approved()
            ->when($type && in_array($type, ['lost', 'found']), function ($q) use ($type) {
                return $q->where('type', $type);
            })
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('home', compact('posts'));
    }

    // صفحة إنشاء بوست
    public function create()
    {
        return view('create-post');
    }

    // حفظ البوست
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:lost,found',
            'location'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::user()->id;
        $data['status']  = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('home')->with('success', 'تم إرسال الإعلان للمراجعة، سيظهر قريبًا بعد موافقة الإدارة');
    }


}

