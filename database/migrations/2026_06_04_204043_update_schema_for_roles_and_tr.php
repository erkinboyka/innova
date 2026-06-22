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
        // Add roles to users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['scientist', 'university', 'nii', 'business', 'investor', 'agency'])->default('scientist')->after('email');
            }
            if (!Schema::hasColumn('users', 'organization_id')) {
                $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            }
        });

        // Add fields to organizations if not present
        Schema::table('organizations', function (Blueprint $table) {
            if (!Schema::hasColumn('organizations', 'type')) {
                $table->string('type')->nullable(); // university, nii, company
            }
            if (!Schema::hasColumn('organizations', 'region')) {
                $table->string('region')->nullable();
            }
            if (!Schema::hasColumn('organizations', 'website')) {
                $table->string('website')->nullable();
            }
        });

        // Patents table
        if (!Schema::hasTable('patents')) {
            Schema::create('patents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
                $table->string('number');
                $table->string('country')->default('TJ');
                $table->date('date')->nullable();
                $table->timestamps();
            });
        }

        // Grants table
        if (!Schema::hasTable('grants')) {
            Schema::create('grants', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->decimal('budget', 15, 2)->nullable();
                $table->date('deadline')->nullable();
                $table->timestamps();
            });
        }

        // Investments table
        if (!Schema::hasTable('investments')) {
            Schema::create('investments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
                $table->unsignedBigInteger('investor_id');
                $table->foreign('investor_id')->references('id')->on('users')->cascadeOnDelete();
                $table->decimal('amount', 15, 2);
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }

        // Messages table
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sender_id');
                $table->unsignedBigInteger('receiver_id');
                $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('investments');
        Schema::dropIfExists('grants');
        Schema::dropIfExists('patents');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn(['role', 'organization_id']);
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['type', 'region', 'website']);
        });
    }
};


