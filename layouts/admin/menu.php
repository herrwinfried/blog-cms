<?php

$current_url = $_SERVER['REQUEST_URI'];
?>

<style>
    #sidebar {
        height: 100vh;
        padding: 2rem;
        border-right: 1px solid #ddd;
        transition: background-color 0.3s;
    }

    #sidebar .nav-link {
        color: #333;
        transition: color 0.3s;
    }

    #sidebar .nav-link.active {
        color: #0d6efd;
        background-color: #e9ecef;
    }

    main {
        padding: 2rem;
        transition: background-color 0.3s, color 0.3s;
    }

    [data-bs-theme="dark"] #sidebar {
        background-color: #212529;
    }

    [data-bs-theme="dark"] #sidebar .nav-link {
        color: #f8f9fa;
    }

    [data-bs-theme="dark"] #sidebar .nav-link.active {
        color: #3b8aff;
        background-color: #343a40;
    }

    [data-bs-theme="dark"] main {
        background-color: #343a40;
        color: #f8f9fa;
    }

    [data-bs-theme="light"] #sidebar {
        background-color: #f8f9fa;
    }

    [data-bs-theme="light"] #sidebar .nav-link {
        color: #212529;
    }

    [data-bs-theme="light"] #sidebar .nav-link.active {
        color: #0d6efd;
        background-color: #e9ecef;
    }

    [data-bs-theme="light"] main {
        background-color: #ffffff;
        color: #212529;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky">
                <h4 class="text-center my-4">Yönetim Paneli</h4>
                <ul class="nav flex-column">
                    <?php

                    $menu_items = [
                        ['href' => '/admin/index', 'icon' => 'bi-house-door', 'text' => 'Ana Sayfa'],
                        ['href' => '/admin/news', 'icon' => 'bi-file-earmark-text', 'text' => 'Yazılar'],
                        ['href' => '/admin/users', 'icon' => 'bi-people', 'text' => 'Kullanıcılar'],
                        ['href' => '/admin/conf', 'icon' => 'bi-gear', 'text' => 'Website Ayarları'],
                        ['href' => '/logout', 'icon' => 'bi-box-arrow-right', 'text' => 'Çıkış Yap'],
                        ['href' => '/', 'icon' => 'bi-house-up-fill', 'text' => 'Yönetim Panelinden Çık'],
                    ];

                    foreach ($menu_items as $item) {
                        $active_class = ($current_url == $item['href']) ? 'active' : '';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link ' . $active_class . '" href="' . htmlspecialchars($meta_url . $item['href']) . '">';
                        echo '<i class="bi ' . $item['icon'] . '"></i> ';
                        echo $item['text'];
                        echo '</a>';
                        echo '</li>';
                    }
                    ?>
                    <li class="nav-item dropdown">
                        <a id="bd-theme" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-circle-half"></i> Tema Seçimi
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

