<?php 

$err = '';
$errorpsw = "パスワードが違います";
$erroruser = "ユーザー名が違います";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once 'config.php';
    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    
    
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // データベースからユーザー名を検索
    $sql = "SELECT * FROM users WHERE userid = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($row);
    
    if (!$row) {
        $err = 'ユーザーが見つかりません';
    } else if ($row['password'] !== $password) {
        $err = 'パスワードが違います';
    } else {
        // ログイン成功
        
        $_SESSION['username'] = $row['username'];
        $_SESSION['userid'] = $row['userid'];
 

        header('Location: ./', 303);
        exit();
    }

}  
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
<?php if ($err) { ?>
    <p><?= $err ?></p>
<?php } ?>
<form action="" method="post">
    <label for="username">ユーザー名:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">パスワード:</label><br>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="ログイン">
</form>
</body>
</html>