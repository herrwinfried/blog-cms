<?php

if (!isPerm($conn, "UPDATE_NEWS", $UserRankID)) {
    redirect($meta_url);
    exit ;
}
if (isset($_GET["id"])) {
    $sqlGetNews = $conn->prepare("SELECT * FROM news WHERE ID = :id");
    $sqlGetNews->bindValue(':id', $_GET["id"]);
    $sqlGetNews->execute();
    $sqlGetNews = $sqlGetNews->fetch(PDO::FETCH_ASSOC);

    if ($sqlGetNews) {
        $GetNews_title = htmlspecialchars($sqlGetNews["title"]);
        $GetNews_short = htmlspecialchars($sqlGetNews["short"]);
        $GetNews_image = htmlspecialchars($sqlGetNews["image"]);
        $GetNews_content = htmlspecialchars($sqlGetNews["content"]);
    } else {
        redirect($meta_url . "/admin/news");
    }
} else {
    redirect($meta_url . "/admin/news");
}
if (isset($_POST["submit"])) {
    $News_title = htmlspecialchars($_POST["newsEdit_title"]);
    $News_short = htmlspecialchars($_POST["newsEdit_short"]);
    $News_image = htmlspecialchars($_POST["newsEdit_image_url"]);
    $News_content = htmlspecialchars($_POST["newsEdit_content"]);
    $News_date = htmlspecialchars(date("Y-m-d H:i:s"));
    $News_author = htmlspecialchars($_SESSION['user_id']);

    $sqlEditNews = $conn->prepare("UPDATE news SET title = :title, short = :short, image = :image, authorid = :authorid, date = :date, content = :content WHERE ID = :id");
    $sqlEditNews->bindValue(':title', $News_title);
    $sqlEditNews->bindValue(':short', $News_short);
    $sqlEditNews->bindValue(':image', $News_image);
    $sqlEditNews->bindValue(':authorid', $News_author);
    $sqlEditNews->bindValue(':date', $News_date);
    $sqlEditNews->bindValue(':content', $News_content);
    $sqlEditNews->bindValue(':id', $_GET["id"]);
    $sqlEditNews->execute();

    if ($sqlEditNews) {

        $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
        $sqlCreateLog->bindValue(':user_id', $News_author);
        $sqlCreateLog->bindValue(':time', $News_date);
        $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
        $sqlCreateLog->bindValue(':typo', "Update News");
        $sqlCreateLog->bindValue(':content', $_GET["id"] . " ID news updated");
        $sqlCreateLog->execute();
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#aalert-danger').text('').fadeOut();
                $('#aalert-success').text('İçerik Düzenlendi').fadeIn();
                setTimeout(function() {
                    window.location.href = window.location.origin + "/admin/news";
                }, 1500)
            });
        </script>
        <?php

    }
}
?>

<main id="adminmenu" class="col-md-9 ms-sm-auto col-lg-10 px-4">
    <div class="card">
        <div class="card-header text-center">
            Yazıyı Düzenle
        </div>
        <form id="editNewsForm" action="" method="POST" onsubmit="tinyMCE.triggerSave(); return true;">
        <div class="card-body">
                <div class="alert alert-success" id="aalert-success" style="display:none;" role="alert">
                </div>
                <div class="alert alert-danger" id="aalert-danger" style="display:none;" role="alert">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg" name="newsEdit_title" id="newsEdit_title" placeholder="Yazı Başlığı Giriniz" required value="<?= $GetNews_title?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="newsEdit_short" id="newsEdit_short" placeholder="Kısa Açıklama giriniz (Anasayfada gözükücek)" required value="<?= $GetNews_short?>">
                </div>
                <div class="mb-3">
                    <label for="newsEdit_image" style="display: none;" class="form-label">Küçük Resim Seçiniz</label>
                    <input type="file" class="form-control" name="newsEdit_image" id="newsEdit_image" style="display: none;" disabled value="<?= $GetNews_image ?>">
                    <input type="text" class="form-control form-control-sm" name="newsEdit_image_url" id="newsEdit_image_url" placeholder="Resim URL'si" required value="<?= $GetNews_image ?>">
                </div>
                <div class="mb-3">
                    <textarea id="newsEdit_content" name="newsEdit_content"><?= $GetNews_content ?></textarea>
                </div>

            </div>
            <div class="card-footer text-body-secondary text-end">
                <button type="submit" id="submitButton" name="submit" class="btn btn-warning">Yazıyı Düzenle</button>
            </div>
        </form>
    </div>
</main>
<script src="../../../assets/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#newsEdit_content',
        language: 'tr',
        license_key: 'gpl',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
    });
</script>
