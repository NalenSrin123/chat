<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Conversation extends Model { protected $guarded=[]; public function creator():BelongsTo{return $this->belongsTo(User::class,'created_by');} public function participants():BelongsToMany{return $this->belongsToMany(User::class,'conversation_participants')->withPivot('joined_at','last_read_at')->withTimestamps();} public function messages():HasMany{return $this->hasMany(Message::class);} public function lastMessage(){return $this->hasOne(Message::class)->latestOfMany();} public function includes(User $user):bool{return $this->participants()->whereKey($user->id)->exists();} }
