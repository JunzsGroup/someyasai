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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>最大収容人数設定ページ（仮）</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
   
    <body class="bg-white">
      <header class="bg-white shadow">
         <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
         <img src="../logotext.jpg" alt="ロゴ" class="w-40 h-auto">
    </nav>
</header>
</body>
</html>