<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: Get, Post");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'dbConfig.php';

global $connection;

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit();
} else {
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $email = $dData['email'];
    $name = "";
    $photo = "";
    $password = "";

    if ($email != "") {
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $res = mysqli_query($connection, $sql);
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_array($res);
            $name = $row['name'];
            $photo = base64_encode($row["photo"]);
            $password = $row['password'];
        }
    }

    $connection->close();
    $response = array(
        "name" => $name,
        "photo" => $photo,
        "password" => $password
    );
    echo json_encode($response);
}
?>