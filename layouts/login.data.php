<?php
require_once("../connection.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['loginModal_username'] ?? '';
    $password = $_POST['loginModal_password'] ?? '';
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $loginDate = date("Y-m-d H:i:s");

    $sqlCheckUser = "SELECT id, username, password FROM users WHERE username = :username";
    $sqlCheckUser = $conn->prepare($sqlCheckUser);
    $sqlCheckUser->bindValue(':username', $username);
    $sqlCheckUser->execute();
    $sqlCheckUser = $sqlCheckUser->fetch(PDO::FETCH_ASSOC);
    $user = $sqlCheckUser;

    $usernameNotFound = false;
    $passwordInvalid = false;

    if ($user === false) {
        $usernameNotFound = true;
    } else {
        $hashPassword = $user['password'];
        $passwordInvalid = !password_verify($password, $hashPassword);
    }

    if ($usernameNotFound) {
        echo json_encode(["status" => "error", "message" => "Kullanıcı Bulunamadı. Hesabınız Olduğuna Emin misiniz?"]);
    } elseif ($passwordInvalid) {
        echo json_encode(["status" => "error", "message" => "Parola Geçersiz."]);
    } elseif (empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Tüm Alanları Doldurunuz"]);
    } else {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = time();
        $_SESSION['account'] = "active";

        $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress) VALUES (:user_id, :time, :typo, :ipaddress)");
        $sqlCreateLog->bindValue(':user_id', $user['id']);
        $sqlCreateLog->bindValue(':time', $loginDate);
        $sqlCreateLog->bindValue(':ipaddress', $ipAddress);
        $sqlCreateLog->bindValue(':typo', "Login");
        $sqlCreateLog->execute();

        echo json_encode(["status" => "success", "message" => "Giriş Başarılı!"]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Geçersiz İstek"]);
}
?>
