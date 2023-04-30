<?php 
require '../config/database.php';
require '../includes/response.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $request_body = file_get_contents('php://input');
    $request_body = json_decode($request_body,true);
    
    $id = $request_body['id'];
    $firstName = $request_body['first_name'];
    $middleName = $request_body['middle_name'];
    $lastName = $request_body['last_name'];
    $email = $request_body['email'];
    $password = $request_body['password'];

    // find user
    $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$id]);

    if($query->rowCount() > 0){
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // check if password match
        if(password_verify($password, $user['password'])){
            // update user
            $query = $pdo->prepare("UPDATE users SET first_name=?,middle_name=?,last_name=?,email=? WHERE id = ?");
            $is_updated = $query->execute([$firstName,$middleName,$lastName,$email,$id]);

            if($is_updated){
                $response = Response::success('We successfully updated your account',[$user=>'user']);
            }else{
                $response = Response::failed();
            }
        }else{
            $response = Response::failed(message:"Your password is incorrect!",status_code:Response::$STATUS_FORBIDDEN);
        }
    }

    echo json_encode($response);
}
?>