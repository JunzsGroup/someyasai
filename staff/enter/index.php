<?php 

require_once 'config.php';

try {
    $PDO = new PDO($dsn, $user, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM `class`";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());

}
session_start();
if(empty($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit();
}

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>入場用</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <img src="../logo.png" alt="ロゴ" class="logo">
            <div id="wrapper">
            <video id="video" autoplay muted playsinline></video>
            <canvas id="camera-canvas"></canvas>
            <canvas id="rect-canvas"></canvas><br>
        </div>
        <div class="form">
        <form action="next.php"  method="POST">
            QRコード: <input type="text" id="qr-msg" name="qr" value="">
　　　　  <select name ="class">
				<option value="0" disabled>クラス名を入力</option>
        </div>

<?php
foreach ($rows as $k => $v) { ?>
				<option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
    <?php } ?>
　　　　  </select>
            <input type="submit">
        </form>
        <script src="./jsQR.js"></script>
    <script src="./script.js"></script>
    <script>
/*
document.getElementById('qr-msg').addEventListener('change', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'サーバーURL');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200 && xhr.responseText != 'qr-msg') {
                    alert('Something went wrong.  Name is now ' + xhr.responseText);
                }
                else if (xhr.status != 200) {
                    alert('Request failed.  Returned status of ' + xhr.status);
                }
            };
            xhr.send(encodeURI('name=' + document.getElementById('qr-msg').value));
        });
*/
    </script>
</body>
</html>
