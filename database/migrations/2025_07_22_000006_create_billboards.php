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
        Schema::create('billboards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            // $table->unsignedBigInteger('image_id');
            $table->string('site_number');
            $table->string('gps_latitude');
            $table->string('gps_longitude');
            $table->string('traffic_volume');
            $table->string('size');
            $table->string('type');
            $table->string('prefix');
            $table->string('lighting');
            $table->string('status');
            $table->unsignedBigInteger('created_by')->nullable();;
            $table->unsignedBigInteger('updated_by')->nullable();;
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();


            $table->foreign('location_id')
            ->references('id')
            ->on('locations')
            ->onDelete('cascade');

            // $table->foreign('image_id')
            // ->references('id')
            // ->on('billboard_images')
            // ->onDelete('cascade');

            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('updated_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });

        Schema::create('billboard_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billboard_id');
            $table->string('image_path');
            $table->string('image_type');
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('billboard_id')
            ->references('id')
            ->on('billboards')
            ->onDelete('cascade');
        });

        Schema::create('billboard_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billboard_id');
            $table->unsignedBigInteger('client_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status');
            $table->string('artwork_by');
            $table->string('dbp_approval');
            $table->string('remarks');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('billboard_id')
            ->references('id')
            ->on('billboards')
            ->onDelete('cascade');

            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('updated_by')
            ->references('id')
            ->on('users')
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

        Schema::dropIfExists('billboards');
        Schema::dropIfExists('billboard_images');
        Schema::dropIfExists('billboard_bookings');
    }
};
