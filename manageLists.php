<?php

require_once 'dbConfig.php';
require_once 'List.cls.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");


try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $operation = $dData['operation'];

    function createList(){
        global $connection;
        global $dData;
        $name = $dData['name'];
        $description = $dData['description'];
        $list_cat_id = $dData['list_cat_id'];
        $max_price = $dData['max_price'];
        $user_id = $dData['user_id'];
        
        if ($name != "" and $list_cat_id != "" and $max_price != "" and $user_id != "") {
            
            $l1 = new Lists(null, $name, $description, $list_cat_id, $max_price, null, $user_id);
            $isInserted = $l1->create($connection);
            
            if ($isInserted){
                echo json_encode("The list has been inserted successfully");
            } else {
                echo json_encode("An error occurred, try again!");
            }
        } else {
            echo json_encode("Please fill in all fields!");
        }
    }
    
    function deleteList(){
        global $connection;
        global $dData;
        
        $listId = $dData['listId'];
        $li = new Lists();
        $li->setId($listId);
        
        $isDeleted = $li->delete($connection);
        
        if ($isDeleted){
            echo json_encode("The list has been deleted successfully");
        } else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    function updateList(){
        global $connection;
        global $dData;
        $listId = $dData['listId'];
        $field = $dData['field'];
        $value = $dData['value'];
        
        $isUpdated = Lists::update($connection, $listId, $field, $value);
        
        if ($isUpdated) {
            echo json_encode("List updated!");
        }
        else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    function getLists(){
        global $connection;
        global $dData;
        $user_id = $dData['userId'];
        $category = $dData['selectedCategory'];
        $name = $dData['name'];
        
        if ($category == '' && $name == ''){
            $l1 = new Lists();
            $l1->setUser_id($user_id);
            $listOfLists = $l1->getAllLists($connection);
            
            echo json_encode($listOfLists);
        }
        else if ($category !== "" && $name == "") {
            $l1 = new Lists();
            $l1->setUser_id($user_id);
            $l1->setList_cat_id($category);
            $listOfLists = $l1->getListsByCategory($connection);
            
            echo json_encode($listOfLists);
        }
        else if ($category == "" && $name !== "") {
            $l1 = new Lists();
            $l1->setUser_id($user_id);
            $l1->setName($name);
            $listOfLists = $l1->getListsByName($connection);
            
            echo json_encode($listOfLists);
        }
        else if ($category !== "" && $name !== "") {
            $l1 = new Lists();
            $l1->setUser_id($user_id);
            $l1->setList_cat_id($category);
            $l1->setName($name);
            $listOfLists = $l1->getListsByNameAndCategory($connection);
            
            echo json_encode($listOfLists);
        } else {
            echo json_encode("An error occurred, try again!");
        }
        
        
    }
    
    switch ($operation){
        case 'create':
            createList();
            break;
        
        case 'delete':
            deleteList();
            break;
        
        case 'update':
            updateList();
            break;
            
        case 'select':
            getLists();
            break;
    }
    
    
} catch (PDOException $e){
    
    $err = $connection->errorInfo();
    echo json_encode($err);
    
}