<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'start_year', 'end_year', 'is_active'
    ];

    public static function findActivedTahunAjaran()
    {
        return TahunAjaran::where('is_active', true)->first();
    }
}
