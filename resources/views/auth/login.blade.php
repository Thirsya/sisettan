<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="assetsLogin/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assetsLogin/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assetsLogin/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="assetsLogin/css/iofrm-theme6.css">
</head>

<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="{{ route('landing-page') }}">
                <div class="logo">
                    <img class="logo-size" src="images/regis.png" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="assetsLogin/images/graphic2.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Sistem Lelang Tanah</h3>
                        <p>Kota Kediri</p>
                        <div class="page-links">
                            <a href="login6.html" class="active">Login</a>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                name="username" placeholder="E-mail Address" required>
                            @error('username')
                                <div class="alert alert-danger mt-2">
                                    <div>{{ $message }}</div>
                                </div>
                            @enderror
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            @error('password')
                                <div class="alert alert-danger mt-2">
                                    <div>{{ $message }}</div>
                                </div>
                            @enderror
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assetsLogin/js/jquery.min.js"></script>
    <script src="assetsLogin/js/popper.min.js"></script>
    <script src="assetsLogin/js/bootstrap.min.js"></script>
    <script src="assetsLogin/js/main.js"></script>
</body>

</html>
