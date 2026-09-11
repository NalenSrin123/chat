<?php
namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
class AdminBlogController extends Controller
{
    public function index(Request $request): View { $query=Blog::with('categories'); $query->when($request->filled('q'),fn($q)=>$q->where('title','like','%'.$request->string('q').'%')); $query->when($request->filled('status'),fn($q)=>$q->where('status',$request->string('status'))); $query->when($request->filled('category'),fn($q)=>$q->whereHas('categories',fn($c)=>$c->whereKey($request->integer('category')))); $query->orderBy('created_at',$request->get('sort')==='oldest'?'asc':'desc'); $perPage=in_array($request->integer('per_page'),[10,20,50],true)?$request->integer('per_page'):10; return view('admin.blog.index',['blogs'=>$query->paginate($perPage)->withQueryString(),'categories'=>BlogCategory::orderBy('name')->get()]); }
    public function create(): View { return view('admin.blog.form',['blog'=>new Blog(),'categories'=>BlogCategory::orderBy('name')->get(),'action'=>route('admin.blog.store')]); }
    public function store(Request $request): RedirectResponse { $data=$this->data($request); $data['user_id']=auth()->id(); $blog=Blog::create($data); $blog->categories()->sync($request->input('category_ids',[])); return redirect()->route('admin.blog.index')->with('success','Blog post created.'); }
    public function edit(Blog $blog): View { $blog->load('categories'); return view('admin.blog.form',['blog'=>$blog,'categories'=>BlogCategory::orderBy('name')->get(),'action'=>route('admin.blog.update',$blog)]); }
    public function update(Request $request, Blog $blog): RedirectResponse { $blog->update($this->data($request,$blog)); $blog->categories()->sync($request->input('category_ids',[])); return redirect()->route('admin.blog.index')->with('success','Blog post updated.'); }
    public function destroy(Blog $blog): RedirectResponse { if($blog->cover_image)Storage::disk('public')->delete($blog->cover_image); $blog->delete(); return back()->with('success','Blog post deleted.'); }
    private function data(Request $request, ?Blog $blog=null): array { $data=$request->validate(['title'=>'required|string|max:190','slug'=>'nullable|string|max:220|alpha_dash|unique:blogs,slug,'.($blog?->id ?? 'NULL'),'excerpt'=>'nullable|string|max:1000','content'=>'required|string','cover_image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120','status'=>'required|in:draft,published','published_at'=>'nullable|date']); $data['slug']=Str::slug($data['slug'] ?: $data['title']); if($data['status']==='published' && empty($data['published_at']))$data['published_at']=now(); if($request->hasFile('cover_image')){if($blog?->cover_image)Storage::disk('public')->delete($blog->cover_image);$data['cover_image']=$request->file('cover_image')->store('blog','public');}else unset($data['cover_image']); return $data; }
}
