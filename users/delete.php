<?php
require '../config/database.php';
require '../includes/response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // find user
    $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$id]);

    if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // check if password match
        if (password_verify($password, $user['password'])) {
            // delete user
            $query = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $is_deleted = $query->execute([$id]);

            if ($is_deleted) {
                $response = Response::success('We successfully deleted your account', [$user => 'user']);
            } else {
                $response = Response::failed();
            }
        } else {
            $response = Response::failed(message: "Your password is incorrect!", status_code: Response::$STATUS_FORBIDDEN);
        }
    }

    echo json_encode($response);
}
