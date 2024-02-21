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
        $this->down();

        Schema::create('navigations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->integer('sort')->nullable()->index();
            $table->string('type', 32)->nullable()->index()->default('url');
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->json('childs')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigations');
    }
};
