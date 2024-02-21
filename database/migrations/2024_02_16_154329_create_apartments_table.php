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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('city');
            $table->string('street_name');
            $table->double('latitude', 12, 8);
            $table->double('longitude', 12, 8);
            $table->boolean('visibility')->nullable();
            /* $table->text('image_path')->nullable(); */
            $table->string('street_number', 6);
            $table->string('postal_code', 14)->nullable();
            $table->string('country');
            $table->string('country_code');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('apartments');
    }
};
