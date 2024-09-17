<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel">Kayıt Ol</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="POST">
                    <div class="mb-3">
                        <label for="registerModal_username" class="col-form-label required-form">Kullanıcı Adınız</label>
                        <input type="text" class="form-control" id="registerModal_username" placeholder="Kullanıcı Adınız..." required>
                    </div>
                    <div class="mb-3">
                        <label for="registerModal_email" class="col-form-label required-form">E-posta Adresiniz</label>
                        <input type="email" class="form-control" id="registerModal_email" placeholder="E-posta Adresiniz..." required>
                    </div>
                    <div class="mb-3">
                        <label for="registerModal_display" class="col-form-label">Görünür Adınız</label>
                        <input type="text" class="form-control" id="registerModal_display" placeholder="Herkes Tarafından Görünücek Adınız...">
                    </div>
                    <div class="mb-3">
                        <label for="registerModal_password" class="col-form-label required-form">Parolanız</label>
                        <input type="password" class="form-control" id="registerModal_password" placeholder="Parola Giriniz..." required>
                    </div>
                    <div class="mb-3">
                        <label for="registerModal_password1" class="col-form-label required-form">Parolanızı Doğrulayın</label>
                        <input type="password" class="form-control" id="registerModal_password1" placeholder="Parolanızı Tekrar Giriniz..." required>
                    </div>
                    <div class="alert alert-success" id="ralert-success" style="display:none;" role="alert">
                    </div>
                    <div class="alert alert-danger" id="ralert-danger" style="display:none;" role="alert">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kapat</button>
                        <button id="registerLoginButton" type="button" style="display:none;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">Giriş Yap</button>
                        <button type="submit" class="btn btn-info">Kayıt Ol</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

