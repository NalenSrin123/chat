<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::table('projects', function (Blueprint $table) { $table->text('problem')->nullable(); $table->text('solution')->nullable(); $table->text('objectives')->nullable(); $table->text('responsibilities')->nullable(); $table->text('challenges')->nullable(); $table->text('architecture')->nullable(); }); }
    public function down(): void { Schema::table('projects', fn (Blueprint $table) => $table->dropColumn(['problem','solution','objectives','responsibilities','challenges','architecture'])); }
};
