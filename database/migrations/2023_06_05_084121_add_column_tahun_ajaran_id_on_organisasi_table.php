<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTahunAjaranIdOnOrganisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organisasi', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->after('id_organisasi');

            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisasi', function (Blueprint $table) {
            //
        });
    }
}
