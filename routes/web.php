<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Studentcontroller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserMessageController;
use App\Http\Controllers\MyPostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;

Auth::routes(['register' => true, 'reset' => true, 'verify' => false]);//فولس ما بحتاج لتأكيد الايميل رها
                                              //FUNCTION
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');//عرض صفحة سجيل الدخول
Route::post('/login', [AuthController::class, 'login']);//بوست يعني ابعث الداتا يستقبل ايميل وباسوورد
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');//تسجيل خروج
Route::get('/', [PostController::class, 'index'])->name('home');//index() → عرض المنشورات

// Posts للطلبة
Route::middleware('auth')->group(function () {//ما بقدر ادخل الا اذا كنت مسجلة
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');//عرض الصفحة
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');//بتخزن الصفحة
    Route::get('/my-messages', [UserMessageController::class, 'index'])->name('my.messages');//حلقة وصل بين الكنترول والفيو
    Route::get('/my-posts', [MyPostController::class, 'index'])->name('my.posts');//بعرض الصفحات
    // تعديل البوست (GET + POST/PATCH)
    Route::get('/my-posts/{post}/edit', [MyPostController::class, 'edit'])->name('my-posts.edit');
    Route::post('/my-posts/{post}', [MyPostController::class, 'update'])->name('my-posts.update');
    Route::get('/delete-posts/{post}', [MyPostController::class, 'destroy'])->name('myposts.destroy');//حذف للبوست
//الفرق بين ال
    // رسائل التواصل
Route::get('/posts/{post}', [MessageController::class, 'show'])->name('posts.show');//عرض المسجات الي ع البوست المعين
Route::post('/posts/{post}/message', [MessageController::class, 'store'])->name('messages.store');
Route::get('user-delete-message/{id}',[MessageController::class,'userDeleteMessage'])->name('userDeleteMessage');
});



// لوحة الإدارة (الأدمن بس)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {//تحقق من دحول الادمن
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::patch('/posts/{post}/approve', [AdminPostController::class, 'approve'])->name('posts.approve');
    Route::patch('/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('posts.reject');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('/users/{user}', [DashboardController::class, 'destroyUser'])->name('users.destroy');
});
//patch تعديل جزئي
//put تعديل كلي
