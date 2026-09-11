<?php
namespace App\Http\Controllers;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class AdminTechnologyController extends Controller
{
    public function index(Request $request): View { $query = Technology::withCount('projects')->orderBy('name'); $query->when($request->filled('q'), fn ($q) => $q->where('name','like','%'.$request->string('q').'%')); $perPage = in_array($request->integer('per_page'),[10,20,50],true) ? $request->integer('per_page') : 10; return view('admin.technologies.index',['technologies'=>$query->paginate($perPage)->withQueryString()]); }
    public function create(): View { return view('admin.technologies.form',['technology'=>new Technology(),'action'=>route('admin.technologies.store')]); }
    public function store(Request $request): RedirectResponse { Technology::create($this->data($request)); return redirect()->route('admin.technologies.index')->with('success','Technology created.'); }
    public function edit(Technology $technology): View { return view('admin.technologies.form',['technology'=>$technology,'action'=>route('admin.technologies.update',$technology)]); }
    public function update(Request $request, Technology $technology): RedirectResponse { $technology->update($this->data($request)); return redirect()->route('admin.technologies.index')->with('success','Technology updated.'); }
    public function destroy(Technology $technology): RedirectResponse { $technology->projects()->detach(); $technology->delete(); return back()->with('success','Technology deleted and detached from projects.'); }
    private function data(Request $request): array { return $request->validate(['name'=>'required|string|max:100','icon'=>'nullable|string|max:100']); }
}
