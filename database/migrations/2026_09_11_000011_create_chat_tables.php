<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $t) {
            $t->id();
            $t->enum('type', ['private', 'admin']);
            $t->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $t->timestamps();
            $t->index(['type', 'updated_at']);
        });
        Schema::create('conversation_participants', function (Blueprint $t) {
            $t->id();
            $t->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->timestamp('joined_at')->useCurrent();
            $t->timestamp('last_read_at')->nullable();
            $t->timestamps();
            $t->unique(['conversation_id', 'user_id']);
            $t->index(['user_id', 'last_read_at']);
        });
        Schema::create('messages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $t->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $t->text('message');
            $t->string('type')->default('text');
            $t->string('file_path')->nullable();
            $t->boolean('is_edited')->default(false);
            $t->timestamp('edited_at')->nullable();
            $t->softDeletes();
            $t->timestamps();
            $t->index(['conversation_id', 'created_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');
    }
};
