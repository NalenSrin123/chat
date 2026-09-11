<?php
namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([URL::to('/'), URL::to('/about'), URL::to('/skills'), URL::to('/experience'), URL::to('/education'), URL::to('/certificates'), URL::to('/projects'), URL::to('/blog'), URL::to('/contact')]);
        $projects = Project::whereIn('status', ['in_progress','completed'])->get(['slug','updated_at']);
        $blogs = Blog::where('status','published')->whereNotNull('published_at')->where('published_at','<=',now())->get(['slug','updated_at']);
        return response()->view('sitemap', compact('urls','projects','blogs'))->header('Content-Type','application/xml');
    }
}
