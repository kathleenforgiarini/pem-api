<?php

require_once 'dbConfig.php';
require_once 'User.cls.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");


try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $operation = $dData['operation'];
    
    function createUser(){
        global $connection;
        global $dData;
        $name = $dData['name'];
        $email = $dData['email'];
        $password = $dData['pass'];
        
        if ($name != "" and $email != "" and $password != "") {
            $l1 = new User();
            $l1->setEmail($email);
            $isRegistered = $l1->getUserByEmail($connection);
            if ($isRegistered){
                echo json_encode("user_registered");
            } else {
                $user = new User(null, $name, $email, $password, null);
                $isInserted = $user->create($connection);
                
                if ($isInserted){
                    echo json_encode("success");
                } else {
                    echo json_encode("fail");
                }
            }
            
        } else {
            echo json_encode("fields_required");
        }
    }
    
    function deleteUser(){
        global $connection;
        global $dData;
        
        $id = $dData['id'];
        $li = new User();
        $li->setId($id);
        
        $isDeleted = $li->delete($connection);
        
        if ($isDeleted){
            echo json_encode("success");
        } else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    function updateUser(){
        global $connection;
        global $dData;
        $id = $dData['id'];
        $name = $dData['name'];
        $email = $dData['email'];
        $password = $dData['pass'];
        $photo = $dData['photo'];
        $user = new User($id, $name, $email, $password, $photo);
        $isUpdated = $user->update($connection);
        
        if ($isUpdated) {
            $l1 = new User();
            $l1->setEmail($email);
            $isCorrect = $l1->getUserByEmail($connection);
            if ($isCorrect){
                $response = array(
                    "id" => $isCorrect->getId(),
                    "name" => $isCorrect->getName(),
                    "email" => $isCorrect->getEmail(),
                    "photo" => $isCorrect->getPhoto(),
                );
                echo json_encode($response);
                
            }
        }
        else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    function login(){
        global $connection;
        global $dData;
        $email = $dData['email'];
        $password = $dData['pass'];
        
        if ($email != "" and $password != "") {
            $l1 = new User();
            $l1->setEmail($email);
            $l1->setPassword($password);
            $isCorrect = $l1->login($connection);
            if ($isCorrect){
                $response = array(
                    "id" => $isCorrect->getId(),
                    "name" => $isCorrect->getName(),
                    "email" => $isCorrect->getEmail(),
                    "photo" => $isCorrect->getPhoto(),
                );
                echo json_encode($response);
                
            } else {
                echo json_encode("invalid_credencials");
            }
            
        } else {
            echo json_encode("fields_required");
        }
    }
    
    function selectUser(){
        global $connection;
        global $dData;
        $email = $dData['email'];
        
        if ($email != "") {
            $l1 = new User();
            $l1->setEmail($email);
            $isCorrect = $l1->getUserByEmail($connection);
            if ($isCorrect){
                $response = array(
                    "id" => $isCorrect->getId(),
                    "name" => $isCorrect->getName(),
                    "email" => $isCorrect->getEmail(),
                    "password" => $isCorrect->getPassword(),
                    "photo" => $isCorrect->getPhoto(),
                );
                echo json_encode($response);
                
            } else {
                echo json_encode("fail");
            }
            
        } else {
            echo json_encode("fail");
        }
    }
    
    switch ($operation){
        case 'create':
            createUser();
            break;
            
        case 'delete':
            deleteUser();
            break;
            
        case 'update':
            updateUser();
            break;
            
        case 'login':
            login();
            break;
            
        case 'select':
            selectUser();
            break;
    }
    
    
} catch (PDOException $e){
    
    $err = $connection->errorInfo();
    echo json_encode($err);
    
}