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
        Schema::create('client_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_prefix', 4)->unique();
            $table->string('name')->unique();
            $table->string('address');
            $table->string('phone');
            $table->integer('status')->default(1);
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
            $table->dateTime('deleted_at', $precision = 0)->nullable();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('designation');
            $table->unsignedBigInteger('company_id');
            $table->integer('status')->default(1);
            $table->dateTime('created_at', $precision = 0)->useCurrent();
            $table->dateTime('updated_at', $precision = 0)->nullable()->useCurrentOnUpdate();
            $table->dateTime('deleted_at', $precision = 0)->nullable();

            $table->foreign('company_id')
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
        Schema::dropIfExists('client_companies');
        Schema::dropIfExists('clients');
    }
};
