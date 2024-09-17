<?php

if (!isPerm($conn, "UPDATE_USER", $UserRankID)) {
    redirect($meta_url);
    exit ;
}

if (isset($_GET["id"])) {
    $sqlGetUser = $conn->prepare("SELECT * FROM users WHERE ID = :id");
    $sqlGetUser->bindValue(':id', $_GET["id"]);
    $sqlGetUser->execute();
    $sqlGetUser = $sqlGetUser->fetch(PDO::FETCH_ASSOC);

    if ($sqlGetUser) {
        $GetUser_username = $sqlGetUser["username"];
        $GetUser_email = $sqlGetUser["email"];
        $GetUser_displayname = $sqlGetUser["displayname"];
    } else {
        redirect($meta_url . "/admin/users");
    }
} else {
    redirect($meta_url . "/admin/users");
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                userEdit_id: "<?= $_GET["id"]; ?>",
                userEdit_username: $('#userEdit_username').val(),
                userEdit_email: $('#userEdit_email').val(),
                userEdit_password: $('#userEdit_password').val(),
                userEdit_password1: $('#userEdit_password1').val(),
                userEdit_displayname: $('#userEdit_displayname').val()
            }
            $.ajax({
                url: window.location.origin + '/layouts/admin/edit/users.data.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#aalert-danger').text("").fadeOut();
                        $('#aalert-success').text(response.message).fadeIn();
                        setTimeout(function() {
                            window.location.href = window.location.origin + "/admin/users";
                        }, 1500);
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
    <div class="card">
        <div class="card-header text-center">
            Kullanıcı Düzenle
        </div>
        <form id="editUserForm" action="" method="POST">
            <div class="card-body">
                <div class="alert alert-success" id="aalert-success" style="display:none;" role="alert">
                </div>
                <div class="alert alert-danger" id="aalert-danger" style="display:none;" role="alert">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="userEdit_username" id="userEdit_username" placeholder="Kullanıcı Adı Giriniz" value="<?= $GetUser_username ?>" disabled>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="userEdit_email" id="userEdit_email" placeholder="E-posta Adresi Giriniz" value="<?= $GetUser_email ?>" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="userEdit_password" id="userEdit_password" placeholder="Parola Giriniz">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="userEdit_password1" id="userEdit_password1" placeholder="Parola Tekrar Giriniz">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="userEdit_displayname" id="userEdit_displayname" placeholder="Görünür Ad Giriniz (İsteğe Bağlı)" value="<?= $GetUser_displayname ?>">
                </div>

            </div>
            <div class="card-footer text-body-secondary text-end">
                <button type="submit" class="btn btn-warning">Kullanıcıyı Düzenle</button>
            </div>
        </form>
    </div>
</main>
