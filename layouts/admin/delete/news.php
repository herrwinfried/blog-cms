<?php

if (!isPerm($conn, "DELETE_NEWS", $UserRankID)) {
    redirect($meta_url);
    exit;
}

if (isset($_GET["id"])) {
    $newsID = $_GET["id"];

    $sqlDeleteNews = $conn->prepare("DELETE FROM news WHERE ID = :id");
    $sqlDeleteNews->bindValue(':id', $newsID, PDO::PARAM_INT);

    if ($sqlDeleteNews->execute()) {

        $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
        $sqlCreateLog->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $sqlCreateLog->bindValue(':time', date('Y-m-d H:i:s'));
        $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
        $sqlCreateLog->bindValue(':typo', "Delete News");
        $sqlCreateLog->bindValue(':content', $newsID . " ID News deleted");

        if ($sqlCreateLog->execute()) {
            redirect($meta_url . "/admin/news?deletenews");
        } else {
            redirect($meta_url . "/admin/news?errorlog");
        }
    } else {
        redirect($meta_url . "/admin/news?errordelete");
    }
} else {
    redirect($meta_url . "/admin/news");
}
?>
