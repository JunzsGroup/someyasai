<?php
require_once 'config.php';
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// 平均待ち時間を計算
$sql = "SELECT AVG(TIMESTAMPDIFF(MINUTE, enter, leaving)) AS avg_wait_time
        FROM queue
        WHERE class = '1年1組' AND enter IS NOT NULL AND leaving IS NOT NULL";
$result = $pdo->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$extime = $row["avg_wait_time"];

// 待ち列にいる人数を計算
$sql = "SELECT COUNT(*) AS queue_count
        FROM queue
        WHERE class = '1年1組' AND enter IS NULL AND leaving IS NULL AND start IS NOT NULL";
$result = $pdo->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$queuepeople = $row["queue_count"];

// 総待ち時間を計算
$queuetime = $extime * $queuepeople;

// 結果を表示
echo  '1年1組の待ち時間は'. $queuetime . '分';

// データベース接続の終了
$pdo = null;
?>