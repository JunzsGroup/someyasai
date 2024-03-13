<?php
require_once 'config.php';
session_start();

if (empty($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit();
}

if (!isset($_POST['qr']) || $_POST['qr'] === '') {
    echo 'QRコードが読み取られません';
    exit;
}

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $code = $_POST['qr'];
    $class = $_SESSION['username'];

    // QRコードを読み取られたユーザーのIDをstartのDBに送る
    $sql = "UPDATE queue SET enter = NOW() WHERE code = :code AND class = :class";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':class', $class);
    $stmt->execute();

    echo "入場処理が完了しました。";
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
?>