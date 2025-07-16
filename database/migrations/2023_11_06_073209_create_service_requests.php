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
        Schema::create('sr_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('sr_sub_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('sr_category_id');

            $table->foreign('sr_category_id')
            ->references('id')
            ->on('sr_category')
            ->onDelete('cascade');
        });

        Schema::create('service_request', function (Blueprint $table) {
            $table->id();
            $table->string('service_request_no');
            $table->string('description');
            $table->string('location')->default(null)->nullable();
            $table->string('status');
            $table->string('remarks_by_client');
            $table->string('remarks_by_teamleader')->default(null)->nullable();
            $table->unsignedBigInteger('work_order_id')->default(null)->nullable(); 
            $table->unsignedBigInteger('sr_sub_category_id');
            $table->unsignedBigInteger('sr_category_id');
            $table->unsignedBigInteger('raise_by');
            $table->unsignedBigInteger('project_id'); 
            // $table->unsignedBigInteger('asset_id')->default(null)->nullable(); 
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('sr_sub_category_id')
            ->references('id')
            ->on('sr_sub_category')
            ->onDelete('cascade');

            $table->foreign('sr_category_id')
            ->references('id')
            ->on('sr_category')
            ->onDelete('cascade');

            $table->foreign('raise_by')
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

        Schema::create('service_request_photos', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('service_request_id');
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('service_request_id')
            ->references('id')
            ->on('service_request')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sr_category');
        Schema::dropIfExists('sr_sub_category');
        Schema::dropIfExists('service_request');
        Schema::dropIfExists('service_request_photos');
    }
};
