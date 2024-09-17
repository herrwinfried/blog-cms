<?php

if (!isPerm($conn, "NEW_NEWS", $UserRankID)) {
    redirect($meta_url);
    exit ;
}

if (isset($_POST["submit"])) {
    $News_title = htmlspecialchars($_POST["newsCreate_title"]);
    $News_short = htmlspecialchars($_POST["newsCreate_short"]);
    $News_image = htmlspecialchars($_POST["newsCreate_image_url"]);
    $News_content = htmlspecialchars($_POST["newsCreate_content"]);
    $News_date = htmlspecialchars(date("Y-m-d H:i:s"));
    $News_author = htmlspecialchars($_SESSION['user_id']);

    $sqlCreateNews = $conn->prepare("INSERT INTO news (title, short, image, authorid, date, content) VALUES (:title, :short, :image, :authorid, :date, :content)");
    $sqlCreateNews->bindValue(':title', $News_title);
    $sqlCreateNews->bindValue(':short', $News_short);
    $sqlCreateNews->bindValue(':image', $News_image);
    $sqlCreateNews->bindValue(':authorid', $News_author);
    $sqlCreateNews->bindValue(':date', $News_date);
    $sqlCreateNews->bindValue(':content', $News_content);
    $sqlCreateNews->execute();

    if ($sqlCreateNews) {
        $sqlNewsCheck = $conn->prepare("SELECT * FROM news WHERE title = :title AND date = :date AND authorid = :authorid");
        $sqlNewsCheck->bindValue(':title', $News_title);
        $sqlNewsCheck->bindValue(':date', $News_date);
        $sqlNewsCheck->bindValue(':authorid', $News_author);
        $sqlNewsCheck->execute();
        $sqlNewsCheck = $sqlNewsCheck->fetch(PDO::FETCH_ASSOC);

        $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
        $sqlCreateLog->bindValue(':user_id', $News_author);
        $sqlCreateLog->bindValue(':time', $News_date);
        $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
        $sqlCreateLog->bindValue(':typo', "New News");
        $sqlCreateLog->bindValue(':content', $sqlNewsCheck["ID"] . " ID news created");
        $sqlCreateLog->execute();
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#aalert-danger').text('').fadeOut();
                $('#aalert-success').text('İçerik Oluşturuldu').fadeIn();
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
            Yeni Yazı Oluştur
        </div>
        <form id="createNewsForm" action="" method="POST" onsubmit="tinyMCE.triggerSave(); return true;">
        <div class="card-body">
                <div class="alert alert-success" id="aalert-success" style="display:none;" role="alert">
                </div>
                <div class="alert alert-danger" id="aalert-danger" style="display:none;" role="alert">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg" name="newsCreate_title" id="newsCreate_title" placeholder="Yazı Başlığı Giriniz" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="newsCreate_short" id="newsCreate_short" placeholder="Kısa Açıklama giriniz (Anasayfada gözükücek)" required>
                </div>
                <div class="mb-3">
                    <label for="newsCreate_image" style="display: none;" class="form-label">Küçük Resim Seçiniz</label>
                    <input type="file" class="form-control" name="newsCreate_image" id="newsCreate_image" style="display: none;" disabled>
                    <input type="text" class="form-control form-control-sm" name="newsCreate_image_url" id="newsCreate_image_url" placeholder="Resim URL'si" required>
                </div>
                <div class="mb-3">
                    <textarea id="newsCreate_content" name="newsCreate_content"></textarea>
                </div>

            </div>
            <div class="card-footer text-body-secondary text-end">
                <button type="submit" id="submitButton" name="submit" class="btn btn-success">Yazıyı Oluştur</button>
            </div>
        </form>
    </div>
</main>
<script src="../../../assets/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#newsCreate_content',
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
