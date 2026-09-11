<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Message extends Model { use SoftDeletes; protected $guarded=[]; protected $casts=['is_edited'=>'boolean','edited_at'=>'datetime']; public function conversation(){return $this->belongsTo(Conversation::class);} public function sender(){return $this->belongsTo(User::class,'sender_id');} }
