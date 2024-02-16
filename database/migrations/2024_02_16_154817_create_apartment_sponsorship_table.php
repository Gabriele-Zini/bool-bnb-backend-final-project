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
        Schema::create('apartment_sponsorship', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->unsignedBigInteger('sponsorship_id');
            $table->unsignedBigInteger('apartment_id');
            $table->foreign('sponsorship_id')->references('id')->on('sponsorships')->cascadeOnDelete();
            $table->foreign('apartment_id')->references('id')->on('apartments')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartment_sponsorship', function (Blueprint $table) {
            $table->dropForeign(['sponsorship_id']);
        });
        Schema::table('apartment_sponsorship', function (Blueprint $table) {
            $table->dropForeign(['apartment_id']);
        });
        Schema::dropIfExists('apartment_sponsorship');
    }
};
