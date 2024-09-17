<?php
$NewsID = $_GET['id'];

$sqlNews = "SELECT * FROM news WHERE ID = :id";
$sqlNews = $conn->prepare($sqlNews);
$sqlNews->bindValue(':id', $NewsID);
$sqlNews->execute();
$sqlNews = $sqlNews->fetch(PDO::FETCH_ASSOC);

if (!$sqlNews) {
    ?>
    <div style="margin: 1%;" class="alert alert-danger" role="alert">
        Sanırım bu içerik yayından kaldırılmış veya yanlış içeriği hedeflediniz...
    </div>

    <script>
        var metaUrl = <?php echo json_encode($meta_url); ?>;
        setTimeout(function(){
            window.location.href = metaUrl;
        }, 4000);
    </script>
    <?php
} else {
?>

<?php

$sqlnews = "SELECT * FROM news WHERE id = :id";
$sqlnews = $conn->prepare($sqlnews);
$sqlnews->bindValue(':id', $NewsID);
$sqlnews->execute();
$news = $sqlnews->fetch(PDO::FETCH_ASSOC);

$news_title = $news['title'];
$news_authorid = $news['authorid'];
$news_date = $news['date'];
$news_content = $news['content'];

$sqlauthor = "SELECT * FROM users WHERE id = :id";
$sqlauthor = $conn->prepare($sqlauthor);
$sqlauthor->bindValue(':id', $news_authorid);
$sqlauthor->execute();
$sqlauthor = $sqlauthor->fetch(PDO::FETCH_ASSOC);

$news_author = !empty($sqlauthor["displayname"]) ? $sqlauthor["displayname"] : $sqlauthor["username"];
?>
<div id="news" class="row">
    <div class="col-md-8">

<div class="card">
    <div class="card-header text-center">
        <?= $news_title ?>
    </div>
    <div class="card-body">
        <div style="display: flex; margin-bottom: 3%;" class="overlay-bar">
            <span><i class="bi bi-person"> <?= $news_author ?></i></span>
            <span style="margin-left: auto;" class=""><i class="bi bi-clock"> <?= date("d/m/Y H:i", strtotime($news_date)) ?></i></span>
        </div>
        <p class="card-text"><?= $news_content?> </p>
    </div>
</div>

    </div>
    <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    Yorumlar
                </div>
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        Yapım Aşamasında...
                    </div>
                </div>
        </div>
</div>
    </div>

    <?php
}
    ?>