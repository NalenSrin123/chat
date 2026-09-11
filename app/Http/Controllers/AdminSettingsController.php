<?php
namespace App\Http\Controllers;
use App\Services\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class AdminSettingsController extends Controller
{
    public function edit(SiteSettings $settings): View { return view('admin.settings.edit',['settings'=>$settings->all()]); }
    public function update(Request $request, SiteSettings $settings): RedirectResponse { $data=$request->validate(['website_name'=>'nullable|string|max:190','website_title'=>'nullable|string|max:190','meta_description'=>'nullable|string|max:320','contact_email'=>'nullable|email|max:190','contact_phone'=>'nullable|string|max:60','footer_text'=>'nullable|string|max:500','analytics_id'=>'nullable|string|max:100','logo_text'=>'nullable|string|max:80','logo'=>'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048','favicon'=>'nullable|file|mimes:png,ico,svg|max:1024']); foreach(['logo','favicon'] as $file){if($request->hasFile($file)){ $old=$settings->get($file); if($old)Storage::disk('public')->delete($old); $data[$file]=$request->file($file)->store('settings','public'); }} $settings->put($data); return back()->with('success','Settings saved.'); }
}
