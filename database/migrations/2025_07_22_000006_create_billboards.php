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
            $table->string('job_order_no');
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

        // Schema::create('stock_inventory', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('contractor_pic');
        //     $table->unsignedBigInteger('billboard_in')->nullable()->change();
        //     $table->unsignedBigInteger('billboard_out')->nullable()->change();
        //     $table->unsignedBigInteger('client_in')->nullable()->change();
        //     $table->unsignedBigInteger('client_out')->nullable()->change();
        //     $table->dateTime('date_in')->nullable()->change();
        //     $table->dateTime('date_out')->nullable()->change();
        //     $table->string('remarks_in')->nullable()->change();
        //     $table->string('remarks_out')->nullable()->change();
        //     $table->string('balance_contractor')->nullable()->change();
        //     $table->string('balance_bgoc')->nullable()->change();
        //     $table->string('quantity_in')->nullable()->change();
        //     $table->string('quantity_out')->nullable()->change();

        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

        //     $table->foreign('contractor_pic')
        //         ->references('id')
        //         ->on('contractors')
        //         ->onDelete('cascade');

        //     $table->foreign('billboard_in')
        //         ->references('id')
        //         ->on('billboards')
        //         ->onDelete('cascade');

        //     $table->foreign('billboard_out')
        //         ->references('id')
        //         ->on('billboards')
        //         ->onDelete('cascade');

        //     $table->foreign('client_in')
        //         ->references('id')
        //         ->on('client_companies')
        //         ->onDelete('cascade');

        //     $table->foreign('client_out')
        //         ->references('id')
        //         ->on('client_companies')
        //         ->onDelete('cascade');
        // });

        Schema::create('stock_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contractor_id')->constrained('contractors')->onDelete('cascade');
            $table->unsignedInteger('balance_contractor')->default(0);
            $table->unsignedInteger('balance_bgoc')->default(0);
            $table->timestamps();
        });

        Schema::create('stock_inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_inventory_id')->constrained('stock_inventories')->onDelete('cascade');
            $table->foreignId('billboard_id')->nullable()->constrained('billboards')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('client_companies')->onDelete('set null');

            $table->enum('type', ['in', 'out']); // IN = return/delivery, OUT = release
            $table->unsignedInteger('quantity')->default(0);

            $table->dateTime('transaction_date');
            $table->string('remarks')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Schema::create('stock_inventory_history', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('stock_inventory_id');
        //     $table->unsignedBigInteger('contractor_pic')->nullable();
        //     $table->unsignedBigInteger('client_in')->nullable();
        //     $table->unsignedBigInteger('client_out')->nullable();
        //     $table->dateTime('date_in')->nullable();
        //     $table->dateTime('date_out')->nullable();
        //     $table->text('remarks_in')->nullable();
        //     $table->text('remarks_out')->nullable();
        //     $table->integer('balance_contractor')->nullable();
        //     $table->integer('balance_bgoc')->nullable();

        //     $table->enum('change_type', ['create','update','delete']);
        //     $table->unsignedBigInteger('changed_by')->nullable();
        //     $table->timestamp('changed_at')->useCurrent();

        //     $table->foreign('stock_inventory_id')->references('id')->on('stock_inventory')->onDelete('cascade');
        //     $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_inventory_sites_history');
        Schema::dropIfExists('stock_inventory_history');
        Schema::dropIfExists('stock_inventory_sites');
        Schema::dropIfExists('stock_inventory_transactions');
        Schema::dropIfExists('stock_inventory');
        Schema::dropIfExists('stock_inventories');
        Schema::dropIfExists('monthly_ongoing_jobs');
        Schema::dropIfExists('billboard_bookings');
        Schema::dropIfExists('billboard_images');
        Schema::dropIfExists('billboards');
    }

};
