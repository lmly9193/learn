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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('model');
            $table->nullableMorphs('causer');
            $table->string('event');
            $table->json('values')->nullable();
            $table->json('changes')->nullable();
            $table->json('requests')->nullable();
            $table->json('properties')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
