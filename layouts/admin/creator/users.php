<?php

if (!isPerm($conn, "NEW_USER", $UserRankID)) {
    redirect($meta_url);
    exit ;
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#createUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                userCreate_username: $('#userCreate_username').val(),
                userCreate_email: $('#userCreate_email').val(),
                userCreate_password: $('#userCreate_password').val(),
                userCreate_password1: $('#userCreate_password1').val(),
                userCreate_displayname: $('#userCreate_displayname').val()
            }
            $.ajax({
                url: window.location.origin + '/layouts/admin/creator/users.data.php',
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
            Yeni Kullanıcı Oluştur
        </div>
        <form id="createUserForm" action="" method="POST">
            <div class="card-body">
                <div class="alert alert-success" id="aalert-success" style="display:none;" role="alert">
                </div>
                <div class="alert alert-danger" id="aalert-danger" style="display:none;" role="alert">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="userCreate_username" id="userCreate_username" placeholder="Kullanıcı Adı Giriniz" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="userCreate_email" id="userCreate_email" placeholder="E-posta Adresi Giriniz" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="userCreate_password" id="userCreate_password" placeholder="Parola Giriniz" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="userCreate_password1" id="userCreate_password1" placeholder="Parola Tekrar Giriniz" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="userCreate_displayname" id="userCreate_displayname" placeholder="Görünür Ad Giriniz (İsteğe Bağlı)">
                </div>

            </div>
            <div class="card-footer text-body-secondary text-end">
                <button type="submit" class="btn btn-success">Kullanıcıyı Oluştur</button>
            </div>
        </form>
    </div>
</main>
