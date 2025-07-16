<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('locations', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('type'); // building / level / department
        //     $table->unsignedBigInteger('parent_id')->nullable();
        //     $table->foreign('parent_id')->references('id')->on('locations')->onDelete('cascade');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        // });

        // Schema::create('project_has_locations', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('contract_id');
        //     $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
        //     $table->unsignedBigInteger('location_id');
        //     $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_has_locations');
        Schema::dropIfExists('locations');
    }
};
