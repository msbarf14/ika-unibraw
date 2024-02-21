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
        Schema::create('guestbooks_pics', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('position');
            $table->string('phone');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('guestbooks_entries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('pic_id');
            $table->string('name');
            $table->string('phone');
            $table->string('agency');
            $table->longText('needs');
            $table->date('date');
            $table->string('at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guestbooks_pics');
        Schema::dropIfExists('guestbooks_entries');
    }
};
