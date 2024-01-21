<?php
require_once 'config.php';

function calculateWaitTime($pdo, $class) {
    $sql = "SELECT AVG(TIMESTAMPDIFF(MINUTE, enter, leaving)) AS avg_wait_time
            FROM queue
            WHERE class = :class AND enter IS NOT NULL AND leaving IS NOT NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':class' => $class]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $avgWaitTime = $row["avg_wait_time"];
    $sql = "SELECT COUNT(*) AS queue_count
            FROM queue
            WHERE class = :class AND enter IS NULL AND leaving IS NULL AND start IS NOT NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':class' => $class]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $queueCount = $row["queue_count"];

    $totalWaitTime = $avgWaitTime * $queueCount;


    echo '<div class="wait-time">' . $class . 'の待ち時間は' . $totalWaitTime . '分<br> </div>';
}

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 全クラスの待ち時間を計算
    for ($year = 1; $year <= 3; $year++) {
        for ($class = 1; $class <= 7; $class++) {
            calculateWaitTime($pdo, $year . '年' . $class . '組');
        }
    }
    $pdo = null;
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.wait-time {
    background-color: #ffffff;
    border-left: 5px solid #5cb85c; /* Greenish color for visual cue */
    margin-bottom: 10px;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    font-size: 1rem; /* Base font size */
}

.wait-time:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Responsive typography and layout adjustments */
@media (max-width: 768px) {
    .wait-time {
        padding: 8px;
        font-size: 0.9rem; /* Slightly smaller font size for tablets */
    }
}

@media (max-width: 480px) {
    .wait-time {
        padding: 6px;
        font-size: 0.8rem; /* Even smaller font size for mobile phones */
        border-left-width: 3px; /* Thinner border for smaller screens */
    }
}
</style>
    <title>各出し物の待ち時間</title>
</head>
<body>

</html>