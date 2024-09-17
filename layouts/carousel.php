<?php
$sqlcarousel = "SELECT * FROM carousel";
$sqlcarousel = $conn->prepare($sqlcarousel);
$sqlcarousel->execute();
$carousel = $sqlcarousel->fetchAll(PDO::FETCH_ASSOC);
$carouselcount = $sqlcarousel->rowCount();
if ($carouselcount != 0) {
?>
    <div id="ccarousel" class="carousel slide">
    <div class="carousel-indicators">
        <?php
for($i = 0; $i < $carouselcount; $i++){
    if ($i == 0) {
        ?>
        <button type="button" data-bs-target="#ccarousel" data-bs-slide-to="<?= $i;?>" class="active" aria-current="true" aria-label="Slide <?= $i+1;?>"></button>
        <?php
    } else {
        ?>
        <button type="button" data-bs-target="#ccarousel" data-bs-slide-to="<?= $i;?>" aria-label="Slide <?= $i+1;?>"></button>
        <?php
    }
}
?>
    </div>
<div class="carousel-inner">
    <?php
    for($i = 0; $i < $carouselcount; $i++){
        if ($i == 0) {
            ?>
            <div class="carousel-item active">

            <?php
        } else {
            ?>
                <div class="carousel-item">
            <?php
        }
        ?>
        <img src="<?= $carousel[$i]["image"]?>" class="d-block w-100">
        <div class="carousel-caption d-none d-md-block">
            <h5><?= $carousel[$i]["title"]?></h5>
            <p><?= $carousel[$i]["short"]?></p>
            <a type="button" class="btn btn-primary" href="<?= $carousel[$i]["link"]?>"><?= $carousel[$i]["linkdescription"]?></a>
            <br> <br>
        </div>
        </div>
        <?php
    }
    ?>
            </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#ccarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Önceki</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#ccarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sonraki</span>
    </button>
            </div>
        <?php
}
?>
