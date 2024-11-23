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
        Schema::create('video_metrics', function (Blueprint $table) {
            $table->id();
            $table->text('tiktok_url');
            $table->bigInteger('views')->default(0);
            $table->bigInteger('like')->default(0);
            $table->bigInteger('comment')->default(0);
            $table->bigInteger('share')->default(0);
            $table->bigInteger('save')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_metrics');
    }
};
