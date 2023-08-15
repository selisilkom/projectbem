<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/landing.css') }}">
    <title>Aplikasi Pembayaran Iuran</title>
</head>

<body>
    <div class="container">
        <div class="text-hero">
            <h2>Website Pembayaran Iuran Dana Bem</h2>
            <h1>SIPIUD</h1>
            <p>SIPIUD adalah website pembayaran dana iuran BEM Unda University</p>
            <div class="button-wrapper">
                <a href="{{ url('/app-admin/login') }}">Login Petugas</a>
                <a href="{{ url('/mahasiswa/login') }}">Login Mahasiswa</a>
            </div>
        </div>
        <div class="image-hero">
            <img src="{{ asset('/images/web/hero.png') }}" alt="">
        </div>
    </div>
</body>

</html>
