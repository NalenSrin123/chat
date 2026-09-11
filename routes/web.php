<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminPlaceholderController;
use App\Http\Controllers\AdminSocialLinkController;
use App\Http\Controllers\AdminSkillCategoryController;
use App\Http\Controllers\AdminSkillController;
use App\Http\Controllers\AdminTechnologyController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\AdminProjectImageController;
use App\Http\Controllers\AdminExperienceController;
use App\Http\Controllers\AdminEducationController;
use App\Http\Controllers\AdminCertificateController;
use App\Http\Controllers\AdminResumeController;
use App\Http\Controllers\AdminBlogCategoryController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\MemberPortfolioController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::controller(PortfolioController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'page')->defaults('page', 'about')->name('about');
    Route::get('/skills', 'page')->defaults('page', 'skills')->name('skills');
    Route::get('/experience', 'page')->defaults('page', 'experience')->name('experience');
    Route::get('/education', 'page')->defaults('page', 'education')->name('education');
    Route::get('/certificates', 'page')->defaults('page', 'certificates')->name('certificates');
    Route::get('/projects', 'projects')->name('projects');
    Route::get('/projects/{project:slug}', 'project')->name('projects.show');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog/{blog:slug}', 'post')->name('blog.show');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendContact')->middleware('throttle:contact')->name('contact.send');
});
Route::middleware('auth')->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::post('/conversations', [ChatController::class, 'start'])->name('start');
    Route::get('/users', [ChatController::class, 'users'])->name('users');
    Route::post('/conversations/{conversation}/messages', [ChatController::class, 'send'])->name('messages.send');
    Route::post('/conversations/{conversation}/read', [ChatController::class, 'read'])->name('read');
});
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::middleware('guest')->group(function () {
    Route::get('/register', [MemberAuthController::class, 'register'])->name('register');
    Route::post('/register', [MemberAuthController::class, 'store'])->name('register.store');
    Route::get('/login', [MemberAuthController::class, 'login'])->name('login');
    Route::post('/login', [MemberAuthController::class, 'authenticate'])->name('login.store');
});
Route::get('/portfolio/{user:username}', [MemberPortfolioController::class, 'show'])->name('portfolio.user');
Route::middleware(['auth', 'member'])->prefix('dashboard')->name('member.')->group(function () {
    Route::get('/', [MemberPortfolioController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MemberPortfolioController::class, 'profile'])->name('profile');
    Route::put('/profile', [MemberPortfolioController::class, 'updateProfile'])->name('profile.update');
    Route::get('/projects', [MemberPortfolioController::class, 'projects'])->name('projects');
    Route::get('/projects/create', [MemberPortfolioController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [MemberPortfolioController::class, 'storeProject'])->name('projects.store');
    Route::delete('/projects/{project}', [MemberPortfolioController::class, 'destroyProject'])->name('projects.destroy');
    Route::post('/logout', [MemberAuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'store'])->middleware('throttle:admin-login')->name('admin.login.store');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::resource('social-links', AdminSocialLinkController::class)->except('show')->names('social-links');
    Route::resource('skill-categories', AdminSkillCategoryController::class)->except('show')->names('skill-categories');
    Route::resource('skills', AdminSkillController::class)->except('show');
    Route::resource('technologies', AdminTechnologyController::class)->except('show');
    Route::resource('projects', AdminProjectController::class)->except('show');
    Route::resource('experience', AdminExperienceController::class)->except('show')->names('experience');
    Route::resource('education', AdminEducationController::class)->except('show')->names('education');
    Route::resource('certificates', AdminCertificateController::class)->except('show');
    Route::resource('blog-categories', AdminBlogCategoryController::class)->except('show')->names('blog-categories');
    Route::resource('blog', AdminBlogController::class)->except('show');
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::patch('/messages/{message}/status', [AdminMessageController::class, 'status'])->name('messages.status');
    Route::post('/messages/{message}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/resume', [AdminResumeController::class, 'edit'])->name('resume.edit');
    Route::post('/resume', [AdminResumeController::class, 'update'])->name('resume.update');
    Route::delete('/resume', [AdminResumeController::class, 'destroy'])->name('resume.destroy');
    Route::resource('testimonials', AdminTestimonialController::class)->except('show');
    Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::get('/projects/{project}/images', [AdminProjectImageController::class, 'index'])->name('projects.images.index');
    Route::post('/projects/{project}/images', [AdminProjectImageController::class, 'store'])->name('projects.images.store');
    Route::put('/projects/{project}/images/{projectImage}', [AdminProjectImageController::class, 'update'])->name('projects.images.update');
    Route::delete('/projects/{project}/images/{projectImage}', [AdminProjectImageController::class, 'destroy'])->name('projects.images.destroy');
    Route::get('/{module}', AdminPlaceholderController::class)->name('module');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});
