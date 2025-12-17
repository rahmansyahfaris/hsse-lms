<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('section_progress', function (Blueprint $table) {
            // Check if column exists before renaming (SQLite safety)
            if (Schema::hasColumn('section_progress', 'section_id')) {
                $table->renameColumn('section_id', 'course_section_id');
            }
            
            // Add new columns if they don't exist
            if (!Schema::hasColumn('section_progress', 'completed')) {
                $table->boolean('completed')->default(false)->after('course_section_id');
            }
            
            if (!Schema::hasColumn('section_progress', 'watch_time')) {
                $table->integer('watch_time')->default(0)->after('completed');
            }
            
            if (!Schema::hasColumn('section_progress', 'total_duration')) {
                $table->integer('total_duration')->nullable()->after('watch_time');
            }

            // Clean up old column if it exists
            if (Schema::hasColumn('section_progress', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_progress', function (Blueprint $table) {
            $table->renameColumn('course_section_id', 'section_id');
            $table->dropColumn(['completed', 'watch_time', 'total_duration']);
            $table->timestamp('completed_at')->nullable();
        });
    }
};
