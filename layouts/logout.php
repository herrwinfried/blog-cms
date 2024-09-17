<?php

$sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress) VALUES (:user_id, :time, :typo, :ipaddress)");
$sqlCreateLog->bindValue(':user_id', $_SESSION['user_id']);
$sqlCreateLog->bindValue(':time', date("Y-m-d H:i:s"));
$sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
$sqlCreateLog->bindValue(':typo', "Logout");
$sqlCreateLog->execute();

session_destroy();
session_unset();
unset($_SESSION['account']);
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['logged_in']);
?>
<script>
    var metaUrl = <?php echo json_encode($meta_url); ?>;
        window.location.href = metaUrl;
</script>
