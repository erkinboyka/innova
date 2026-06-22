<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->string('technology')->nullable();
            $table->integer('trl')->default(1); // Technology Readiness Level 1-9
            $table->enum('status', ['research', 'prototype', 'ready', 'commercialized'])->default('research');
            $table->decimal('price', 15, 2)->nullable();
            $table->string('category')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developments');
    }
};
