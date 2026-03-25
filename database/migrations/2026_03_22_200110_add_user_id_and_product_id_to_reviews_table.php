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
        Schema::table('reviews', function (Blueprint $table) {
            // Add id columns into reviews
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->after('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Delete foreign keys first
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            // Then delete id columns
            $table->dropColumn(['user_id', 'product_id']);
        });
    }
};
