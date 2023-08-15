<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaranHasIuran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran_has_iuran';

    protected $fillable = ['tahun_ajaran_id', 'semester', 'nominal'];
}
