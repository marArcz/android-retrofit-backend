<?php require "config/database.php"?>
<?php require "includes/create.inc.php"?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Index Page</title>
</head>

<body>
    
    <h3>Create Account</h3>

    <form action="" method="POST">

    <input type="text" name="first_name" placeholder="First Name" id=""> 
    <br> <br>
    <input type="text" name="middle_name" placeholder="Middle Name" id=""> 
    <br> <br>
    <input type="text" name="last_name" placeholder="Last Name" id="">
     <br> <br>
    <input type="email" name="email" placeholder="Email" id=""> 
    <br> <br>
    <input type="password" name="password" placeholder="Password" id=""> 
    <br> <br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" id="">
    <br> <br>
    <button type="submit" name="btnSave">Save</button>
   
</form>
</body>
</html>