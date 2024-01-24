<?php
$dsn      = 'mysql:dbname=junzs_schoolfes;host=localhost';
$user     = 'junzs_wp1';
$password = 'junzssomeyafes';

/*出場処理していない人数を数える*/
$sql  = "SELECT COUNT(*) As COUNT FROM `queue` WHERE enter IS NOT NULL AND leaving IS NULL;";

/*同じQRコードが2つ かつ どちらも入場していない時　新しいほうを削除
カウントして2以上になる　新しいほうを無効(削除？)にする*/

/*入場できないとき　エラーメッセージ*/

/*入場者のところにidを表示する*/
/* */