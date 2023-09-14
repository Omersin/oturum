<?php
include_once ("init.php");
if (isset($_SESSION['auth']))
{
    $class_pdo->yonlendir("./index");
}else{
    if (isset($_POST['email']) && isset($_POST['password']))
        {
           $controlLogin = $class_pdo->control($_POST['email'],$_POST['password']);
           if ($controlLogin != true)
           {
               echo "<script>alert('Bilgilerinizi Kontrol Edin');</script>";
           }
        }
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Giriş Sayfası</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/floating-labels/">
    <link href="https://getbootstrap.com/docs/4.4/examples/floating-labels/floating-labels.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

</head>
<body>
<form method="post" class="form-signin">
    <div class="text-center mb-4">
        <img class="mb-4" src="https://getbootstrap.com/docs/4.4/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Giriş Ekranı</h1>
    </div>

    <div class="form-label-group">
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail">Email Adresi</label>
    </div>

    <div class="form-label-group">
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword">Şifre</label>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Giriş Yap</button>
</form>




<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

<?php
}
