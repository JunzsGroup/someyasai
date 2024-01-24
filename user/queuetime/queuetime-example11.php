<?php
require_once 'config.php';
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
$sql = <<<EOQ
SELECT username, T.avg_enjoy_time
from junzs_login.users left join (
    SELECT class, AVG(TIMESTAMPDIFF(MINUTE, enter, leaving)) AS avg_enjoy_time
        FROM junzs_schoolfes.queue WHERE enter IS NOT NULL AND leaving IS NOT NULL
        GROUP BY class
    ) as T
    on junzs_login.users.username = T.class;
EOQ;
$result = $pdo->query($sql);
$extimes = $result->fetchAll(PDO::FETCH_ASSOC);


/*$sql = <<<SQL
SELECT COUNT(*) AS queue_people_count
        FROM queue
        WHERE  enter IS NULL AND leaving IS NULL AND start IS NOT NULL
        GROUP BY class;
SQL;
$result = $pdo->query($sql);
$queuepeoples = $result->fetchAll(PDO::FETCH_ASSOC);
*/

$sql = <<<queti
SELECT username, Q.queue_people_count, T.avg_enjoy_time * Q.queue_people_count AS queuetime
FROM junzs_login.users LEFT JOIN (
    SELECT class, AVG(TIMESTAMPDIFF(MINUTE, enter, leaving)) AS avg_enjoy_time
    FROM junzs_schoolfes.queue WHERE enter IS NOT NULL AND leaving IS NOT NULL
    GROUP BY class
) AS T ON junzs_login.users.username = T.class
LEFT JOIN (
    SELECT class, COUNT(*) AS queue_people_count
    FROM queue
    WHERE enter IS NULL AND leaving IS NULL AND start IS NOT NULL
    GROUP BY class
) AS Q ON junzs_login.users.username = Q.class;

queti;
$result = $pdo->query($sql);
$queuetimes = $result->fetchAll(PDO::FETCH_ASSOC);

$sql = <<<WPURL
SELECT username, url AS wpurls
FROM users;
WPURL;
$result = $pdo->query($sql);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
$wpurls = array_column($rows, 'wpurls', 'username');
//var_dump($wpurls);



//$queuetime = $extime * $queuepeople;
//ここに総待ち時間の計算

//echo  '1年1組の待ち時間は'. $queuetime . '分';


$pdo = null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        ul.cardlist {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        ul.cardlist >li {
            margin: 40px 1em;
            padding: 0;
            box-shadow: 5px 10px 20px rgba(0,0,0,0.25);

        }
        ul.cardlist > li > a {
            border: 1px solid black;
            border-radius: 8px;
            display: flex;
            flex-flow: row nowrap;
            justify-content: stretch;
            text-decoration: none;
            color: black;

        }

        ul.cardlist > li > a >img{
            width: 150px;
            height: 150px;
            object-fit: cover;
        }    

        .content {
            margin-left: 20px;
        }
        .classname {
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 0;
        }
        .waittime {
            margin-top: 10px;
        }
        .waitpeople {
            margin-top: 5px;
        }
        .logo {
        height: 100px; /* ロゴの高さ実質ここでロゴの大きさを指定 */
        width: auto; /* 幅は自動調整 */
        margin-left: 20px; /* 左の余白 */
    }
      </style>
    <title>待ち時間</title>
    <img src="../logo.png" alt="ロゴ" class="logo">
</head>
<body>

    <ul class="cardlist">
        
<?php foreach ($queuetimes as $queuetime){ ?>

    <li>
    <a href="<?= $wpurls[$queuetime['username']] ?>">
            <img src="https://placehold.jp/600x400.png" alt="">
            <div class="content">
            <p class="classname"><?= $queuetime['username'] ?></p>
            <p class="waittime">待ち時間<?= is_null($queuetime['queuetime']) ? '0' : intval($queuetime['queuetime']) ?>分</p>
            <P class="waitpeople">待ち人数<?= is_null($queuetime['queue_people_count']) ? '0' : $queuetime['queue_people_count'] ?>人</P>
            </div>
        </a>
   </li>

<?php } ?>

    </ul>

</body>
</html>