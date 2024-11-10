<?php
    if (strlen($_SESSION['login']==0)) {
        header('location:logout.php');
    }else{
    require_once('../admin/includes/dataAccess.php');

    $conn = createDb();

    $sql = "SELECT id, username, password FROM Users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            $userId = $user['id'];
            $currentPassword = $user['password'];
            $newPasswordHashed = password_hash($currentPassword, PASSWORD_BCRYPT);
            $updateStmt = $conn->prepare("UPDATE Users SET password = ? WHERE id = ?");
            $updateStmt->bind_param("si", $newPasswordHashed, $userId);
            $updateStmt->execute();
            $updateStmt->close();

            echo "Updated password for user ID: $userId <br>";
        }
    } else {
        echo "No users found.";
    }

    $conn->close();
    }
?>
