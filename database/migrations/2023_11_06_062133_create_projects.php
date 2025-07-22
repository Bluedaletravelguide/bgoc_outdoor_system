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
        // Schema::create('projects', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('project_prefix');
        //     $table->date('from_date')->default(null)->nullable();
        //     $table->date('to_date')->default(null)->nullable();
        //     $table->string('type');
        //     $table->unsignedBigInteger('client_company_id');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

        //     $table->foreign('client_company_id')
        //         ->references('id')
        //         ->on('client_company')
        //         ->onDelete('cascade');
        // });

        // Schema::create('onsite_team', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('team_name');
        //     $table->unsignedBigInteger('project_id');
        //     $table->string('type');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

        //     $table->foreign('project_id')
        //         ->references('id')
        //         ->on('projects');
        // });

        // Schema::create('employees', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('contact');
        //     $table->string('position');
        //     $table->unsignedBigInteger('user_id')->nullable();
        //     $table->integer('status')->default(1);
        //     $table->dateTime('deleted_at', $precision = 0)->nullable();
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

        //     $table->foreign('user_id')
        //         ->references('id')
        //         ->on('users');
        // });

        // Schema::create('onsite_team_members', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('employee_id');
        //     $table->unsignedBigInteger('onsite_team_id');
        //     $table->dateTime('created_at', $precision = 0)->useCurrent();
        //     $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();

        //     $table->foreign('employee_id')
        //         ->references('id')
        //         ->on('employees');

        //     $table->foreign('onsite_team_id')
        //         ->references('id')
        //         ->on('onsite_team')
        //         ->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('onsite_team');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('onsite_team_members');
    }
};
