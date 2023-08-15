<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\Organisasi;
use App\Models\TahunAjaran;
use App\Rules\ValidImportMahasiswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collections)
    {
        Validator::make($collections->toArray(), [
            '*.kelas'           => ['required', 'max:100', 'exists:organisasi,nama_organisasi', new ValidImportMahasiswa],
            '*.nim'             => 'required|max:100|unique:mahasiswa,nim',
            '*.nama'            => 'required|max:50',
            '*.email'           => 'required|email:dns|max:50',
            '*.jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            '*.no_telp'         => 'required|max:16',
            '*.alamat'          => 'required',
            '*.photo'           => 'mimes:jpg,jpeg,png,svg,bmp|nullable'
        ])->validate();

        foreach ($collections as $collection) {
            Mahasiswa::create([
                'nim'           => $collection['nim'],
                'email'         => $collection['email'],
                'nama'          => $collection['nama'],
                'jenis_kelamin' => $collection['jenis_kelamin'],
                'no_telp'       => $collection['no_telp'],
                'alamat'        => $collection['alamat'],
                'photo'         => null,
                'id_organisasi' => Organisasi::where('nama_organisasi', $collection['kelas'])->where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->first()->id_organisasi,
            ]);
        }
    }
    public function chunkSize(): int
    {
        return 50;
    }
}
