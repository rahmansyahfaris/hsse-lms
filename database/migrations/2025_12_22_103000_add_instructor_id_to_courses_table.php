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
        Schema::table('courses', function (Blueprint $table) {
            // Make it nullable first to handle existing records
            $table->foreignId('instructor_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });
        
        // Update existing courses to assign the first instructor (or admin)
        $firstInstructor = \App\Models\User::where('role', 'instructor')->orWhere('role', 'admin')->first();
        if ($firstInstructor) {
            \DB::table('courses')->whereNull('instructor_id')->update(['instructor_id' => $firstInstructor->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->dropColumn('instructor_id');
        });
    }
};
