<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Giriş Yap</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="POST">
                    <div class="mb-3">
                        <label for="loginModal_username" class="col-form-label required-form">Kullanıcı Adınız</label>
                        <input type="text" class="form-control" id="loginModal_username" placeholder="Kullanıcı Adınız..." required>
                    </div>
                    <div class="mb-3">
                        <label for="loginModal_password" class="col-form-label required-form">Parolanız</label>
                        <input type="password" class="form-control" id="loginModal_password" placeholder="Parola Giriniz..." required>
                    </div>
                    <div class="alert alert-success" id="alert-success" style="display:none;" role="alert">
                    </div>
                    <div class="alert alert-danger" id="alert-danger" style="display:none;" role="alert">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kapat</button>
                        <button id="loginRegisterButton" type="button" style="display:none;" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#loginModal">Kayıt Ol</button>
                        <button type="submit" class="btn btn-success">Giriş Yap</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
