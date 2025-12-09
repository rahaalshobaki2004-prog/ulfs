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

Auth::routes(['register' => true, 'reset' => true, 'verify' => false]);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [PostController::class, 'index'])->name('home');

// Posts للطلبة
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/my-messages', [UserMessageController::class, 'index'])->name('my.messages');
    Route::get('/my-posts', [MyPostController::class, 'index'])->name('my.posts');
    Route::get('/delete-posts/{post}', [MyPostController::class, 'destroy'])->name('myposts.destroy');

    // رسائل التواصل
Route::get('/posts/{post}', [MessageController::class, 'show'])->name('posts.show');
Route::post('/posts/{post}/message', [MessageController::class, 'store'])->name('messages.store');
Route::get('user-delete-message/{id}',[MessageController::class,'userDeleteMessage'])->name('userDeleteMessage');
});



// لوحة الإدارة (الأدمن بس)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::patch('/posts/{post}/approve', [AdminPostController::class, 'approve'])->name('posts.approve');
    Route::patch('/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('posts.reject');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}/messages', [AdminPostController::class, 'messages'])->name('posts.messages');
    Route::delete('/users/{user}', [DashboardController::class, 'destroyUser'])->name('users.destroy');
});
