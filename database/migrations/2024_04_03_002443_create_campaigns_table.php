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
        Schema::create('donation_campaigns', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('image');
            $table->text('description')->nullable();
            $table->boolean('open')->default(false);
            $table->boolean('display_amount')->default(false);
            $table->bigInteger('amount')->default(0);
            $table->timestamps();
        });

        Schema::create('donation_transactions', function (Blueprint $table) {
            $table->ulid('id');
            $table->string('campaign_id')->index();
            $table->string('name');
            $table->string('phone');
            $table->string('message');
            $table->string('attachment');
            $table->boolean('paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_campaigns');
        Schema::dropIfExists('donation_transactions');
    }
};
