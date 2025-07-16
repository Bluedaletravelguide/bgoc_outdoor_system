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
        Schema::table('work_order', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('created_at'); // Add the new column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order', function (Blueprint $table) {
            $table->dropColumn('due_date'); // Remove the column if rolled back
        });
    }
};
