<?php
require_once("../../../connection.php");
require('../function.php');

if (!isPerm($conn, "PURGE_USER", $UserRankID)) {
    redirect($meta_url);
    exit ;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedIds = $_POST['selectedIds'] ?? [];
    if (!empty($selectedIds)) {
        $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));
        $selectedIds = array_map('intval', $selectedIds);
        $currentUserId = intval($_SESSION['user_id']);
        if (in_array($currentUserId, $selectedIds)) {
            echo json_encode(["status" => "error", "message" => "Kendi hesabınızı silemezsiniz."]);
            exit;
        }
        $sqlPurgeUsers = $conn->prepare("DELETE FROM users WHERE ID IN ($placeholders)");
        if ($sqlPurgeUsers->execute($selectedIds)) {
            $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
            $sqlCreateLog->bindValue(':user_id', $_SESSION['user_id']);
            $sqlCreateLog->bindValue(':time', date('Y-m-d H:i:s'));
            $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
            $sqlCreateLog->bindValue(':typo', "Purge User");
            $sqlCreateLog->bindValue(':content', "$placeholders IDs User Purge");
            $sqlCreateLog->execute();

            echo json_encode(["status" => "success", "message" => "Seçilen Kullanıcılar başarıyla silindi."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Bir hata oluştu, Kullanıcılar silinemedi."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Silmek için Kullanıcı seçmediniz."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Geçersiz istek."]);
}
?>
