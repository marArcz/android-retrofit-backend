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
        $query = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $is_deleted = $query->execute([$id]);

        if ($is_deleted) {
            $response = Response::success('We successfully deleted your account');
        } else {
            $response = Response::failed();
        }
    } else {
        $response = Response::failed("We cannot find your account!");
    }

    echo json_encode($response);
}
