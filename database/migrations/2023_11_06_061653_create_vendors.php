<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
        // Schema::create('vendor_company', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->unique();
        //     $table->string('address');
        //     $table->string('phone');
        //     $table->string('description');
        //     $table->string('services_offered');
        //     $table->integer('status')->default(1);
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        //     $table->dateTime('deleted_at', $precision = 0)->nullable();

        // });

        // Schema::create('vendors', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('contact');
        //     $table->unsignedBigInteger('company_id');
        //     $table->unsignedBigInteger('user_id')->nullable();
        //     $table->integer('status')->default(1);
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        //     $table->dateTime('deleted_at', $precision = 0)->nullable();

        //     $table->foreign('company_id')
        //         ->references('id')
        //         ->on('vendor_company')
        //         ->onDelete('cascade');

        //     $table->foreign('user_id')
        //         ->references('id')
        //         ->on('users')
        //         ->onDelete('cascade');
        // });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_company');
        Schema::dropIfExists('vendors');
    }
};
