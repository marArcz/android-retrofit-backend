<?php 
require '../config/database.php';
require '../includes/response.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $request_body = file_get_contents('php://input');

    $request_body = json_decode($request_body,true);
    
    $id = $request_body['id'];
    $firstName = $request_body['firstname'];
    $middleName = $request_body['middlename'];
    $lastName = $request_body['lastname'];
    $email = $request_body['email'];

    // find user
    $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$id]);

    if($query->rowCount() > 0){
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $query = $pdo->prepare("UPDATE users SET firstname=?,middlename=?,lastname=?,email=? WHERE id = ?");
        $is_updated = $query->execute([$firstName,$middleName,$lastName,$email,$id]);

        if($is_updated){
            $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $query->execute([$id]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            
            $response = Response::success('We successfully updated your account',['user'=>$user]);
        }else{
            $response = Response::failed();
        }
    }

    echo json_encode($response);
}
?>