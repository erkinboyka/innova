<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('category')->index(); // Conference, Exhibition, Forum, etc.
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::table('grants', function (Blueprint $table) {
            $table->json('documents')->nullable()->after('link');
            $table->text('requirements')->nullable()->after('description');
            $table->string('status')->default('active')->after('deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
        Schema::table('grants', function (Blueprint $table) {
            $table->dropColumn(['documents', 'requirements', 'status']);
        });
    }
};
