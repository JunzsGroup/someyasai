<?php
require_once 'config.php';
try {
    $PDO = new PDO($dsn, $user, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT username FROM users";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
    }

} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}

