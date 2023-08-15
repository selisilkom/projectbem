<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthContracts;
use Illuminate\Auth\Authenticatable;

class Mahasiswa extends Model implements AuthContracts
{
    use Authenticatable;
    use HasFactory;
    protected $table        = 'mahasiswa';
    protected $primaryKey   = 'nim';
    protected $fillable     = ['nim', 'id_organisasi', 'nama', 'email', 'jenis_kelamin', 'no_telp', 'photo', 'alamat'];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi', 'id_organisasi');
    }
}
