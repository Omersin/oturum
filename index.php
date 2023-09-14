<?php
include_once ("init.php");
if ($class_pdo->controlToken($_SESSION['auth']))
{
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>İndex</title>
</head>
<body>
    Bilgiler Burada
    <hr>
    <br>
    <a href="logout.php"> Çıkış Yap </a>
</body>
</html>
<?php
}else{
    $class_pdo->yonlendir("./login.php");
}
