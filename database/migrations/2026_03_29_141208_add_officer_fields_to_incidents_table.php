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
        Schema::table('incidents', function (Blueprint $table) {
            $table->text('investigation_notes')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('resolution_summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn([
                'investigation_notes',
                'action_taken',
                'rejection_reason',
                'resolution_summary',
            ]);
        });
    }
};