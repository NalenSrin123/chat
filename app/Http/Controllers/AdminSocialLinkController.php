<?php
namespace App\Http\Controllers;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSocialLinkController extends Controller
{
    public function index(Request $request): View { $perPage = in_array($request->integer('per_page'), [10, 20, 50], true) ? $request->integer('per_page') : 10; return view('admin.social-links.index', ['links' => SocialLink::orderBy('sort_order')->orderBy('name')->paginate($perPage)->withQueryString()]); }
    public function create(): View { return view('admin.social-links.form', ['link' => new SocialLink(), 'action' => route('admin.social-links.store')]); }
    public function store(Request $request): RedirectResponse { SocialLink::create($this->data($request)); return redirect()->route('admin.social-links.index')->with('success', 'Social link created.'); }
    public function edit(SocialLink $socialLink): View { return view('admin.social-links.form', ['link' => $socialLink, 'action' => route('admin.social-links.update', $socialLink)]); }
    public function update(Request $request, SocialLink $socialLink): RedirectResponse { $socialLink->update($this->data($request)); return redirect()->route('admin.social-links.index')->with('success', 'Social link updated.'); }
    public function destroy(SocialLink $socialLink): RedirectResponse { $socialLink->delete(); return back()->with('success', 'Social link deleted.'); }
    private function data(Request $request): array { return $request->validate(['name' => 'required|string|max:80', 'url' => 'required|url|max:255', 'icon' => 'nullable|string|max:80', 'sort_order' => 'required|integer|min:0|max:9999']); }
}
