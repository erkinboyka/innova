<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('technologies', function (Blueprint $col) {
            $col->text('problem')->nullable()->after('description');
            $col->text('solution')->nullable()->after('problem');
            $col->text('technology_details')->nullable()->after('solution');
            $col->string('video_url')->nullable()->after('files');
            $col->string('model_3d_url')->nullable()->after('video_url');
            $col->json('authors')->nullable()->after('owner_id');
            $col->decimal('cost', 15, 2)->nullable()->after('model_3d_url');
            $col->string('currency', 3)->default('TJS')->after('cost');
        });
    }

    public function down(): void
    {
        Schema::table('technologies', function (Blueprint $col) {
            $col->dropColumn([
                'problem',
                'solution',
                'technology_details',
                'video_url',
                'model_3d_url',
                'authors',
                'cost',
                'currency'
            ]);
        });
    }
};
