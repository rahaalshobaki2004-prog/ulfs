<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()//يعرض صفحة التسجيل
    {
        return view('auth.login'); //يتحقق من التسجيل اذا دخل او لا فنكشن
    }



        public function login(Request $request)// بقدم طلب الي هو التسجيل بتأكد من الايميل والباس
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
                $credentials = $request->only('email', 'password');//اليوزر بدخل بيانات بتأكد من انه البيانات موجودة او لا  من الاساس

            if (Auth::attempt($credentials, $request->filled('remember'))){
                $request->session()->regenerate();//session:طريقة تخزين بيانات المستخدم مؤقتا اثناء تسجيل الدخول
                if (Auth::user()->role === 'admin') {
                    return redirect()->intended('/admin/dashboard');
                }

                return redirect()->intended('/');
            }

            return back()->withErrors(['email' => 'Invalid login details']);//لو كانت اصلا مش موجود بيانات وغلط
        }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();//رمز امان
        return redirect('/login');
    }
}
