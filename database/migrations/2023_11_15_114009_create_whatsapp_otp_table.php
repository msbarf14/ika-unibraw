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
        Schema::create(config('kedeka.whatsapp-otp.table'), function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20)->index();
            $table->string('hash');
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('invalid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('kedeka.whatsapp-otp.table'));
    }
};
