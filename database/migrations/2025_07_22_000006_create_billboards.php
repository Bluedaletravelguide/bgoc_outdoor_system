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
            $table->unsignedBigInteger('company_id');
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

            $table->foreign('company_id')
            ->references('id')
            ->on('client_companies')
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

        Schema::create('monthly_ongoing_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedTinyInteger('month'); // 1 = Jan, 12 = Dec
            $table->year('year');
            $table->string('status'); // e.g., pending, in_progress, completed
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('booking_id')
            ->references('id')
            ->on('billboard_bookings')
            ->onDelete('cascade');
        });

        Schema::create('stock_inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contractor_pic');
            $table->unsignedBigInteger('billboard_in_id');
            $table->unsignedBigInteger('billboard_out_id');
            $table->unsignedBigInteger('company_in_id');
            $table->unsignedBigInteger('company_out_id');
            $table->dateTime('date_in');
            $table->dateTime('date_out');
            $table->string('remarks_in');
            $table->string('remarks_out');
            $table->string('balance_contractor');
            $table->string('balance_bgoc');
            $table->string('quantity_in');
            $table->string('quantity_out');
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

            $table->foreign('contractor_pic')
                ->references('id')
                ->on('contractors')
                ->onDelete('cascade');

            $table->foreign('billboard_in_id')
                ->references('id')
                ->on('billboards')
                ->onDelete('cascade');

            $table->foreign('billboard_out_id')
                ->references('id')
                ->on('billboards')
                ->onDelete('cascade');

            $table->foreign('company_in_id')
                ->references('id')
                ->on('client_companies')
                ->onDelete('cascade');

            $table->foreign('company_out_id')
                ->references('id')
                ->on('client_companies')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_inventory');
        Schema::dropIfExists('monthly_ongoing_jobs');
        Schema::dropIfExists('billboard_bookings');
        Schema::dropIfExists('billboard_images');
        Schema::dropIfExists('billboards');
    }
};
