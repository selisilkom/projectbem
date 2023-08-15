<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->string('id_pembayaran', 30);
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->unsignedBigInteger('tahun_ajaran_has_iuran_id');
            $table->char('nim', 20)->nullable();
            $table->integer('total_bayar');
            $table->enum('status', ['Lunas', 'Belum Lunas']);
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('set null');;
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran');
            $table->foreign('tahun_ajaran_has_iuran_id')->references('id')->on('tahun_ajaran_has_iuran');
            $table->primary('id_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
