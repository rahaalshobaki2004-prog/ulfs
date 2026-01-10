<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');//ما بشتغل الا اذا كنت  مسجلة دخول
    }

    public function index()
    {
        $messages = Auth::user()
            ->messages()
            ->with('post') // جيب عنوان الإعلان
            ->latest()
            ->paginate(15); //يعرض بالصفحة 15 رسالو

        return view('my-messages', compact('messages'));
    }
}
