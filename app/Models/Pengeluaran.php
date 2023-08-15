<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table        = 'pengeluaran';
    protected $primaryKey   = 'id_pengeluaran';
    protected $fillable = ['nama_pengeluaran', 'jumlah', 'deskripsi', 'tahun_ajaran_id', 'pdf_file'];
}
