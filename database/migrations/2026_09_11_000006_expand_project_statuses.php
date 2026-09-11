<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE projects MODIFY status VARCHAR(30) NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        DB::statement("UPDATE projects SET status = 'draft' WHERE status NOT IN ('draft', 'published')");
        DB::statement("ALTER TABLE projects MODIFY status ENUM('draft', 'published') NOT NULL DEFAULT 'draft'");
    }
};
