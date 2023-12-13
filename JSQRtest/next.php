<?php
echo $_POST['qr'];

if (!isset($_POST['qr'])  ||  $_POST['qr']===''){
    echo 'QRコードが読み取られません';
    exit;
}

$dsn = 'mysql:host=localhost;dbname=dbtest;charset=utf8mb4';
$username = 'dbtestuser';
$password = 'dbtest1user';
$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
$st = $pdo->prepare('SELECT * FROM bbs;');
$st->execute();
?>