<?php

require_once 'dbConfig.php';
require_once 'Item.cls.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");


try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $operation = $dData['operation'];
    
    function createItem(){
        global $connection;
        global $dData;
        $name = $dData['name'];
        $quantity = $dData['quantity'];
        $price = $dData['price'];
        $list_id = $dData['list_id'];
        $item_cat_id = $dData['item_cat_id'];
        
        if ($name != "" and $quantity != "" and $price != "" and $list_id != "" and $item_cat_id != "") {
            
            $l1 = new Item(null, $name, $quantity, $price, $list_id, $item_cat_id, 0);
            $isInserted = $l1->create($connection);
            
            if ($isInserted){
                echo json_encode("The item has been inserted successfully");
            } else {
                echo json_encode("An error occurred, try again!");
            }
        } else {
            echo json_encode("Please fill in all fields!");
        }
    }
    
    function deleteItem(){
        global $connection;
        global $dData;
        
        $itemId = $dData['itemId'];
        $li = new Item();
        $li->setId($itemId);
        
        $isDeleted = $li->delete($connection);
        
        if ($isDeleted){
            echo json_encode("The item has been deleted successfully");
        } else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    function updateItem(){
        global $connection;
        global $dData;
        $itemId = $dData['itemId'];
        $field = $dData['field'];
        $value = $dData['value'];
        
        $isUpdated = Item::update($connection, $itemId, $field, $value);
        
        if ($isUpdated) {
            echo json_encode("Item updated!");
        }
        else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    function getItems(){
        global $connection;
        global $dData;
        $list_id = $dData['list_id'];
        
        if ($list_id !== ''){
            $l1 = new Item();
            $l1->setList_id($list_id);
            $listOfItems = $l1->getAllItems($connection);
            
            echo json_encode($listOfItems);
        } else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    switch ($operation){
        case 'create':
            createItem();
            break;
            
        case 'delete':
            deleteItem();
            break;
            
        case 'update':
            updateItem();
            break;
            
        case 'select':
            getItems();
            break;
    }
    
    
} catch (PDOException $e){
    
    $err = $connection->errorInfo();
    echo json_encode($err);
    
}