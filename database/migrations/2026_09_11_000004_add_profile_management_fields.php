<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->longText('full_bio')->nullable()->after('bio');
            $table->text('career_goals')->nullable();
            $table->longText('developer_journey')->nullable();
            $table->text('languages')->nullable();
            $table->text('interests')->nullable();
            $table->string('contact_email')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['full_bio', 'career_goals', 'developer_journey', 'languages', 'interests', 'contact_email']);
        });
    }
};
