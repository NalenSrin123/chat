<?php
namespace App\Http\Controllers;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class AdminTestimonialController extends Controller
{
    public function index(): View { return view('admin.testimonials.index',['testimonials'=>Testimonial::orderBy('sort_order')->paginate(10)]); }
    public function create(): View { return view('admin.testimonials.form',['testimonial'=>new Testimonial(),'action'=>route('admin.testimonials.store')]); }
    public function store(Request $request): RedirectResponse { Testimonial::create($this->data($request)); return redirect()->route('admin.testimonials.index')->with('success','Testimonial created.'); }
    public function edit(Testimonial $testimonial): View { return view('admin.testimonials.form',['testimonial'=>$testimonial,'action'=>route('admin.testimonials.update',$testimonial)]); }
    public function update(Request $request, Testimonial $testimonial): RedirectResponse { $testimonial->update($this->data($request,$testimonial)); return redirect()->route('admin.testimonials.index')->with('success','Testimonial updated.'); }
    public function destroy(Testimonial $testimonial): RedirectResponse { if($testimonial->avatar)Storage::disk('public')->delete($testimonial->avatar); $testimonial->delete(); return back()->with('success','Testimonial deleted.'); }
    private function data(Request $request, ?Testimonial $testimonial=null): array { $data=$request->validate(['name'=>'required|string|max:120','position'=>'required|string|max:190','company'=>'nullable|string|max:190','message'=>'required|string|max:3000','avatar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096','is_approved'=>'nullable|boolean','sort_order'=>'required|integer|min:0']); $data['is_approved']=$request->boolean('is_approved'); if($request->hasFile('avatar')){if($testimonial?->avatar)Storage::disk('public')->delete($testimonial->avatar);$data['avatar']=$request->file('avatar')->store('testimonials','public');}else unset($data['avatar']); return $data; }
}
