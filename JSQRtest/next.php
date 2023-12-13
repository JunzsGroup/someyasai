<?php
echo $_POST['qr'];

if (!isset($_POST['qr'])  ||  $_POST['qr']===''){
    echo 'QRコードが読み取られません';
    exit;
}

$dsn      = 'mysql:dbname=junzs_schoolfes ;host=localhost';
$user     = 'junzs_wp1';
$password = 'junzssomeyafes';

// DBへ接続
try{
    $dbh = new PDO($dsn, $user, $password);

    // クエリの実行
    $query = "SELECT * FROM queue";
    $stmt = $dbh->query($query);

    // 表示処理
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row["name"];
    }

}catch(PDOException $e){
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}

// 接続を閉じる
$dbh = null;

/*$dsn = 'mysql:host=localhost;dbname=dbtest;charset=utf8mb4';
$username = 'dbtestuser';
$password = 'dbtest1user';
$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
$st = $pdo->prepare('SELECT * FROM bbs;');
$st->execute();*/

?>
