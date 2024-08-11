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
        Schema::create('tiktok_account_videos', function (Blueprint $table) {
            $table->id();
            $table->integer('tiktok_account_id');
            $table->text('aweme_id');
            $table->text('video_id');
            $table->text('region');
            $table->text('title');
            $table->text('cover');
            $table->text('duration');
            $table->text('play');
            $table->text('play_count');
            $table->text('digg_count');
            $table->text('comment_count');
            $table->text('share_count');
            $table->text('download_count');
            $table->text('collect_count');
            $table->text('create_time');
            $table->text('is_top');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiktok_account_videos');
    }
};
