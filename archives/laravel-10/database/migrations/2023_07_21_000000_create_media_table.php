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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('mediable');
            $table->ulid('ulid')->unique();
            $table->bigInteger('user_id')->nullable();
            $table->string('path')->unique();
            $table->string('display_name')->nullable();
            $table->string('original_name');
            $table->unsignedBigInteger('size');
            $table->string('mimetype')->nullable();
            $table->string('collection');
            $table->json('properties');
            $table->json('whitelist');
            $table->json('blacklist');
            $table->unsignedInteger('order')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
