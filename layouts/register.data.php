<?php
require_once("../connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['registerModal_username'] ?? '';
    $email = $_POST['registerModal_email'] ?? '';
    $display = $_POST['registerModal_display'] ?? '';
    $password = $_POST['registerModal_password'] ?? '';
    $password1 = $_POST['registerModal_password1'] ?? '';
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $registerDate = date("Y-m-d H:i:s");

    $sqlCheckUser = "SELECT username, email FROM users WHERE username = :username OR email = :email";
    $sqlCheckUser = $conn->prepare($sqlCheckUser);
    $sqlCheckUser->bindValue(':username', $username);
    $sqlCheckUser->bindValue(':email', $email);
    $sqlCheckUser->execute();
    $sqlCheckUser = $sqlCheckUser->fetchAll(PDO::FETCH_ASSOC);

    $usernameExists = false;
    $emailExists = false;

    foreach ($sqlCheckUser as $row) {
        if ($row['username'] === $username) {
            $usernameExists = true;
        }
        if ($row['email'] === $email) {
            $emailExists = true;
        }
    }

    if ($usernameExists && $emailExists) {
        echo json_encode(["status" => "error", "message" => "Bu Kullanıcı Adı ve e-posta zaten kullanılmakta."]);
    } elseif ($usernameExists) {
        echo json_encode(["status" => "error", "message" => "Bu Kullanıcı Adı kullanılmakta."]);
    } elseif ($emailExists) {
        echo json_encode(["status" => "error", "message" => "Bu e-posta adresi zaten kullanılmakta."]);
    } elseif (empty($username) || empty($email) || empty($password) || empty($password1)) {
        echo json_encode(["status" => "error", "message" => "Tüm Alanları Doldurunuz"]);
    } elseif ($password !== $password1) {
        echo json_encode(["status" => "error", "message" => "Parola Uyuşmuyor"]);
    } else {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

        $sqlCreateUser = "INSERT INTO users (username, email, password, displayname, ipaddress, register_date) VALUES (:username, :email, :password, :displayname, :ipaddress, :register_date)";
        $sqlCreateUser = $conn->prepare($sqlCreateUser);
        $sqlCreateUser->bindValue(':username', $username);
        $sqlCreateUser->bindValue(':email', $email);
        $sqlCreateUser->bindValue(':password', $passwordHash);
        $sqlCreateUser->bindValue(':displayname', $display);
        $sqlCreateUser->bindValue(':ipaddress', $ipAddress);
        $sqlCreateUser->bindValue(':register_date', $registerDate);
        $sqlCreateUser->execute();
        echo json_encode(["status" => "success", "message" => "Kayıt Başarılı!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Geçersiz İstek"]);
}
?>
