<?php
namespace App\Http\Controllers;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSkillController extends Controller
{
    public function index(Request $request): View { $query = Skill::with('category')->orderBy('sort_order')->orderBy('name'); $query->when($request->filled('category'), fn ($q) => $q->where('skill_category_id', $request->integer('category'))); $perPage = in_array($request->integer('per_page'), [10, 20, 50], true) ? $request->integer('per_page') : 10; return view('admin.skills.index', ['skills' => $query->paginate($perPage)->withQueryString(), 'categories' => SkillCategory::orderBy('sort_order')->get()]); }
    public function create(): View { return view('admin.skills.form', ['skill' => new Skill(), 'categories' => SkillCategory::orderBy('sort_order')->get(), 'action' => route('admin.skills.store')]); }
    public function store(Request $request): RedirectResponse { Skill::create($this->data($request)); return redirect()->route('admin.skills.index')->with('success', 'Skill created.'); }
    public function edit(Skill $skill): View { return view('admin.skills.form', ['skill' => $skill, 'categories' => SkillCategory::orderBy('sort_order')->get(), 'action' => route('admin.skills.update', $skill)]); }
    public function update(Request $request, Skill $skill): RedirectResponse { $skill->update($this->data($request)); return redirect()->route('admin.skills.index')->with('success', 'Skill updated.'); }
    public function destroy(Skill $skill): RedirectResponse { $skill->delete(); return back()->with('success', 'Skill deleted.'); }
    private function data(Request $request): array { return $request->validate(['skill_category_id' => 'required|exists:skill_categories,id', 'name' => 'required|string|max:100', 'icon' => 'nullable|string|max:80', 'sort_order' => 'required|integer|min:0|max:9999']); }
}
