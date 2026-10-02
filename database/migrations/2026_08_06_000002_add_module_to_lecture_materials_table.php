<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lecture_materials', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->after('course_id')->constrained('lecture_modules')->nullOnDelete();
            $table->integer('sort_order')->default(0)->after('module_id');
        });
    }

    public function down(): void
    {
        Schema::table('lecture_materials', function (Blueprint $table) {
            $table->dropConstrainedForeignId('module_id');
            $table->dropColumn('sort_order');
        });
    }
};
