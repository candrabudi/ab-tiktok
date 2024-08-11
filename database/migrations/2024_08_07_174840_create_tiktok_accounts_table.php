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
        Schema::create('tiktok_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('tiktok_search_id');
            $table->text('tiktok_account_id');
            $table->text('nickname');
            $table->text('unique_id')->nullable();
            $table->text('following')->nullable();
            $table->text('followers')->nullable();
            $table->text('likes')->nullable();
            $table->text('total_video')->nullable();
            $table->text('avatar')->nullable();
            $table->integer('verified')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiktok_accounts');
    }
};
