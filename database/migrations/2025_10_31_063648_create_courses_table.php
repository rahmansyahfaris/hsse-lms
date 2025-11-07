<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();                           // Auto-incrementing ID
            $table->string('title');                // Course title
            $table->text('description');            // Course description
            $table->integer('duration_hours');      // Duration in hours
            $table->timestamps();                   // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
