<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE lecture_materials MODIFY COLUMN type ENUM('document', 'video', 'slides', 'other') NOT NULL DEFAULT 'document'");
        DB::statement("ALTER TABLE lecture_materials MODIFY COLUMN visibility ENUM('public', 'private') NOT NULL DEFAULT 'public'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE lecture_materials MODIFY COLUMN type ENUM('pdf', 'doc', 'ppt', 'video_link', 'other') NOT NULL DEFAULT 'pdf'");
        DB::statement("ALTER TABLE lecture_materials MODIFY COLUMN visibility ENUM('visible', 'hidden') NOT NULL DEFAULT 'visible'");
    }
};
