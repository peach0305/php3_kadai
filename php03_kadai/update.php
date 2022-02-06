<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

require_once('funcs.php');
//1. POSTデータ取得
$book_name   = $_POST['book_name'];
$book_URL  = $_POST['book_URL'];
$coment = $_POST['coment'];
$id = $_POST['id'];

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE
                        gs_bm_table
                    SET
                        book_name = :book_name,
                        book_URL = :book_URL,
                        coment = :coment,
                        date = sysdate()
                    WHERE
                        id = :id;
                    ');
// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);
$stmt->bindValue(':book_URL', $book_URL, PDO::PARAM_STR);
$stmt->bindValue(':coment', $coment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}