<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Setting;
use App\Models\SkillCategory;
use App\Models\Testimonial;
use App\Models\Technology;
use App\Http\Requests\StoreContactMessageRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    private function shared(): array
    {
        if (!Schema::hasTable('profiles')) {
            return ['profile' => null, 'settings' => collect(), 'socialLinks' => collect()];
        }
        $profile = Profile::with('user', 'socialLinks')->first();
        return [
            'profile' => $profile,
            'settings' => Setting::pluck('value', 'key'),
            'socialLinks' => $profile?->socialLinks?->sortBy('sort_order') ?? collect(),
        ];
    }

    public function home(): View
    {
        $data = $this->shared();
        if (!Schema::hasTable('projects')) {
            return view('portfolio.empty', $data);
        }
        $data['projects'] = Project::with('technologies')->where('status', 'published')->where('featured', true)->latest()->take(3)->get();
        $data['blogs'] = Blog::with('categories')->where('status', 'published')->whereNotNull('published_at')->latest('published_at')->take(3)->get();
        $data['experiences'] = Experience::latest('start_date')->take(2)->get();
        $data['testimonials'] = Testimonial::where('is_approved', true)->orderBy('sort_order')->take(3)->get();
        $data['projectCount'] = Project::where('status', 'published')->count();
        $data['technologyCount'] = Technology::count();
        $data['seoTitle'] = $data['profile']?->user?->name.' · Portfolio';
        return view('portfolio.home', $data);
    }

    public function page(string $page): View
    {
        abort_unless(in_array($page, ['about', 'skills', 'experience', 'education', 'certificates']), 404);
        $data = $this->shared();
        $data['categories'] = SkillCategory::with(['skills' => fn ($q) => $q->orderBy('sort_order')])->orderBy('sort_order')->get();
        $data['experiences'] = Experience::latest('start_date')->get();
        $data['educations'] = Education::latest('start_date')->get();
        $data['certificates'] = Certificate::latest('issue_date')->get();
        $data['seoTitle'] = ucfirst($page).' · '.($data['profile']?->user?->name ?? 'Portfolio');
        return view("portfolio.$page", $data);
    }

    public function projects(Request $request): View
    {
        $query = Project::with('technologies')->where('status', '!=', 'draft');
        $query->when($request->filled('search'), fn ($q) => $q->where(function ($inner) use ($request) { $inner->where('title', 'like', '%'.$request->string('search').'%')->orWhere('short_description', 'like', '%'.$request->string('search').'%'); }));
        $query->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'));
        $query->when($request->get('featured') === '1', fn ($q) => $q->where('featured', true));
        $query->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')));
        $query->when($request->filled('technology'), fn ($q) => $q->whereHas('technologies', fn ($t) => $t->where('name', $request->string('technology'))));
        $projects = $query->latest()->paginate(9)->withQueryString();
        return view('portfolio.projects', array_merge($this->shared(), ['projects' => $projects, 'technologies' => Technology::orderBy('name')->get(), 'seoTitle' => 'Projects · Portfolio']));
    }

    public function project(Project $project): View
    {
        abort_unless($project->status === 'published', 404);
        $project->load('technologies', 'projectImages');
        return view('portfolio.project', array_merge($this->shared(), compact('project'), ['seoTitle' => $project->title, 'seoDescription' => $project->short_description]));
    }

    public function blog(Request $request): View
    {
        $query = Blog::with('categories')->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
        $query->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'));
        $query->when($request->filled('category'), fn ($q) => $q->whereHas('categories', fn ($c) => $c->where('slug', $request->string('category'))));
        return view('portfolio.blog', array_merge($this->shared(), [
            'blogs' => $query->latest('published_at')->paginate(6)->withQueryString(),
            'categories' => BlogCategory::orderBy('name')->get(), 'seoTitle' => 'Blog · Portfolio',
        ]));
    }

    public function post(Blog $blog): View
    {
        abort_unless($blog->status === 'published' && $blog->published_at && $blog->published_at->isPast(), 404);
        $blog->load('categories', 'user');
        $related = Blog::where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())->whereKeyNot($blog->id)->whereHas('categories', fn ($q) => $q->whereIn('blog_categories.id', $blog->categories->pluck('id')))->latest('published_at')->take(3)->get();
        return view('portfolio.post', array_merge($this->shared(), compact('blog', 'related'), ['seoTitle' => $blog->title, 'seoDescription' => $blog->excerpt]));
    }

    public function contact(): View
    { return view('portfolio.contact', $this->shared()); }

    public function sendContact(StoreContactMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['website']);
        ContactMessage::create($validated);
        return back()->with('success', 'Thanks for reaching out. I will get back to you soon.');
    }
}
