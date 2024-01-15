<?php
/*ほかのページでログインに飛ばす

issetで存在の有無を確認
useridがなければログインページにとばす

ログアウト処理
unsetでuseridを消す
ログインページに飛ばす
*/
 require_once 'config.php';
 try {
     $pdo = new PDO($dsn, $user, $password);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
     echo 'Connection failed: ' . $e->getMessage();
 }


session_start();
if(empty($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

echo 'こんにちは！ ' . $_SESSION['username'] . 'さん';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理ページ</title>
</head>
<body>
    <form action="../queue/index.php" method="post">
        <input type="submit" value="待ち行列用">
    </form>
    <form action="../enter/index.php" method="post">
        <input type="submit" value="入場用">
    </form>
    <form action="../leave/index.php" method="post">
        <input type="submit" value="退場用">
    </form>
    <form action="logout.php" method="post">
    <input type="submit" name="logout" value="ログアウト">
</form>
</body>
</html>







