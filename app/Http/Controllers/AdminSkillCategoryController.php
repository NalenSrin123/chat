<?php
namespace App\Http\Controllers;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSkillCategoryController extends Controller
{
    public function index(Request $request): View { $perPage = in_array($request->integer('per_page'), [10, 20, 50], true) ? $request->integer('per_page') : 10; return view('admin.skill-categories.index', ['categories' => SkillCategory::withCount('skills')->orderBy('sort_order')->paginate($perPage)->withQueryString()]); }
    public function create(): View { return view('admin.skill-categories.form', ['category' => new SkillCategory(), 'action' => route('admin.skill-categories.store')]); }
    public function store(Request $request): RedirectResponse { SkillCategory::create($this->data($request)); return redirect()->route('admin.skill-categories.index')->with('success', 'Skill category created.'); }
    public function edit(SkillCategory $skillCategory): View { return view('admin.skill-categories.form', ['category' => $skillCategory, 'action' => route('admin.skill-categories.update', $skillCategory)]); }
    public function update(Request $request, SkillCategory $skillCategory): RedirectResponse { $skillCategory->update($this->data($request)); return redirect()->route('admin.skill-categories.index')->with('success', 'Skill category updated.'); }
    public function destroy(SkillCategory $skillCategory): RedirectResponse { if ($skillCategory->skills()->exists()) return back()->with('error', 'This category cannot be deleted because skills still belong to it. Reassign or delete those skills first.'); $skillCategory->delete(); return back()->with('success', 'Skill category deleted.'); }
    private function data(Request $request): array { return $request->validate(['name' => 'required|string|max:100', 'description' => 'nullable|string|max:1000', 'sort_order' => 'required|integer|min:0|max:9999']); }
}
