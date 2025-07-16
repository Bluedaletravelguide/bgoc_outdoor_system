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
        Schema::create('push_notification', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('user_id');
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        });

        Schema::create('notification_history', function (Blueprint $table) {
            $table->id();
            $table->string('notification_content');
            $table->string('user_id');
            $table->string('status');
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('push_notification');
        Schema::dropIfExists('notification_history');
    }
};