<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Kilitlendi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .bg-blur {
            background: url('{{ asset('/backend/assets/disabled.png') }}') no-repeat center center;
            background-size: cover;
            filter: blur(8px);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            height: 100%;
        }

        .center-card {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
    </style>
</head>
<body>

    <div class="bg-blur"></div>

    <div class="content-wrapper">
        <div class="container center-card">
            <div class="card shadow-lg p-4 text-center">
                <h3 class="card-title mb-3">Panel Kilitlendi</h3>
                <p class="card-text">
                   Sistem yöneticinizle iletişime geçiniz.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
