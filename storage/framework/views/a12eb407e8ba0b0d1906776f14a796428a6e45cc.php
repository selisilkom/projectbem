<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi</title>
</head>

<body>
    <div style="border: 1px solid #000; padding: 1rem">
        <table>
            <tr style="text-align: left">
                <td>No</td>
                <td style="padding: 0 1.5rem">:</td>
                <td><?php echo e($pembayaran->id_log_pembayaran); ?></td>
            </tr>
            <tr>
                <td id="ignorePDF">Telah Diterima Dari</td>
                <td style="padding: 0 1.5rem">:</td>
                <td><?php echo e($pembayaran->nama); ?></td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td style="padding: 0 1.5rem">:</td>
                <td><?php echo e($terbilang); ?></td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td style="padding: 0 1.5rem">:</td>
                <td>Pembayaran Iuran</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="padding-left: 3rem; padding-top: 2rem"><?php echo e($pembayaran->tgl_bayar); ?></td>
            </tr>
            <tr>
                <td>Rp. <?php echo e(number_format($pembayaran->jumlah_bayar, 0, '.', '.')); ?></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</body>

</html>
<?php /**PATH /home/tomy/htdocs/matursoft/clients/mhmmdd-bem-pembayaran/resources/views/admin/pages/histori-pembayaran/kuitansi.blade.php ENDPATH**/ ?>