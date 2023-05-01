<?php
require '../config/database.php';
require '../includes/response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    // find user with the given email
    $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$id]);

    // if user is found
    if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // check if password match
        if (password_verify($password, $user['password'])) {
            unset($user['password']);

            $response = Response::success('You successfully logged in to your account!', ['user' => $user]);
        } else {
            $response = Response::failed('You entered an incorrect password!', Response::$STATUS_UNAUTHORIZED_ERROR);
        }
    } else {
        // if no user is found
        $response = Response::failed('Your credentials does not match any of our records!' . Response::$STATUS_NOT_FOUND);
    }

    echo json_encode($response);
}
