<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('/admin/assets/css/login.css')); ?>">
    <title>Login Mahasiswa</title>
</head>

<body>
    <div class="container">
        <div class="login-wrapper">
            <div class="bg-people-wrapper bg-login-mahasiswa">
            </div>
            <div class="form-login-wrapper">
                <div class="inner-form-login-wrapper">
                    <form action="" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="logo-text-section">
                            <img src="https://scontent.fjog9-1.fna.fbcdn.net/v/t39.30808-6/327194219_633382468549129_1615301361609007074_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeHlx5zPLYW_a2iyXUXGDeQqqaXrtNhycTyppeu02HJxPHLKKhYmdqK0Z2gUloVcJ6H9SImhygm3dw4srgoMzdsC&_nc_ohc=JTfxjVO2CqQAX975dF9&_nc_oc=AQmPiFbZla-uI1lX6TCL31jZIo8iuIjKqXCGpXtzSIsprCvknD--cfKf3y7-YRxsLeQ&_nc_zt=23&_nc_ht=scontent.fjog9-1.fna&oh=00_AfC_Vc-uSyvHnL2FJgENu3pfeRvg7vmC2-seQXH7yrhRvg&oe=6470A852"
                                alt="logo">
                            <h3>Masuk Mahasiswa</h3>
                        </div>
                        <div class="form-section">
                            <?php if(Session::get('failed')): ?>
                                <div
                                    style="background-color: #FC544B; color: #fff; padding: 10px; font-size: 13px; margin-bottom: 14px; border-radius: 5px">
                                    <?php echo e(Session::get('failed')); ?>

                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <input type="nama" name="nama" id="nama" placeholder="Nama" class=""
                                    value="">
                            </div>
                            <div class="form-group">
                                <input type="nim" name="nim" id="nim" placeholder="NIM" class=""
                                    value="">
                            </div>
                            <div class="form-group">
                                <button type="submit">Masuk</button>
                                <span class="back">Kembali ke <a href="<?php echo e(url('/')); ?>">Halaman Utama</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php /**PATH /home/tomy/htdocs/matursoft/clients/mhmmdd-bem-pembayaran/resources/views/auth/mahasiswa/login.blade.php ENDPATH**/ ?>