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

    // 待ち行列のユーザー情報を取得 (skippedの値が1または2のみ)
    $sql = "SELECT code, skipped FROM queue WHERE class = :class AND enter IS NULL AND leaving IS NULL AND skipped IN (1, 2) ORDER BY start ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $waitingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // QRコードを読み取られたユーザーがスキップ対象かどうかを確認
    $shouldSkip = false;
    foreach ($waitingUsers as $user) {
        if ($user['code'] === $code) {
            $shouldSkip = true;
            $skipped = $user['skipped'];
            break;
        }
    }

    if ($shouldSkip) {
        if ($skipped === 1) {
            echo "<div class='container'>";
            echo "<p>このユーザーはスキップされています。指定された時間にお越しください。</p>";
            echo "<a href='index.php' class='back-btn'>戻る</a>";
            echo "</div>";
        } else {
            // skipped=2の場合は入場処理
            $sql = "UPDATE queue SET enter = NOW() WHERE code = :code AND class = :class AND skipped = 2 AND enter IS NULL";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':class', $class);
            $stmt->execute();
    
            echo "<div class='container'>";
            echo "<p>入場処理が完了しました。</p>";
            echo "<a href='index.php' class='back-btn'>戻る</a>";
            echo "</div>";
        }
    } else {
        // skippedの値がNULLの場合は入場処理を行う
        $sql = "UPDATE queue SET enter = NOW() WHERE code = :code AND class = :class AND skipped IS NULL AND enter IS NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':class', $class);
        $stmt->execute();
    
        echo "<div class='container'>";
        echo "<p>入場処理が完了しました。</p>";
        echo "<a href='index.php' class='back-btn'>戻る</a>";
        echo "</div>";
    }
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>入場処理</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
</body>
</html>