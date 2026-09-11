<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class AdminProjectImageController extends Controller
{
    public function index(Project $project): View { return view('admin.projects.images', ['project'=>$project->load('projectImages')]); }
    public function store(Request $request, Project $project): RedirectResponse { $request->validate(['images'=>'required|array','images.*'=>'image|mimes:jpg,jpeg,png,webp|max:8192']); foreach($request->file('images') as $index=>$file) ProjectImage::create(['project_id'=>$project->id,'image_path'=>$file->store('projects/gallery','public'),'sort_order'=>$project->projectImages()->max('sort_order') + $index + 1]); return back()->with('success','Screenshots uploaded.'); }
    public function update(Request $request, Project $project, ProjectImage $projectImage): RedirectResponse { abort_unless($projectImage->project_id === $project->id,404); $projectImage->update($request->validate(['caption'=>'nullable|string|max:255','sort_order'=>'required|integer|min:0'])); return back()->with('success','Screenshot updated.'); }
    public function destroy(Project $project, ProjectImage $projectImage): RedirectResponse { abort_unless($projectImage->project_id === $project->id,404); Storage::disk('public')->delete($projectImage->image_path); $projectImage->delete(); return back()->with('success','Screenshot deleted.'); }
}
