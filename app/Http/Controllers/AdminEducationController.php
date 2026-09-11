<?php
namespace App\Http\Controllers;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class AdminEducationController extends Controller
{
    public function index(): View { return view('admin.education.index',['educations'=>Education::orderBy('sort_order')->orderByDesc('start_date')->paginate(10)]); }
    public function create(): View { return view('admin.education.form',['education'=>new Education(),'action'=>route('admin.education.store')]); }
    public function store(Request $request): RedirectResponse { $data = $this->data($request); $data['user_id'] = auth()->id(); Education::create($data); return redirect()->route('admin.education.index')->with('success','Education added.'); }
    public function edit(Education $education): View { return view('admin.education.form',['education'=>$education,'action'=>route('admin.education.update',$education)]); }
    public function update(Request $request, Education $education): RedirectResponse { $education->update($this->data($request)); return redirect()->route('admin.education.index')->with('success','Education updated.'); }
    public function destroy(Education $education): RedirectResponse { $education->delete(); return back()->with('success','Education deleted.'); }
    private function data(Request $request): array { return $request->validate(['school'=>'required|string|max:190','degree'=>'required|string|max:190','major'=>'required|string|max:190','start_date'=>'required|date','end_date'=>'nullable|date|after_or_equal:start_date','description'=>'nullable|string','sort_order'=>'required|integer|min:0']); }
}
