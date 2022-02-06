<?php
require_once('funcs.php');
//1. POSTデータ取得
$book_name = $_POST['book_name'];
$book_URL = $_POST['book_URL'];
$coment = $_POST['coment'];

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, book_name, book_URL, coment,date)
VALUES(:book_name, :book_URL, :coment,sysdate())");

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);
$stmt->bindValue(':book_URL', $book_URL, PDO::PARAM_STR);
$stmt->bindValue(':coment', $coment, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    redirect('index.php');
}
