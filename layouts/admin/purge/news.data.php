<?php
require_once("../../../connection.php");
require('../function.php');

if (!isPerm($conn, "PURGE_NEWS", $UserRankID)) {
    redirect($meta_url);
    exit ;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedIds = $_POST['selectedIds'] ?? [];
    if (!empty($selectedIds)) {
        $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));
        $sqlPurgeNews = $conn->prepare("DELETE FROM news WHERE ID IN ($placeholders)");

        if ($sqlPurgeNews->execute($selectedIds)) {
            $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
            $sqlCreateLog->bindValue(':user_id', $_SESSION['user_id']);
            $sqlCreateLog->bindValue(':time', date('Y-m-d H:i:s'));
            $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
            $sqlCreateLog->bindValue(':typo', "Purge News");
            $sqlCreateLog->bindValue(':content', "$placeholders IDs News Purge");
            $sqlCreateLog->execute();

            echo json_encode(["status" => "success", "message" => "Seçilen Yazılar başarıyla silindi."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Bir hata oluştu, Yazılar silinemedi."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Silmek için yazı seçmediniz."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Geçersiz istek."]);
}
?>
