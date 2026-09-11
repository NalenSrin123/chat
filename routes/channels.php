<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('conversation.{conversation}', function ($user, $conversation) {
    return \App\Models\Conversation::find($conversation)?->includes($user) ?? false;
});
