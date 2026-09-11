<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', fn(Blueprint $t) => $t->index(['status', 'featured']));
        Schema::table('blogs', fn(Blueprint $t) => $t->index(['status', 'published_at']));
        Schema::table('contact_messages', fn(Blueprint $t) => $t->index(['status', 'created_at']));
    }
    public function down(): void
    {
        Schema::table('projects', fn(Blueprint $t) => $t->dropIndex(['projects_status_featured_index']));
        Schema::table('blogs', fn(Blueprint $t) => $t->dropIndex(['blogs_status_published_at_index']));
        Schema::table('contact_messages', fn(Blueprint $t) => $t->dropIndex(['contact_messages_status_created_at_index']));
    }
};
