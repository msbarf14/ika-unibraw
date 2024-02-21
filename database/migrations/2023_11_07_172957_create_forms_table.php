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
        Schema::create('form_schemas', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->integer('sort')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->index();
            $table->json('schema')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('form_collections', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('schema_id')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_schemas');
        Schema::dropIfExists('form_collections');
    }
};
