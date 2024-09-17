<?php
include("login.php");
include("register.php");
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?=$sqlconfig["URL"]?>"><?=$sqlconfig["name"]?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <?php
          $sqlmenu = "SELECT * FROM menu";
          $sqlmenu = $conn->prepare($sqlmenu);
          $sqlmenu->execute();
          $menus = $sqlmenu->fetchAll(PDO::FETCH_ASSOC);
          
          foreach ($menus as $menu) {
            if (!isset($menu["children"])) { ?>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="<?= $menu['url']; ?>"><?= $menu['name']; ?></a>
              </li>
            <?php } else { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?= $menu['url']; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= $menu['name']; ?>
                </a>
                <ul class="dropdown-menu">
                  <?php 
                    $children = explode(',', $menu["children"]);
                    foreach ($children as $childId) {
                    if ($menu["ID"] != $childId) {
                      $sqlmenusub = "SELECT * FROM menu WHERE id = :id";
                      $sqlmenusub = $conn->prepare($sqlmenusub);
                      $sqlmenusub->bindValue(':id', $childId);
                      $sqlmenusub->execute();
                      $menusub = $sqlmenusub->fetch(PDO::FETCH_ASSOC); ?>
                      <li><a class="dropdown-item" href="<?= $menusub['url']; ?>"><?= $menusub['name']; ?></a></li>
                  <?php }} ?>
                </ul>
              </li>
            <?php } 
          } 
        ?>
      </ul>
    </div>
 <ul class="navbar-nav">
              <?php
              if (isset($_SESSION['account']) && $_SESSION['account'] === "active") {
                  $sqlrank = "SELECT rank FROM users WHERE id = :id";
                  $sqlrank = $conn->prepare($sqlrank);
                  $sqlrank->bindValue(':id', $_SESSION['user_id']);
                  $sqlrank->execute();
                  $sqlrank = $sqlrank->fetch(PDO::FETCH_ASSOC);
                  $UserRankID = $sqlrank['rank'];
                  $sqlrank = "SELECT SHOW_MENUADMINPANEL FROM rank WHERE id = :id";
                  $sqlrank = $conn->prepare($sqlrank);
                  $sqlrank->bindValue(':id', $UserRankID);
                  $sqlrank->execute();
                  $sqlrank = $sqlrank->fetch(PDO::FETCH_ASSOC);
                  $sqlrank = $sqlrank['SHOW_MENUADMINPANEL'];
                  ?>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <?= $_SESSION['username'] ?>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                          <?php if ($sqlrank === 1) { ?>
                              <a class="nav-link" aria-current="page" href="/admin">Admin Panel</a>
                          <?php
                          }
                          ?>
                          <a class="nav-link" aria-current="page" href="/logout.php">Çıkış Yap</a>
                     </ul>
                  </li>
              <?php
              } else {
              ?>
              <li class="nav-item">
                      <a class="nav-link" aria-current="page" role="button" data-bs-toggle="modal" data-bs-target="#loginModal">Giriş Yap</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" aria-current="page" role="button" data-bs-toggle="modal" data-bs-target="#registerModal">Kayıt Ol</a>
              </li>
              <?php
              }
              ?>
              <li class="nav-item dropdown">
                  <a id="bd-theme" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-circle-half"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li><a role="button" class="dropdown-item" data-bs-theme-value="auto"><i class="bi bi-slash-circle" aria-pressed="false"></i> Otomatik</a></li>
                      <li><a role="button" class="dropdown-item" data-bs-theme-value="light"><i class="bi bi-brightness-high-fill" aria-pressed="false"></i> Aydınlık Tema</a></li>
                      <li><a role="button" class="dropdown-item" data-bs-theme-value="dark"><i class="bi bi-moon-fill" aria-pressed="true"></i> Karanlık Tema</a></li>
                  </ul>
              </li>
          </ul>
  </div>
</nav>

<style>
    .active {
        background-color: cornflowerblue;
        color: white;
    }

</style>
