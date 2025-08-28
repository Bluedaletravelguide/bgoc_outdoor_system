<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // STATES
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->unique();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // DISTRICTS
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('cascade');
        });

        // COUNCILS
        Schema::create('councils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('name'); // full name e.g. "Majlis Bandaraya Petaling Jaya"
            $table->string('abbreviation', 20); // short form e.g. "MBPJ"
            $table->timestamps();

            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('cascade');
        });

        // LOCATIONS
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('council_id');
            $table->unsignedBigInteger('district_id')->nullable(); // optional for KL
            $table->string('name');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('council_id')
                ->references('id')
                ->on('councils')
                ->onDelete('cascade');

            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('set null'); // safe if not strictly needed

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

    public function down()
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('councils');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('states');
    }
};
