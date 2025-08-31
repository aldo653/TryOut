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
        Schema::create('kehadiran__jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity_byjadwal_id');
            $table->foreign('quantity_byjadwal_id')->references('id')->on('quanty_byjadwals')->onDelete('cascade');
            $table->unsignedBigInteger('mhs_id');
            $table->foreign('mhs_id')->references('mhs_id')->on('memberjadwal')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran__jadwal');
    }
};
