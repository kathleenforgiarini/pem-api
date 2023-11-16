<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: Get, Post");
    header("Access-Control-Allow-Headers: Content-Type");
    
    require_once 'dbConfig.php';
    
    global $connection; 
    
    if (mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
    } else {
        $eData = file_get_contents("php://input");
        $dData = json_decode($eData, true);
        
        $email = $dData['email'];
        $pass = $dData['pass'];
        $result = "";
        $id = "";
        $name = "";
        $photo = "";
        
        if ($email != "" and $pass != ""){
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $res = mysqli_query($connection, $sql);
            if (mysqli_num_rows($res) != 0){
                $row = mysqli_fetch_array($res);
                if($pass != $row['password']){
                    $result = "Invalid password!";
                }
                else {
                    $result = "Logged-in successfully! Redirecting...";
                    $id = $row['id'];
                    $name = $row['name'];
                    $photo = base64_encode($row["photo"]);
                }
               
            } else {
                $result = "Invalid email!";
            }
        } else {
            $result = "";
        }
        
        $connection -> close();
        $response = array("result" => $result, "id" => $id, "name" => $name, "photo" => $photo, "email" => $email);
        echo json_encode($response);
    }
?>