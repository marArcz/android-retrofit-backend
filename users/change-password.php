<?php 
require '../config/database.php';
require '../includes/response.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // find user
    $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$id]);

    if($query->rowCount() > 0){
        $user = $query->fetch(PDO::FETCH_ASSOC);
     
        if(password_verify($password,$user['password'])){
            $hashed_new_password = password_hash($new_password,PASSWORD_BCRYPT);
            $query = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updated = $query->execute([$hashed_new_password, $id]);
            if($updated){
                $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $query->execute([$id]);

                $user = $query->fetch(PDO::FETCH_ASSOC);

                $response = Response::success("Your password is successfully changed!",['user'=>$user]);
            }else{
                $response = Response::failed();
            }
        }else{
            // if password is incorrect
            $response = Response::failed("You entered an incorrect password!",Response::$STATUS_UNAUTHORIZED_ERROR);
        }
    }else{
        $response = Response::failed("We cannot find your account!");
    }

    echo json_encode($response);
}
?>