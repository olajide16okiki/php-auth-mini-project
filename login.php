<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="email" placeholder="Enter your email" required><br>
        <input type="password" name="password" placeholder="Enter your password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
<?php
session_start();
include "db.php";
include "util.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if($result->num_rows === 1){
        $user = $result->fetch_assoc();
        
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "Login successful";
        }else{
            echo "incorrect password";
        }
    }else{
        "user not found";
    }
}


?>