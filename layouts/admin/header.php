<?php
require_once('function.php');
$sqlconfig = "SELECT * FROM config WHERE id = :id";
$sqlconfig = $conn->prepare($sqlconfig);
$sqlconfig->bindValue(':id', "1");
$sqlconfig->execute();
$sqlconfig = $sqlconfig->fetch(PDO::FETCH_ASSOC);

$header_title;
$faviconurl = $sqlconfig["favicon"];
$meta_description = $sqlconfig["description"];
$meta_url = $sqlconfig["URL"];
$PathExtName = basename($_SERVER['SCRIPT_NAME']);
$PathName = ucfirst(str_replace('.php', '', $PathExtName));
if (isset($header_title_second)) {
    $header_title = $sqlconfig["name"] . " - Yönetim Paneli - " . $header_title_second;
} else {
    $header_title = $sqlconfig["name"] . " - Yönetim Paneli - " . $PathName;
}

?>
<!doctype html>
<html lang="<?= $sqlconfig["lang"];?>" data-bs-theme="dark">
<head>
    <link href="../../assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="<?=$faviconurl;?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$meta_description;?>">
    <title><?=$header_title;?></title>
</head>

<?php

if (isset($_SESSION['account']) && $_SESSION['account'] === "active" && isset($_SESSION['user_id'])) {

    if (!isPerm($conn, "SHOW_ADMINPANEL", $UserRankID)) {
        redirect($meta_url);
    }
} else {
    redirect($meta_url);
}
?>

