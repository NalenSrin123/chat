<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
class AdminProjectController extends Controller
{
    public function index(Request $request): View { $query=Project::with('technologies'); $query->when($request->filled('q'),fn($q)=>$q->where('title','like','%'.$request->string('q').'%')); $query->when($request->filled('status'),fn($q)=>$q->where('status',$request->string('status'))); $query->when($request->has('featured') && $request->featured !== '',fn($q)=>$q->where('featured',(bool)$request->boolean('featured'))); $query->orderBy($request->get('sort')==='oldest'?'created_at':'created_at',$request->get('sort')==='oldest'?'asc':'desc'); $perPage=in_array($request->integer('per_page'),[10,20,50],true)?$request->integer('per_page'):10; return view('admin.projects.index',['projects'=>$query->paginate($perPage)->withQueryString()]); }
    public function create(): View { return view('admin.projects.form',['project'=>new Project(),'technologies'=>Technology::orderBy('name')->get(),'action'=>route('admin.projects.store')]); }
    public function store(Request $request): RedirectResponse { $data = $this->data($request); $data['user_id'] = auth()->id(); $project=Project::create($data); $project->technologies()->sync($request->input('technology_ids',[])); return redirect()->route('admin.projects.index')->with('success','Project created.'); }
    public function edit(Project $project): View { $project->load('technologies'); return view('admin.projects.form',['project'=>$project,'technologies'=>Technology::orderBy('name')->get(),'action'=>route('admin.projects.update',$project)]); }
    public function update(Request $request, Project $project): RedirectResponse { $project->update($this->data($request,$project)); $project->technologies()->sync($request->input('technology_ids',[])); return redirect()->route('admin.projects.index')->with('success','Project updated.'); }
    public function destroy(Project $project): RedirectResponse { if($project->cover_image) Storage::disk('public')->delete($project->cover_image); foreach($project->projectImages as $image) Storage::disk('public')->delete($image->image_path); $project->delete(); return back()->with('success','Project deleted.'); }
    private function data(Request $request, ?Project $project=null): array { $data=$request->validate(['title'=>'required|string|max:190','slug'=>'nullable|string|max:220|alpha_dash|unique:projects,slug,'.($project?->id ?? 'NULL'),'short_description'=>'required|string|max:500','description'=>'required|string','problem'=>'nullable|string','solution'=>'nullable|string','objectives'=>'nullable|string','responsibilities'=>'nullable|string','challenges'=>'nullable|string','architecture'=>'nullable|string','cover_image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120','github_url'=>'nullable|url|max:255','demo_url'=>'nullable|url|max:255','status'=>'required|in:draft,in_progress,completed,archived','featured'=>'nullable|boolean','started_at'=>'nullable|date','completed_at'=>'nullable|date']); $data['slug']=Str::slug($data['slug'] ?: $data['title']); $data['featured']=$request->boolean('featured'); if($request->hasFile('cover_image')) { if($project?->cover_image) Storage::disk('public')->delete($project->cover_image); $data['cover_image']=$request->file('cover_image')->store('projects','public'); } else unset($data['cover_image']); return $data; }
}
