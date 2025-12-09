<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Auth::user()
            ->messages()
            ->with('post') // جيب عنوان الإعلان
            ->latest()
            ->paginate(15);

        return view('my-messages', compact('messages'));
    }
}
