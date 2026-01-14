
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter your name: " required><br>
        <input type="text" name="email" placeholder="Enter your email: " required><br>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>

<?php
include "db.php";

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    
    if(empty($username) || empty($email) || empty($password)){
        echo "all fields are required";
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
    "INSERT INTO users (username, email, password, created_at) 
     VALUES (?, ?, ?, NOW())"
    );

    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Something went wrong";
    }

}

?> 