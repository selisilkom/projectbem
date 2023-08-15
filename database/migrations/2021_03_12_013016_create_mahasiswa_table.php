<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->char('nim', 20);
            $table->unsignedBigInteger('id_organisasi');
            $table->string('nama', 50);
            $table->string('email')->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_telp', 16);
            $table->string('photo')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();

            $table->primary('nim');
            $table->foreign('id_organisasi')->references('id_organisasi')->on('organisasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
