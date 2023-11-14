<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'dbConfig.php';

global $connection;

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit();
} else {
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    
    $name = $dData['name'];
    $email = $dData['email'];
    $pass = $dData['pass'];
    $result = "";
    $photo = "";
    
    if ($name != "" and $email != "" and $pass != "") {
        // Check if the user already exists
        $checkSql = "SELECT * FROM user WHERE email = '$email'";
        $checkRes = mysqli_query($connection, $checkSql);
        
        if (mysqli_num_rows($checkRes) != 0) {
            $result = "User already exists!";
        } else {
            // Insert the new user into the database
           // $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
            
            $insertSql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$pass')";
            $insertRes = mysqli_query($connection, $insertSql);
            
            if ($insertRes) {
                $result = "Signup successful!";
            } else {
                $result = "Error creating user: " . mysqli_error($connection);
            }
        }
    } else {
        $result = "All fields are required!";
    }
    
    $connection->close();
    $response = array("result" => $result, "photo" => $photo, "email" => $email);
    echo json_encode($response);
}

?>
