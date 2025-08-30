<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('rumah_sakit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rumah_sakit');
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_sakit');
    }
};
