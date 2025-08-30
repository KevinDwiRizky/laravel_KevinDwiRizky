<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('alamat');
            $table->string('no_telpon', 20);
            $table->unsignedBigInteger('rumah_sakit_id');
            $table->foreign('rumah_sakit_id')->references('id')->on('rumah_sakit')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
