<?php

if (!isPerm($conn, "DELETE_USER", $UserRankID)) {
    redirect($meta_url);
    exit;
}

if (isset($_GET["id"])) {
    $userID = $_GET["id"];
if (intval($_SESSION['user_id']) === intval($userID)) {
    redirect($meta_url . "/admin/users?me-delete");
    exit;
}
    $sqlDeleteNews = $conn->prepare("DELETE FROM users WHERE ID = :id");
    $sqlDeleteNews->bindValue(':id', $userID, PDO::PARAM_INT);

    if ($sqlDeleteNews->execute()) {

        $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
        $sqlCreateLog->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $sqlCreateLog->bindValue(':time', date('Y-m-d H:i:s'));
        $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
        $sqlCreateLog->bindValue(':typo', "Delete User");
        $sqlCreateLog->bindValue(':content', $userID . " ID user deleted");

        if ($sqlCreateLog->execute()) {
            redirect($meta_url . "/admin/users?deleteuser");
        } else {
            redirect($meta_url . "/admin/users?errorlog");
        }
    } else {
        redirect($meta_url . "/admin/users?errordelete");
    }
} else {
    redirect($meta_url . "/admin/users");
}
?>
