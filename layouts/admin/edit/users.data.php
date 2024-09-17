<?php
require_once ("../../../connection.php");
require('../function.php');

if (!isPerm($conn, "UPDATE_USER", $UserRankID)) {
    redirect($meta_url);
    exit ;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['userEdit_id'] ?? '';
    $username = $_POST['userEdit_username'] ?? '';
    $email = $_POST['userEdit_email'] ?? '';
    $display = $_POST['userEdit_displayname'] ?? '';
    $password = $_POST['userEdit_password'] ?? '';
    $password1 = $_POST['userEdit_password1'] ?? '';

    $sqlCheckUser = "SELECT username, email FROM users WHERE (username = :username OR email = :email) AND ID != :id";
    $sqlCheckUser = $conn->prepare($sqlCheckUser);
    $sqlCheckUser->bindValue(':username', $username);
    $sqlCheckUser->bindValue(':email', $email);
    $sqlCheckUser->bindValue(':id', $id);
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
    } elseif (empty($username) || empty($email)) {
        echo json_encode(["status" => "error", "message" => "Kullanıcı adı ve e-posta zorunlu alanlardır"]);
    } elseif (!empty($password) && $password !== $password1) {
        echo json_encode(["status" => "error", "message" => "Parola Uyuşmuyor"]);
    } else {
        $fieldsToUpdate = [];
        $bindParams = [];
        if (!empty($username)) {
            $fieldsToUpdate[] = "username = :username";
            $bindParams[':username'] = $username;
        }
        if (!empty($email)) {
            $fieldsToUpdate[] = "email = :email";
            $bindParams[':email'] = $email;
        }
        if (!empty($display)) {
            $fieldsToUpdate[] = "displayname = :displayname";
            $bindParams[':displayname'] = $display;
        }
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
            $fieldsToUpdate[] = "password = :password";
            $bindParams[':password'] = $passwordHash;
        }
        if (!empty($fieldsToUpdate)) {
            $sqlUpdateUser = "UPDATE users SET " . implode(", ", $fieldsToUpdate) . " WHERE ID = :id";
            $bindParams[':id'] = $id;
            $sqlCreateUser = $conn->prepare($sqlUpdateUser);
            foreach ($bindParams as $param => $value) {
                $sqlCreateUser->bindValue($param, $value);
            }
            if ($sqlCreateUser->execute()) {
                $sqlCreateLog = $conn->prepare("INSERT INTO user_log (user_id, time, typo, ipaddress, content) VALUES (:user_id, :time, :typo, :ipaddress, :content)");
                $sqlCreateLog->bindValue(':user_id', $_SESSION['user_id']);
                $sqlCreateLog->bindValue(':time', date("Y-m-d H:i:s"));
                $sqlCreateLog->bindValue(':ipaddress', $_SERVER['REMOTE_ADDR']);
                $sqlCreateLog->bindValue(':typo', "update User");
                $sqlCreateLog->bindValue(':content', $id . " ID user updated");
                $sqlCreateLog->execute();

                echo json_encode(["status" => "success", "message" => "Kullanıcı Güncellendi!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Kullanıcı Güncellenemedi..."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Güncellenecek alan bulunamadı."]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Geçersiz İstek"]);
}
?>
