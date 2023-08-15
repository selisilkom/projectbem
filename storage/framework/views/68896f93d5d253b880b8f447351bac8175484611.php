<!DOCTYPE html>
<html>

<head>
    <title>Laporan Histori Pembayaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan Histori Pembayaran</h4>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pembayaran</th>
                <th>Petugas</th>
                <th>Mahasiswa</th>
                <th>Tgl Bayar</th>
                <th>Jumlah Bayar</th>
                <th>Iuran Tahun</th>
                <th>Iuran Semester</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1 ?>
            <?php $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i); ?></td>
                    <td><?php echo e((string) $pembayaran->id_log_pembayaran); ?></td>
                    <td><?php echo e($pembayaran->nama_petugas); ?></td>
                    <td><?php echo e($pembayaran->nama); ?></td>
                    <td><?php echo e($pembayaran->tgl_bayar); ?></td>
                    <td>Rp. <?php echo e(number_format($pembayaran->jumlah_bayar, 0, '.', '.')); ?></td>
                    <td><?php echo e(\App\Models\TahunAjaran::findActivedTahunAjaran()->start_year); ?> / <?php echo e(\App\Models\TahunAjaran::findActivedTahunAjaran()->end_year); ?></td>
                    <td><?php echo e($pembayaran->semester); ?></td>
                </tr>

                <?php $i++ ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>

</html>
<?php /**PATH /home/tomy/htdocs/matursoft/clients/mhmmdd-bem-pembayaran/resources/views/admin/pages/histori-pembayaran/cetak-pembayaran.blade.php ENDPATH**/ ?>