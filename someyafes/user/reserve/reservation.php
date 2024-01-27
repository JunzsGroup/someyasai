<?php
require_once 'config.php';
try {
    $PDO = new PDO($dsn, $user, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT username FROM users";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerid = $_POST['customerid'];
    $class = $_POST['class'];
    $time = $_POST['enter_time'];

    $sql = "INSERT INTO reserve (id, class, time) VALUES (:customerid, :class, :time)";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':customerid', $customerid, PDO::PARAM_STR);
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約</title>
</head>
<body>
    <h2><?php echo $class; ?>で<?php echo $time; ?>の時間にお待ちしております。入場の際はQRコードを提示してください。</h2>
</body>
</html>