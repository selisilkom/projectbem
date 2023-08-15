<?php

namespace App\Helpers;

use App\Mail\EmailNotification;
use Illuminate\Support\Facades\Mail;

class SendEmailHelper
{
    public static function sendEmail($mahasiswa, $nominal, $semester, $tahunAjaran)
    {
        $email_content = [
            'title' => 'Email Notification',
            'body_name' => 'Halo ' . $mahasiswa->nama . ',',
            'body' => 'Diberitahukan bahwa anda belum membayar iuran ' . $mahasiswa->nama_organisasi . ' untuk ' . $semester . ' tahun ajaran ' . $tahunAjaran->start_year . ' / ' . $tahunAjaran->end_year  . ' sebesar :',
            'nominal' => 'Rp. ' . number_format($nominal, 0, '.', '.'),
        ];

        Mail::to($mahasiswa->email)->send(new EmailNotification($email_content));
    }
}
