<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use App\Models\TahunAjaranHasIuran;
use Illuminate\Database\Seeder;

class TahunAjaranHasIuranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tahunAjaran = TahunAjaran::first();

        TahunAjaranHasIuran::create([
            'tahun_ajaran_id' => $tahunAjaran->id,
            'semester' => 'UAS',
            'nominal' => 50000,
        ]);
    }
}
