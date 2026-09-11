<?php
namespace App\Http\Controllers;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
class MemberAuthController extends Controller {
 public function register(): View { return view('auth.register'); }
 public function store(Request $request): RedirectResponse { $data=$request->validate(['name'=>'required|string|max:120','username'=>['required','string','min:3','max:40','alpha_dash','unique:users,username'],'email'=>['required','email','max:190','unique:users,email'],'password'=>['required','string','min:8','confirmed']]); $user=User::create(['name'=>$data['name'],'username'=>Str::lower($data['username']),'email'=>$data['email'],'password'=>Hash::make($data['password']),'role'=>'user']); Profile::create(['user_id'=>$user->id,'title'=>'Developer','bio'=>'Tell the world what you build.']); Auth::login($user); return redirect()->route('member.dashboard'); }
 public function login(): View { return view('auth.login'); }
 public function authenticate(Request $request): RedirectResponse { $credentials=$request->validate(['email'=>['required','email'],'password'=>['required','string']]); if(!Auth::attempt($credentials,$request->boolean('remember'))) return back()->withErrors(['email'=>'Invalid email or password.'])->onlyInput('email'); $request->session()->regenerate(); return redirect()->intended(route('member.dashboard')); }
 public function logout(Request $request): RedirectResponse { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('home'); }
}
