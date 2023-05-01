<?php
require '../config/database.php';
require '../includes/response.php';

$requestBody = file_get_contents('php://input');

$requestBody = json_decode($requestBody,true);


$firstName = $requestBody['firstname'];
$middleName = $requestBody['middlename'];
$lastName = $requestBody['lastname'];
$email = $requestBody['email'];
$password = $requestBody['password'];
$confirmPassword = $requestBody['confirm_password'];

// check if passwords' match
if ($password !== $confirmPassword) {
    $response = Response::failed(message: 'Passwords does not match!', status_code: Response::$STATUS_UNAUTHORIZED_ERROR);
} else {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users(firstname,middlename,lastname,email,`password`) VALUES (?,?,?,?,?)";
    $sql = $pdo->prepare($sql);
    $added = $sql->execute([
        $firstName,
        $middleName,
        $lastName,
        $email,
        $hashed_password
    ]);

    if ($added) {
        $user_id = $pdo->lastInsertId();
        $query = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $query->execute([$user_id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        unset($user['password']);

        $response = Response::success('We successfully created your account!', ['user' => $user]);
    } else {
        $response = Response::failed();
    }
}
echo json_encode($response);
