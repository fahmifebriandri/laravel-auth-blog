<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

Route::match(['get', 'post'], '/', [Controllers\SiteController::class, 'index'])->name('welcome');
Route::get('/article/{article_title}', [Controllers\SiteController::class, 'showArticle'])->name('show-article');

Route::post('/member/register}', [Controllers\SiteController::class, 'memberRegister'])->name('member-register');
Route::post('/member/login', [Controllers\SiteController::class, 'memberLogin'])->name('member-login');
Route::get('/member/logout', [Controllers\SiteController::class, 'memberLogout'])->name('member-logout');
Route::post('/member/comment/send', [Controllers\SiteController::class, 'memberCommentSend'])->name('member-comment-send');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [Controllers\AuthController::class, 'register'])->name('register');
    Route::post('/register', [Controllers\AuthController::class, 'registerPost'])->name('register');
    Route::get('/login', [Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [Controllers\AuthController::class, 'loginPost'])->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('pages.welcome');
    })->name('home');
    Route::resource('article', ArticleController::class);
    Route::get('/comment/update-allow', [Controllers\CommentController::class, 'updateAllow'])->name('update-allow');
    Route::resource('comment', CommentController::class);
    Route::get('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
});