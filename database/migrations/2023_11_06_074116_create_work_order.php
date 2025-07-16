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
        Schema::create('work_order', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_no');
            $table->string('type');
            $table->string('status');
            $table->string('priority');
            $table->unsignedBigInteger('service_request_id');
            $table->unsignedBigInteger('status_changed_by');
            $table->unsignedBigInteger('assigned_teamleader')->default(null)->nullable();
            $table->unsignedBigInteger('assign_to_technician')->default(null)->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            // $table->unsignedBigInteger('asset_id')->default(null)->nullable(); 
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();


            $table->foreign('service_request_id')
            ->references('id')
            ->on('service_request')
            ->onDelete('cascade');

            $table->foreign('status_changed_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('assigned_teamleader')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('assign_to_technician')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('project_id')
            ->references('id')
            ->on('projects')
            ->onDelete('cascade');

            // $table->foreign('asset_id')
            // ->references('id')
            // ->on('assets')
            // ->onDelete('cascade');

        });

        Schema::create('work_order_history', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('status_changed_by');
            $table->unsignedBigInteger('assigned_teamleader')->nullable();
            $table->unsignedBigInteger('assign_to_technician')->nullable();
            $table->unsignedBigInteger('work_order_id')->nullable();
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
            

            $table->foreign('status_changed_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('assigned_teamleader')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('assign_to_technician')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('work_order_id')
            ->references('id')
            ->on('work_order')
            ->onDelete('cascade');
        });

        Schema::create('work_order_activity', function (Blueprint $table) {
            $table->id();
            $table->string('comments');
            $table->unsignedBigInteger('comment_by');
            $table->unsignedBigInteger('work_order_id');
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('comment_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            
            $table->foreign('work_order_id')
            ->references('id')
            ->on('work_order')
            ->onDelete('cascade');

        });

        // Add foreign key of service request to work order ID

        Schema::table('service_request', function (Blueprint $table) {
            $table->foreign('work_order_id')
                ->references('id')
                ->on('work_order')
                ->onDelete('cascade');
        });

        // Schema::create('work_order_observations_photos', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('url');
        //     $table->unsignedBigInteger('wo_observations_id');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

        //     $table->foreign('wo_observations_id')
        //     ->references('id')
        //     ->on('work_order_observations')
        //     ->onDelete('cascade');
        // });

        Schema::create('work_order_activity_attachment', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('wo_activity_id');
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('wo_activity_id')
            ->references('id')
            ->on('work_order_activity')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order');
        Schema::dropIfExists('work_order_history');
        Schema::dropIfExists('work_order_activity');
        Schema::dropIfExists('work_order_activity_attachment');
    }
};