<?php

if (!isPerm($conn, "UPDATE_CONF", $UserRankID)) {
    redirect($meta_url);
    exit;
}

$sqlGetConf = $conn->prepare("SELECT * FROM config WHERE ID = :id");
$sqlGetConf->bindValue(':id', 1);
$sqlGetConf->execute();
$sqlGetConf = $sqlGetConf->fetch(PDO::FETCH_ASSOC);

$GetConf_name = $sqlGetConf['name'];
$GetConf_url = $sqlGetConf['URL'];
$GetConf_favicon = $sqlGetConf['favicon'];
$GetConf_shortdescription = $sqlGetConf['shortdesc'];
$GetConf_shortdescription_check = $sqlGetConf['desc_isEnable'];
$GetConf_description = $sqlGetConf['description'];
$GetConf_lang = $sqlGetConf['lang'];

if (isset($_POST["submit"])) {
    $name = $_POST['conf_name'];
    $url = $_POST['conf_url'];
    $favicon = $_POST['conf_favicon'];
    $shortdesc = $_POST['conf_shortdesc'];
    $shortdesc_check = isset($_POST['conf_shortdesc_check']) ? 1 : 0;
    $desc = $_POST['conf_desc'];
    $lang = $_POST['conf_lang'];

    $sqlUpdate = $conn->prepare("UPDATE config SET name = :name, URL = :url, favicon = :favicon, shortdesc = :shortdesc, desc_isEnable = :shortdesc_check, description = :description, lang = :lang WHERE ID = :id");
    $sqlUpdate->bindValue(':name', $name);
    $sqlUpdate->bindValue(':url', $url);
    $sqlUpdate->bindValue(':favicon', $favicon);
    $sqlUpdate->bindValue(':shortdesc', $shortdesc);
    $sqlUpdate->bindValue(':shortdesc_check', $shortdesc_check);
    $sqlUpdate->bindValue(':description', $desc);
    $sqlUpdate->bindValue(':lang', $lang);
    $sqlUpdate->bindValue(':id', 1);
    $sqlUpdate->execute();
if ($sqlUpdate) {

    $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
    $sqlCreateLog->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $sqlCreateLog->bindValue(':time', date('Y-m-d H:i:s'));
    $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
    $sqlCreateLog->bindValue(':typo', "Conf");
    $sqlCreateLog->bindValue(':content', $_GET["id"] . " ID conf updated");
    $sqlCreateLog->execute();
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#aalert-danger').text('').fadeOut();
            $('#aalert-success').text('Ayarlar Güncellendi').fadeIn();
            setTimeout(function() {
                window.location.href = window.location.origin + "/admin/index";
            }, 1500)
        });
    </script>
<?php
}}
?>

<main id="adminmenu" class="col-md-9 ms-sm-auto col-lg-10 px-4">
    <div class="card">
        <div class="card-header text-center">
            Ayarlar
        </div>
        <form id="ConfForm" action="" method="POST">
            <div class="card-body">
                <div class="alert alert-success" id="aalert-success" style="display:none;" role="alert">
                </div>
                <div class="alert alert-danger" id="aalert-danger" style="display:none;" role="alert">
                </div>

                <div class="mb-3">
                    <label for="conf_name" class="col-form-label required-form">Website Adı</label>
                    <input type="text" class="form-control" name="conf_name" id="conf_name" placeholder="Website Adı" required value="<?= htmlspecialchars($GetConf_name) ?>">
                </div>
                <div class="mb-3">
                    <label for="conf_url" class="col-form-label required-form">Website URL</label>
                    <input type="text" class="form-control" name="conf_url" id="conf_url" placeholder="https://localhost" required value="<?= htmlspecialchars($GetConf_url) ?>">
                </div>
                <div class="mb-3">
                    <label for="conf_favicon" class="col-form-label required-form">Favicon</label>
                    <input type="text" class="form-control" name="conf_favicon" id="conf_favicon" placeholder="https://localhost/favicon.ico" required value="<?= htmlspecialchars($GetConf_favicon) ?>">
                </div>
                <div class="mb-3">
                    <label for="conf_shortdesc" class="col-form-label required-form">Site İsmin Yanında gözükcek kısa açıklama</label>
                    <input type="text" class="form-control" name="conf_shortdesc" id="conf_shortdesc" placeholder="Kişisel Blog Websitesi" required value="<?= htmlspecialchars($GetConf_shortdescription) ?>">
                </div>
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="conf_shortdesc_check" name="conf_shortdesc_check" <?= $GetConf_shortdescription_check ? 'checked' : '' ?>>
                    <label class="form-check-label" for="conf_shortdesc_check">Site isminin yanında kısa açıklama gözüksün</label>
                </div>
                <div class="mb-3">
                    <label for="conf_desc" class="col-form-label required-form">meta açıklama (SEO için)</label>
                    <input type="text" class="form-control" name="conf_desc" id="conf_desc" placeholder="Kişisel Blog Websitesi" required value="<?= htmlspecialchars($GetConf_description) ?>">
                </div>

                <div class="mb-3">
                    <label for="conf_lang" class="col-form-label required-form">HTML Dil</label>
                    <input type="text" class="form-control" name="conf_lang" id="conf_lang" placeholder="tr" required value="<?= htmlspecialchars($GetConf_lang) ?>">
                </div>

            </div>
            <div class="card-footer text-body-secondary text-end">
                <button type="submit" id="submitButton" name="submit" class="btn btn-warning">Düzenle</button>
            </div>
        </form>
    </div>
</main>
