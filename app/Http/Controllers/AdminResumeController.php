<?php
namespace App\Http\Controllers;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class AdminResumeController extends Controller
{
    public function edit(): View { return view('admin.resume.edit',['profile'=>Profile::firstOrCreate(['user_id'=>auth()->id()])]); }
    public function update(Request $request): RedirectResponse { $request->validate(['cv'=>'required|file|mimes:pdf|max:10240']); $profile=Profile::firstOrCreate(['user_id'=>auth()->id()]); if($profile->cv_path)Storage::disk('public')->delete($profile->cv_path); $profile->update(['cv_path'=>$request->file('cv')->store('resumes','public')]); return back()->with('success','CV uploaded successfully.'); }
    public function destroy(): RedirectResponse { $profile=Profile::where('user_id',auth()->id())->firstOrFail(); if($profile->cv_path)Storage::disk('public')->delete($profile->cv_path); $profile->update(['cv_path'=>null]); return back()->with('success','CV removed.'); }
}
