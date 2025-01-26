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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('janji_temu_id');
            $table->string('keluhan')->nullable();
            $table->string('diagnosa')->nullable();
            $table->string('tindakan')->nullable();
            $table->string('obat')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('nomor_antrian');
            $table->enum('status_rawat', ['menginap', 'pulang', 'boleh pulang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
