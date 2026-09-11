<?php
namespace App\Http\Controllers;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class AdminCertificateController extends Controller
{
    public function index(): View { return view('admin.certificates.index',['certificates'=>Certificate::orderBy('sort_order')->orderByDesc('issue_date')->paginate(10)]); }
    public function create(): View { return view('admin.certificates.form',['certificate'=>new Certificate(),'action'=>route('admin.certificates.store')]); }
    public function store(Request $request): RedirectResponse { $data=$this->data($request); $data['user_id']=auth()->id(); Certificate::create($data); return redirect()->route('admin.certificates.index')->with('success','Certificate added.'); }
    public function edit(Certificate $certificate): View { return view('admin.certificates.form',['certificate'=>$certificate,'action'=>route('admin.certificates.update',$certificate)]); }
    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $data = $request->validate(['title'=>'required|string|max:190','issuer'=>'required|string|max:190','issue_date'=>'required|date','credential_id'=>'nullable|string|max:190','image_path'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120','url'=>'nullable|url|max:255','sort_order'=>'required|integer|min:0']);
        $oldPath = $certificate->image_path;
        unset($data['image_path']);
        $certificate->fill($data);
        if ($request->hasFile('image_path')) {
            $certificate->image_path = $request->file('image_path')->store('certificates', 'public');
        }
        $certificate->save();
        if ($request->hasFile('image_path') && $oldPath && $oldPath !== $certificate->image_path) {
            Storage::disk('public')->delete($oldPath);
        }
        return redirect()->route('admin.certificates.index')->with('success','Certificate updated.');
    }
    public function destroy(Certificate $certificate): RedirectResponse { if($certificate->image_path)Storage::disk('public')->delete($certificate->image_path); $certificate->delete(); return back()->with('success','Certificate deleted.'); }
    private function data(Request $request, ?Certificate $certificate=null): array { $data=$request->validate(['title'=>'required|string|max:190','issuer'=>'required|string|max:190','issue_date'=>'required|date','credential_id'=>'nullable|string|max:190','image_path'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120','url'=>'nullable|url|max:255','sort_order'=>'required|integer|min:0']); if($request->hasFile('image_path')){ $oldPath=$certificate?->image_path; $data['image_path']=$request->file('image_path')->store('certificates','public'); if($oldPath) Storage::disk('public')->delete($oldPath); } else { unset($data['image_path']); } return $data; }
}
