<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
class MemberPortfolioController extends Controller {
 public function dashboard(): View { return view('member.dashboard',['user'=>auth()->user()->load('profile','projects')]); }
 public function profile(): View { return view('member.profile',['user'=>auth()->user()->load('profile')]); }
 public function updateProfile(Request $request): RedirectResponse { $data=$request->validate(['name'=>'required|string|max:120','username'=>['required','alpha_dash','max:40','unique:users,username,'.auth()->id()],'title'=>'required|string|max:190','bio'=>'required|string|max:2000','location'=>'nullable|string|max:190','website'=>'nullable|url|max:255']); auth()->user()->update(['name'=>$data['name'],'username'=>Str::lower($data['username'])]); auth()->user()->profile()->updateOrCreate([],collect($data)->except(['name','username'])->all()); return back()->with('success','Your portfolio profile was updated.'); }
 public function projects(): View { return view('member.projects',['projects'=>auth()->user()->projects()->latest()->paginate(10)]); }
 public function createProject(): View { return view('member.project-form',['project'=>new Project]); }
 public function storeProject(Request $request): RedirectResponse { $data=$request->validate(['title'=>'required|string|max:190','short_description'=>'required|string|max:500','description'=>'required|string','cover_image'=>'nullable|image|max:5120','github_url'=>'nullable|url','demo_url'=>'nullable|url']); $data['slug']=Str::slug($data['title']).'-'.Str::lower(Str::random(5)); $data['status']='completed'; if($request->hasFile('cover_image')) $data['cover_image']=$request->file('cover_image')->store('projects','public'); auth()->user()->projects()->create($data); return redirect()->route('member.projects')->with('success','Project published to your portfolio.'); }
 public function destroyProject(Project $project): RedirectResponse { abort_unless($project->user_id===auth()->id(),403); if($project->cover_image) Storage::disk('public')->delete($project->cover_image); $project->delete(); return back()->with('success','Project removed.'); }
 public function show(User $user): View { $user->load('profile.socialLinks','projects.technologies','experiences','educations','certificates'); abort_unless($user->profile,404); return view('member.public',compact('user')); }
}
