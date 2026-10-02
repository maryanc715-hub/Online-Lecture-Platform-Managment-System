<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lecture_materials', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('description');
        });

        DB::statement("ALTER TABLE lecture_materials MODIFY COLUMN type ENUM('document', 'video', 'slides', 'notes', 'other') NOT NULL DEFAULT 'document'");
        DB::table('lecture_materials')->where('type', 'slides')->update(['type' => 'notes']);
        DB::statement("ALTER TABLE lecture_materials MODIFY COLUMN type ENUM('document', 'video', 'notes', 'other') NOT NULL DEFAULT 'document'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE lecture_materials MODIFY COLUMN type ENUM('document', 'video', 'slides', 'other') NOT NULL DEFAULT 'document'");
        DB::table('lecture_materials')->where('type', 'notes')->update(['type' => 'slides']);

        Schema::table('lecture_materials', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};
