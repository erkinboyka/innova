<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            if (!Schema::hasColumn('organizations', 'verification_status')) {
                $table->string('verification_status')->default('pending')->after('logo');
            }
            if (!Schema::hasColumn('organizations', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('organizations', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->string('verification_status')->default('pending')->after('position');
            }
            if (!Schema::hasColumn('users', 'verification_type')) {
                $table->string('verification_type')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verification_type');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('verified_at');
            }
            if (!Schema::hasColumn('users', 'expertise')) {
                $table->json('expertise')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'works')) {
                $table->json('works')->nullable()->after('expertise');
            }
            if (!Schema::hasColumn('users', 'business_profile')) {
                $table->json('business_profile')->nullable()->after('works');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status',
                'verification_type',
                'verified_at',
                'bio',
                'expertise',
                'works',
                'business_profile',
            ]);
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['verification_status', 'verified_at', 'created_by']);
        });
    }
};
