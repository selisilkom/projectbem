<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidtransPaymentIuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midtrans_payment_iuran', function (Blueprint $table) {
            $table->id();
            $table->char('nim', 20);
            $table->unsignedBigInteger('tahun_ajaran_has_iuran_id');
            $table->integer('amount');
            $table->timestamps();

            //$table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('set null');
            $table->foreign('tahun_ajaran_has_iuran_id')->references('id')->on('tahun_ajaran_has_iuran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('midtrans_payment_iurans');
    }
}
