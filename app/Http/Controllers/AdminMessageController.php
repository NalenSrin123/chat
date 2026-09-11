<?php
namespace App\Http\Controllers;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
class AdminMessageController extends Controller
{
    public function index(Request $request): View { $query=ContactMessage::query(); $query->when($request->filled('q'),fn($q)=>$q->where(fn($x)=>$x->where('name','like','%'.$request->string('q').'%')->orWhere('email','like','%'.$request->string('q').'%')->orWhere('subject','like','%'.$request->string('q').'%'))); $query->when($request->filled('status'),fn($q)=>$q->where('status',$request->string('status'))); $sort=$request->get('sort')==='oldest'?'asc':'desc'; $query->orderBy('created_at',$sort); $perPage=in_array($request->integer('per_page'),[10,20,50],true)?$request->integer('per_page'):10; return view('admin.messages.index',['messages'=>$query->paginate($perPage)->withQueryString()]); }
    public function show(ContactMessage $message): View { if($message->status==='new')$message->update(['status'=>'read']); return view('admin.messages.show',compact('message')); }
    public function status(Request $request, ContactMessage $message): RedirectResponse { $status=$request->validate(['status'=>'required|in:new,read,replied'])['status']; $message->update(['status'=>$status,'replied_at'=>$status==='replied'?now():null]); return back()->with('success','Message status updated.'); }
    public function reply(Request $request, ContactMessage $message): RedirectResponse
    {
        $data = $request->validate(['reply' => 'required|string|max:10000']);
        try {
            Mail::raw($data['reply'], function ($mail) use ($message) {
                $mail->to($message->email)->subject('Re: '.$message->subject);
            });
        } catch (TransportExceptionInterface $exception) {
            Log::error('Portfolio reply email failed.', ['message_id' => $message->id, 'error' => $exception->getMessage()]);
            return back()->withInput()->with('error', 'Email could not be sent. Check the SMTP settings in your .env file.');
        }
        $message->update(['status' => 'replied', 'replied_at' => now()]);
        return back()->with('success', 'Reply sent to '.$message->email.'.');
    }
    public function destroy(ContactMessage $message): RedirectResponse { $message->delete(); return redirect()->route('admin.messages.index')->with('success','Message deleted.'); }
}
