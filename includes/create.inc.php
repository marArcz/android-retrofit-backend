<?php 

require "./config/database.php";

if(isset($_POST['btnSave'])) {

$firstName = $_POST['first_name'];
$middleName = $_POST['middle_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

$sql = "INSERT INTO users(first_name,middle_name,last_name,email,`password`) VALUES (?,?,?,?,?)";
$sql = $pdo->prepare($sql);
$sql->execute([
    $firstName,
    $middleName,
    $lastName,
    $email,
    $password
]);


}

?>