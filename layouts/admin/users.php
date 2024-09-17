<?php
if (!isPerm($conn, "SHOW_USERPANEL", $UserRankID)) {
    redirect($meta_url);
}
$isPurgeNewsPerm = isPerm($conn, "PURGE_USER", $UserRankID);
$isCreateNewsPerm = isPerm($conn, "NEW_USER", $UserRankID);
$isEditNewsPerm = isPerm($conn, "UPDATE_USER", $UserRankID);
$isDeleteNewsPerm = isPerm($conn, "DELETE_USER", $UserRankID);

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
            if (permission === 'PURGE_USER' && !canPurgeNews) {
                $(this).addClass('disabled');
                $(this).attr('href', '#');
            }
            if (permission === 'NEW_USER' && !canCreateNews) {
                $(this).addClass('disabled');
                $(this).attr('href', '#');
            }
        });

        $('a[data-permission]').each(function() {
            var permission = $(this).data('permission');
            if (permission === 'UPDATE_USER' && !canEditNews) {
                $(this).addClass('disabled');
                $(this).attr('href', '#');
            }
            if (permission === 'DELETE_USER' && !canDeleteNews) {
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
                $('#aalert-danger').text("Lütfen silmek için en az bir kullanıcı seçin.").fadeIn();
                return;
            }
            $.ajax({
                url: window.location.origin + '/layouts/admin/purge/users.data.php',
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
        <a type="button" data-permission="NEW_USER" class="btn btn-success" href="<?= $meta_url?>/admin/create/users" >Kullanıcı Oluştur</a>
        <button type="button" id="purgeButton" class="btn btn-danger" data-permission="PURGE_USER">Seçilenleri Sil</button>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Seç</th>
                <th>ID</th>
                <th>Kullanıcı Adı</th>
                <th>Görünür Adı</th>
                <th>Eylemler</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $userItems = "SELECT * FROM users";
            $userItems = $conn->prepare($userItems);
            $userItems->execute();
            $userItems = $userItems->fetchAll(PDO::FETCH_ASSOC);
            foreach ($userItems as $userItem):
                ?>
                <tr>
                    <td><input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($userItem['ID']); ?>"></td>
                    <td><?php echo htmlspecialchars($userItem['ID']); ?></td>
                    <td><?php echo htmlspecialchars($userItem['username']); ?></td>
                    <td><?php echo htmlspecialchars($userItem['displayname']); ?></td>
                    <td><a role="button" data-permission="UPDATE_USER" href="<?= $meta_url?>/admin/edit/users/<?=$userItem['ID']?>" class="btn btn-warning">Düzenle</a>
                        <a role="button" data-permission="DELETE_USER" href="<?= $meta_url?>/admin/delete/users/<?=$userItem['ID']?>" class="btn btn-danger">Sil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </form>
</main>