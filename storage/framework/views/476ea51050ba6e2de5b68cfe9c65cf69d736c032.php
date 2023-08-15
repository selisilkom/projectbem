<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('/admin/assets/css/landing.css')); ?>">
    <title>Aplikasi Pembayaran Iuran</title>
</head>

<body>
    <div class="container">
        <div class="text-hero">
            <h2>Aplikasi Pembayaran Iuran</h2>
            <h1>MBAYAR Iuran</h1>
            <p>Mbayar Iuran adalah aplikasi pembayaran iuran nomor 1 di Indonesia. Telah digunakan dan dipercaya oleh 1
                orang di Indonesia</p>
            <div class="button-wrapper">
                <a href="<?php echo e(url('/app-admin/login')); ?>">Login Petugas</a>
                <a href="<?php echo e(url('/mahasiswa/login')); ?>">Login Mahasiswa</a>
            </div>
        </div>
        <div class="image-hero">
            <img src="<?php echo e(asset('/images/web/hero.png')); ?>" alt="">
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\mhmmdd-bem-pembayaran\resources\views/welcome.blade.php ENDPATH**/ ?>