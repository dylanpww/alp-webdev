<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('total_price');
            $table->boolean('extra_bed')->default(false);

            $table->string('status')->default('pending');
            $table->string('type');

            $table->string('notes')->nullable();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->foreignId('room_id')
                ->nullable()
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->foreignId('type_id')
                ->nullable()
                ->constrained('types')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('rental_id')
                ->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
