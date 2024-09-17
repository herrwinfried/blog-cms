<?php
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

if ($PathExtName == 'index.php' && $sqlconfig ["desc_isEnable"] == "1") {
  $header_title = $sqlconfig["name"] ." - " . $sqlconfig["shortdesc"];
} elseif ($PathExtName == 'index.php' && $sqlconfig ["desc_isEnable"] == "0") {
  $header_title = $sqlconfig["name"];
} elseif (isset($header_title_second)) {
  $header_title = $sqlconfig["name"] . " - " . $header_title_second;
} else {
  $header_title = $sqlconfig["name"] . " - " . $PathName;
}

?>
<!doctype html>
<html lang="<?= $sqlconfig["lang"];?>" data-bs-theme="auto">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../assets/css/blog.css">
  <head>
      <link rel="icon" type="image/x-icon" href="<?=$faviconurl;?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$meta_description;?>">
    <title><?=$header_title;?></title>
  </head>



