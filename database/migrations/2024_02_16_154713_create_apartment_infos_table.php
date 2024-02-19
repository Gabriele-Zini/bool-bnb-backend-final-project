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
        Schema::create('apartment_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('num_rooms')->nullable();
            $table->unsignedTinyInteger('num_beds')->nullable();
            $table->unsignedTinyInteger('num_bathrooms')->nullable();
            $table->unsignedSmallInteger('mt_square')->nullable();
            $table->unsignedBigInteger('apartment_id');
            $table->foreign('apartment_id')->references('id')->on('apartments')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartment_infos', function (Blueprint $table) {
            $table->dropForeign(['apartment_id']);
        });
        Schema::dropIfExists('apartment_infos');
    }
};
