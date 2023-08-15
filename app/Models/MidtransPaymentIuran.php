<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidtransPaymentIuran extends Model
{
    use HasFactory;

    protected $table = 'midtrans_payment_iuran';

    protected $fillable = [
        'nim', 'tahun_ajaran_has_iuran_id', 'amount', 'status'
    ];
}
