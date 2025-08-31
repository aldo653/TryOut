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
        Schema::create('quanty_byjadwals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_pengampu_id');
            $table->foreign('jadwal_pengampu_id')->references('id')->on('jadwal_pengampu')->onDelete('cascade');
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quanty_byjadwals');
    }
};
