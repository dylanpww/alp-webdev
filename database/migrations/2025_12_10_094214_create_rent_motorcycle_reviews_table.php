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
        Schema::create('rent_motorcycle_reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('rent_motorcycle_id'); // ID Motor
        $table->integer('rating'); // 1 sampai 5
        $table->text('comment')->nullable();
        $table->timestamps();

        // Relasi (Optional tapi bagus untuk data integrity)
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // $table->foreign('rent_motorcycle_id')->references('id')->on('rent_motorcycles')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_motorcycle_reviews');
    }
};
