<?php
function getUserRankID($conn, $userID) {
    $sqlrank = "SELECT rank FROM users WHERE id = :id";
    $stmt = $conn->prepare($sqlrank);
    $stmt->bindValue(':id', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['rank'] ?? null;
}

function isPerm($conn, $perm, $rankID) {
    $sqlperm = "SELECT $perm FROM rank WHERE id = :id";
    $stmt = $conn->prepare($sqlperm);
    $stmt->bindValue(':id', $rankID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $showperm = $result[$perm] ?? null;
    return $showperm === 1;
}

function redirect($meta_url) {
    ?>
    <script>
        var metaUrl = <?= json_encode($meta_url); ?>;
        window.location.href = metaUrl;
    </script>
    <?php
}

$UserRankID = getUserRankID($conn, $_SESSION['user_id']);