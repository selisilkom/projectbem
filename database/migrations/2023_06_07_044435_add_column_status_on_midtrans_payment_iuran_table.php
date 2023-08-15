<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusOnMidtransPaymentIuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('midtrans_payment_iuran', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted'])->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('midtrans_payment_iuran', function (Blueprint $table) {
            //
        });
    }
}
