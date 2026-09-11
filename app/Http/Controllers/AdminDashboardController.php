<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Blog;
use App\Models\Certificate;
use App\Models\ContactMessage;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'profile' => Profile::with('user')->where('user_id', auth()->id())->first(),
            'stats' => [
                ['label'=>'Total Projects','value'=>Project::count(),'route'=>route('admin.projects.index')],
                ['label'=>'Featured Projects','value'=>Project::where('featured',true)->count(),'route'=>route('admin.projects.index')],
                ['label'=>'Total Skills','value'=>Skill::count(),'route'=>route('admin.skills.index')],
                ['label'=>'Total Blog Posts','value'=>Blog::count(),'route'=>route('admin.blog.index')],
                ['label'=>'Published Posts','value'=>Blog::where('status','published')->count(),'route'=>route('admin.blog.index')],
                ['label'=>'Certificates','value'=>Certificate::count(),'route'=>route('admin.certificates.index')],
                ['label'=>'Contact Messages','value'=>ContactMessage::count(),'route'=>route('admin.messages.index')],
                ['label'=>'New Messages','value'=>ContactMessage::where('status','new')->count(),'route'=>route('admin.messages.index')],
            ],
            'messages' => ContactMessage::latest()->take(5)->get(),
            'projects' => Project::latest()->take(5)->get(),
            'blogs' => Blog::latest()->take(5)->get(),
        ]);
    }
}
