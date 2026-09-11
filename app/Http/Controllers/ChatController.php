<?php
namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class ChatController extends Controller {
 private function allowed(Conversation $conversation):void { abort_unless($conversation->includes(auth()->user()),403); }
 public function index(Request $request):View { $user=auth()->user(); $conversations=$user->conversations()->with(['participants','lastMessage.sender'])->orderByDesc('updated_at')->get()->map(function($conversation) use ($user){$participant=$conversation->participants->firstWhere('id',$user->id);$conversation->unread_count=$conversation->messages()->where('sender_id','!=',$user->id)->when($participant?->pivot?->last_read_at,fn($q,$date)=>$q->where('created_at','>',$date))->count();return $conversation;}); $active=$request->integer('conversation'); if($active){$conversation=Conversation::with('participants')->findOrFail($active);$this->allowed($conversation);$messages=$conversation->messages()->with('sender')->latest()->paginate(30)->withQueryString();$conversation->participants()->updateExistingPivot($user->id,['last_read_at'=>now()]);}else{$conversation=null;$messages=collect();} return view('chat.index',compact('conversations','conversation','messages')); }
 public function start(Request $request):RedirectResponse { $data=$request->validate(['user_id'=>'required|exists:users,id']); abort_if((int)$data['user_id']===auth()->id(),422,'You cannot chat with yourself.'); $other=User::findOrFail($data['user_id']); $conversation=auth()->user()->conversations()->where('type','private')->whereHas('participants',fn($q)=>$q->whereKey($other->id))->first(); if(!$conversation){$conversation=Conversation::create(['type'=>'private','created_by'=>auth()->id()]);$conversation->participants()->attach([auth()->id(),$other->id],['joined_at'=>now()]);} return redirect()->route('chat.index',['conversation'=>$conversation->id]); }
 public function send(Request $request,Conversation $conversation):RedirectResponse|\Illuminate\Http\JsonResponse { $this->allowed($conversation); $data=$request->validate(['message'=>'required|string|max:5000']); $message=$conversation->messages()->create(['sender_id'=>auth()->id(),'message'=>$data['message'],'type'=>'text']); broadcast(new MessageSent($message))->toOthers(); $conversation->touch(); if($request->expectsJson()) return response()->json(['message'=>$message->load('sender')]); return back(); }
 public function read(Conversation $conversation):RedirectResponse { $this->allowed($conversation);$conversation->participants()->updateExistingPivot(auth()->id(),['last_read_at'=>now()]);return back(); }
 public function users(Request $request){return User::whereKeyNot(auth()->id())->when($request->filled('q'),fn($q)=>$q->where(fn($x)=>$x->where('name','like','%'.$request->q.'%')->orWhere('username','like','%'.$request->q.'%')))->orderBy('name')->limit(20)->get(['id','name','username']);}
}
