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
        // Schema::create('asset_category', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('code');
        //     $table->string('name');
        //     $table->string('description');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        // });

        // Schema::create('suppliers', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('code');
        //     $table->string('name');
        //     $table->string('address');
        //     $table->string('contact_person');
        //     $table->string('phone');
        //     $table->string('fax')->nullable();
        //     $table->string('email')->nullable();
        //     $table->string('description')->nullable();
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        // });

        // Schema::create('purchase_orders', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('receipt_reference_number')->nullable();
        //     $table->float('price');
        //     $table->date('purchase_date');
        //     $table->date('warranty_from')->nullable();
        //     $table->date('warranty_until')->nullable();
        //     $table->string('description')->nullable();
        //     $table->unsignedBigInteger('supplier_id');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
            
        //     $table->foreign('supplier_id')
        //         ->references('id')
        //         ->on('suppliers')
        //         ->onDelete('cascade')
        //     ;
        // });
        
        // Schema::create('assets', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('code');
        //     $table->string('name');
        //     $table->string('description');
        //     $table->unsignedBigInteger('asset_category_id')->nullable();
        //     $table->unsignedBigInteger('location_id');
        //     $table->unsignedBigInteger('purchase_order_id');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();


        //     $table->foreign('asset_category_id')
        //     ->references('id')
        //     ->on('asset_category')
        //     ->onDelete('cascade');

        //     $table->foreign('location_id')
        //     ->references('id')
        //     ->on('locations')
        //     ->onDelete('cascade');

        //     $table->foreign('purchase_order_id')
        //     ->references('id')
        //     ->on('purchase_orders')
        //     ->onDelete('cascade');

        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
        Schema::dropIfExists('asset_category');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('suppliers');
    }
};