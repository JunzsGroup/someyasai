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
<?php
  try {


    $PDO = new PDO($dsn, $user, $password); //MySQLのデータベースに接続
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    $id = $_POST['qr'];
    $class = $_POST['class'];
 


    $sql = "INSERT INTO queue (class, code,) VALUES (:class, :code,)"; // INSERT文を変数に格納。:nameや:categoryはプレースホルダという、値を入れるための単なる空箱
    $stmt = $dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    $params = array(':class' => $class, ':code' => $code, ); // 挿入する値を配列に格納する
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

    echo "<p>code: ".$code."</p>";
    echo "<p>class: "$class"</p>";
    echo '<p>で登録しました。</p>'; // 登録完了のメッセージ
  } catch (PDOException $e) {
  exit('データベースに接続できませんでした。' . $e->getMessage());
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
