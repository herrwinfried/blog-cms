<?php
require("carousel.php");
$sqlnews = "SELECT * FROM news ORDER BY date DESC";
$sqlnews = $conn->prepare($sqlnews);
$sqlnews->execute();
$news = $sqlnews->fetchAll(PDO::FETCH_ASSOC);
$newscount = $sqlnews->rowCount();
?>
<div id="homepage" class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <?php
                if ($newscount == 0) {
                    ?>
                    <div style="margin: 1%;" class="alert alert-warning" role="alert">
                        Burası Boş görünüyor...
                    </div>
                    <?php
                } else {
                    foreach ($news as $news1) {
                        $sqlauthor = "SELECT * FROM users WHERE id = :id";
                        $sqlauthor = $conn->prepare($sqlauthor);
                        $sqlauthor->bindValue(':id', $news1["authorid"]);
                        $sqlauthor->execute();
                        $sqlauthor = $sqlauthor->fetch(PDO::FETCH_ASSOC);
                        $authorname = !empty($sqlauthor["displayname"]) ? $sqlauthor["displayname"] : $sqlauthor["username"];
                        ?>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="card">
                                <img src="<?= $news1["image"] ?>" class="card-img-top">
                                <div class="overlay-bar">
                                    <span class="overlay-bar-text"><i class="bi bi-person"> <?= $authorname ?></i></span>
                                    <span class="overlay-bar-text"><i class="bi bi-clock"> <?= date("d/m/Y H:i", strtotime($news1["date"])) ?></i></span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $news1["title"] ?></h5>
                                    <p class="card-text"><?= $news1["short"] ?></p>
                                    <a href="/news/<?=$news1['ID'];?>" class="btn btn-primary">Devamını Okuyun...</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
                <div style="border: none" class="card">
                        <p>.</p>
            </div>
    </div>
</div>
