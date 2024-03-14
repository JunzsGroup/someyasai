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

    // 待ち行列のユーザー情報を取得
    $sql = "SELECT code, start FROM queue WHERE class = :class AND enter IS NULL AND leaving IS NULL ORDER BY start ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $waitingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // QRコードを読み取られたユーザーの前に待ち行列に並んでいるユーザーがいるかどうかを検査
    $shouldSkip = false;
    $skipList = [];
    foreach ($waitingUsers as $user) {
        if ($user['code'] === $code) {
            $shouldSkip = true;
            break;
        }
        $skipList[] = $user['code'];
    }

    if ($shouldSkip) {
        // QRコードを読み取られたユーザーがスキップ対象かどうかを確認
        $sql = "SELECT skipped FROM queue WHERE code = :code AND class = :class";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':class', $class);
        $stmt->execute();
        $skipped = $stmt->fetchColumn();

        if ($skipped) {
            echo "<div class='container'>";
            echo "<p>このユーザーはスキップされています。指定された時間にお越しください。</p>";
            echo "<a href='index.php' class='back-btn'>戻る</a>";
            echo "</div>";
        } else {
            echo "<div class='container'>";
            echo "<p>以下のユーザーよりも後に並んでいます:</p>";
            echo "<ul>";
            foreach ($skipList as $index => $userCode) {
                echo "<li>$userCode <a href='skip.php?code=$userCode'>スキップ</a></li>";
            }
            echo "</ul>";
            echo "<a href='index.php' class='back-btn'>戻る</a>";
            echo "</div>";
        }
    } else {
        // QRコードを読み取られたユーザーの入場処理
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