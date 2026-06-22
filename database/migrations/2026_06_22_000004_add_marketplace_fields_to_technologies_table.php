<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->string('category')->nullable()->after('cost');
            $table->decimal('investment_goal', 15, 2)->nullable()->after('category');
            $table->string('roi')->nullable()->after('investment_goal');
        });
    }

    public function down(): void
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->dropColumn(['category', 'investment_goal', 'roi']);
        });
    }
};
