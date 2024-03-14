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
// 読み取られたQRコードのコード
$scannedCode = $_POST['qr'];

// 読み取られたQRコードのユーザーのstart時間を取得
$sql = "SELECT start FROM queue WHERE code = :code AND class = :class";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':code', $scannedCode);
$stmt->bindParam(':class', $class);
$stmt->execute();
$scannedUserStart = $stmt->fetchColumn();

// 読み取られたQRコードの人より先に並んでいる人のみを取得
$sql = "SELECT q.code, q.skipped, c.number
        FROM queue q
        JOIN customer c ON q.code = c.customerid
        WHERE q.class = :class AND q.enter IS NULL AND q.leaving IS NULL AND q.start < :scannedUserStart
        ORDER BY q.start ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':class', $class);
$stmt->bindParam(':scannedUserStart', $scannedUserStart);
$stmt->execute();
$waitingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //skippedの値の定義
    $sql = "SELECT skipped FROM queue WHERE code = :code AND class = :class";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':class', $class);
    $stmt->execute();
    $skipped = $stmt->fetchColumn();

    // QRコードを読み取られたユーザーがスキップ対象かどうかを確認
    $shouldSkip = false;
    foreach ($waitingUsers as $user) {
        if ($user['code'] === $code) {
            $shouldSkip = true;
            $skipped = $user['skipped'];
            break;
        }
    }

    // 一覧の人がskippedが1の人しかいない場合は通常の入場処理を行う
    $hasNonSkippedUsers = false;
    foreach ($waitingUsers as $user) {
        if ($user['skipped'] === null || $user['skipped'] === 2) {
            $hasNonSkippedUsers = true;
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
    } elseif (!$hasNonSkippedUsers) {
        // skippedの値がNULLまたは1の場合は入場処理を行う
        $sql = "UPDATE queue SET enter = NOW() WHERE code = :code AND class = :class AND (skipped IS NULL OR skipped = 1) AND enter IS NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':class', $class);
        $stmt->execute();

        echo "<div class='container'>";
        echo "<p>入場処理が完了しました。</p>";
        echo "<a href='index.php' class='back-btn'>戻る</a>";
        echo "</div>";
    } else {
        echo "<div class='container'>";
        echo "<p>skippedがNULLまたは2の人がいるため、この人の入場処理は行われませんでした。</p>";
        echo "<a href='index.php' class='back-btn'>戻る</a>";
        echo "</div>";
    }

    echo "<h2>読み取られたQRコードの人より早く並んでいた人の一覧</h2>";
    echo "<ul>";
    foreach ($waitingUsers as $user) {
        $customerNumber = $user['number'];
        $isSkipped = ($user['skipped'] !== null) ? '✔' : '';
        echo "<li>$customerNumber $isSkipped";
        if ($user['skipped'] === null) {
            echo " <a href='skip.php?code={$user['code']}' class='skip-btn'>Skip</a>";
        }
        echo "</li>";
    }
    echo "</ul>";

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