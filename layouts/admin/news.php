<?php
if (!isPerm($conn, "SHOW_NEWSPANEL", $UserRankID)) {
    redirect($meta_url);
}
$isPurgeNewsPerm = isPerm($conn, "PURGE_NEWS", $UserRankID);
$isCreateNewsPerm = isPerm($conn, "NEW_NEWS", $UserRankID);
$isEditNewsPerm = isPerm($conn, "UPDATE_NEWS", $UserRankID);
$isDeleteNewsPerm = isPerm($conn, "DELETE_NEWS", $UserRankID);

?>

<style>
    #adminnews button {
        margin: 0.3%;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var canPurgeNews = <?php echo json_encode($isPurgeNewsPerm); ?>;
        var canCreateNews = <?php echo json_encode($isCreateNewsPerm); ?>;
        var canEditNews = <?php echo json_encode($isEditNewsPerm); ?>;
        var canDeleteNews = <?php echo json_encode($isDeleteNewsPerm); ?>;

        $('button[data-permission]').each(function() {
            var permission = $(this).data('permission');
            if (permission === 'PURGE_NEWS' && !canPurgeNews) {
                $(this).addClass('disabled');
                $(this).attr('href', '#');
            }
            if (permission === 'NEW_NEWS' && !canCreateNews) {
                $(this).addClass('disabled');
                $(this).attr('href', '#');
            }
        });

        $('a[data-permission]').each(function() {
            var permission = $(this).data('permission');
            if (permission === 'UPDATE_NEWS' && !canEditNews) {
                $(this).addClass('disabled');
                $(this).attr('href', '#');
            }
            if (permission === 'DELETE_NEWS' && !canDeleteNews) {
                $(this).addClass('disabled');
                $(this).attr('href', '#');
            }
        });

        $('#purgeButton').on('click', function(e) {
            e.preventDefault();

            let selectedIds = [];
            $('input[name="ids[]"]:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                $('#aalert-success').text("").fadeOut();
                $('#aalert-danger').text("Lütfen silmek için en az bir yazı seçin.").fadeIn();
                return;
            }
            $.ajax({
                url: window.location.origin + '/layouts/admin/purge/news.data.php',
                type: 'POST',
                data: {selectedIds},
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#aalert-danger').text("").fadeOut();
                        $('#aalert-success').text(response.message).fadeIn();
                        location.reload();
                    } else {
                        $('#aalert-success').text("").fadeOut();
                        $('#aalert-danger').text(response.message).fadeIn();
                    }
                },
                error: function(xhr, status, error) {
                    $('#aalert-success').text("").fadeOut();
                    $('#aalert-danger').text('An error occurred: ' + error).fadeIn();
                }
            });
        });
    });
</script>


<main id="adminmenu" class="col-md-9 ms-sm-auto col-lg-10 px-4">
    <div class="alert alert-success" id="aalert-success" style="display:none;" role="alert">
    </div>
    <div class="alert alert-danger" id="aalert-danger" style="display:none;" role="alert">
    </div>

    <form id="adminnews" method="post" action="">
        <a type="button" data-permission="NEW_NEWS" class="btn btn-success" href="<?= $meta_url?>/admin/create/news" >Yazı Oluştur</a>
        <button type="button" id="purgeButton" class="btn btn-danger" data-permission="PURGE_NEWS">Seçilenleri Sil</button>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Seç</th>
                <th>ID</th>
                <th>Başlık</th>
                <th>Kısa Açıklama</th>
                <th>Yazar</th>
                <th>Eylemler</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $newsItems = "SELECT * FROM news";
            $newsItems = $conn->prepare($newsItems);
            $newsItems->execute();
            $newsItems = $newsItems->fetchAll(PDO::FETCH_ASSOC);
            foreach ($newsItems as $news):
                $newsAuthor = "SELECT username,displayname FROM users WHERE id=:id";
                $newsAuthor = $conn->prepare($newsAuthor);
                $newsAuthor->bindParam(':id', $news['authorid']);
                $newsAuthor->execute();
                $newsAuthor = $newsAuthor->fetch(PDO::FETCH_ASSOC);
                if ($newsAuthor) { $newsAuthor = $newsAuthor['username']; } else { $newsAuthor = "ID-" . $news['authorid']; }
                ?>
                <tr>
                    <td><input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($news['ID']); ?>"></td>
                    <td><?php echo htmlspecialchars($news['ID']); ?></td>
                    <td><?php echo htmlspecialchars($news['title']); ?></td>
                    <td><?php echo htmlspecialchars($news['short']); ?></td>
                    <td><?php echo htmlspecialchars($newsAuthor) ?></td>
                    <td><a role="button" data-permission="UPDATE_NEWS" href="<?= $meta_url?>/admin/edit/news/<?=$news['ID']?>" class="btn btn-warning">Düzenle</a>
                        <a role="button" data-permission="DELETE_NEWS" href="<?= $meta_url?>/admin/delete/news/<?=$news['ID']?>" class="btn btn-danger">Sil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </form>
</main>