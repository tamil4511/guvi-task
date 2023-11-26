<?php
include('config.php');
require_once("../vendor/predis/predis/autoload.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['email'];
    $userPassword = $_POST['password'];

    // Use a single query to check both email and password
    $query = $con->prepare("SELECT * FROM users WHERE email=? AND password =?");
    $query->bind_param("ss", $userEmail,$userPassword);
    $query->execute();
    $query->store_result();

    if ($query->num_rows == 1) {
        // Fetch user details
        $query->bind_result($userId, $userName, $userEmail, $hashedPassword);
        $query->fetch();

        // Store user information in Redis
        $redis = new Predis\Client();
        $redisKey = "user";
        $redis->hmset($redisKey, 'email', $userEmail, 'name', $userName);
        $res = [
            'status' => 422,
            'message' => 'login successful',
                ];
        echo json_encode($res);
        return;

        // Return user details as JSON response
        echo json_encode(['userId' => $userId, 'userName' => $userName, 'userEmail' => $userEmail]);
    } 
    else {
        
        $res=[
            'status' => 404,
            'message' => 'wrong password',
                

        ];
        echo "Wrong email or password";
        echo json_encode($res);
        return;

    }

    $query->close();
}
?>