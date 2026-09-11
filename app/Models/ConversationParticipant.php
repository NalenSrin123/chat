<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ConversationParticipant extends Model { protected $guarded=[]; protected $casts=['joined_at'=>'datetime','last_read_at'=>'datetime']; public function conversation(){return $this->belongsTo(Conversation::class);} public function user(){return $this->belongsTo(User::class);} }
