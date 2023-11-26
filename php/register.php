<?php

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password != $cpassword) {
        $res = [
            'status' => 422,
            'message' => 'Passwords do not match',
        ];
        echo json_encode($res);
        return;
    } elseif ($name == "" || $email == "" || $password == "") {
        $res = [
            'status' => 423,
            'message' => 'No empty values',
        ];
        echo json_encode($res);
        return;
    } else {
        $query = $con->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $query->store_result();

        if ($query->num_rows == 1) {
            $res = [
                'status' => 424,
                'message' => 'Email already exists',
            ];
            echo json_encode($res);
            return;
        } else {
            // $hashing = password_hash($password, PASSWORD_DEFAULT);
            $query1 = $con->prepare("INSERT INTO users (user_name, email, password) VALUES (?, ?, ?)");
            $query1->bind_param("sss", $name, $email, $password);

            if ($query1->execute()) {
                $res = [
                    'status' => 400,
                    'message' => 'Record inserted successfully',
                ];
                echo json_encode($res);
                return;
            } 
            $query1->close();
            $query->close();
            $con->close();
        }
    }
}
?>
