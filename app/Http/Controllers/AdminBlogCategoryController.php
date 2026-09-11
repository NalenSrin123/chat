<?php
namespace App\Http\Controllers;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class AdminBlogCategoryController extends Controller
{
    public function index(): View { return view('admin.blog-categories.index',['categories'=>BlogCategory::withCount('blogs')->orderBy('name')->paginate(10)]); }
    public function create(): View { return view('admin.blog-categories.form',['category'=>new BlogCategory(),'action'=>route('admin.blog-categories.store')]); }
    public function store(Request $request): RedirectResponse { BlogCategory::create($this->data($request)); return redirect()->route('admin.blog-categories.index')->with('success','Blog category created.'); }
    public function edit(BlogCategory $blogCategory): View { return view('admin.blog-categories.form',['category'=>$blogCategory,'action'=>route('admin.blog-categories.update',$blogCategory)]); }
    public function update(Request $request, BlogCategory $blogCategory): RedirectResponse { $blogCategory->update($this->data($request,$blogCategory)); return redirect()->route('admin.blog-categories.index')->with('success','Blog category updated.'); }
    public function destroy(BlogCategory $blogCategory): RedirectResponse { $blogCategory->blogs()->detach(); $blogCategory->delete(); return back()->with('success','Blog category deleted.'); }
    private function data(Request $request, ?BlogCategory $category=null): array { $data=$request->validate(['name'=>'required|string|max:100','slug'=>'nullable|string|max:120|alpha_dash|unique:blog_categories,slug,'.($category?->id ?? 'NULL'),'description'=>'nullable|string|max:1000']); $data['slug']=Str::slug($data['slug'] ?: $data['name']); return $data; }
}
