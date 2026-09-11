<?php
namespace App\Http\Controllers;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class AdminExperienceController extends Controller
{
    public function index(): View { return view('admin.experience.index',['experiences'=>Experience::orderBy('sort_order')->orderByDesc('start_date')->paginate(10)]); }
    public function create(): View { return view('admin.experience.form',['experience'=>new Experience(),'action'=>route('admin.experience.store')]); }
    public function store(Request $request): RedirectResponse { $data = $this->data($request); $data['user_id'] = auth()->id(); Experience::create($data); return redirect()->route('admin.experience.index')->with('success','Experience added.'); }
    public function edit(Experience $experience): View { return view('admin.experience.form',['experience'=>$experience,'action'=>route('admin.experience.update',$experience)]); }
    public function update(Request $request, Experience $experience): RedirectResponse { $experience->update($this->data($request)); return redirect()->route('admin.experience.index')->with('success','Experience updated.'); }
    public function destroy(Experience $experience): RedirectResponse { $experience->delete(); return back()->with('success','Experience deleted.'); }
    private function data(Request $request): array { $data=$request->validate(['company'=>'required|string|max:190','position'=>'required|string|max:190','location'=>'nullable|string|max:190','start_date'=>'required|date','end_date'=>'nullable|date|after_or_equal:start_date','is_current'=>'nullable|boolean','description'=>'required|string','responsibilities'=>'nullable|string','sort_order'=>'required|integer|min:0']); $data['is_current']=$request->boolean('is_current'); if($data['is_current'])$data['end_date']=null; return $data; }
}
