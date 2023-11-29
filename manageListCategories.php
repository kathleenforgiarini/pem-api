<?php

require_once 'dbConfig.php';
require_once 'ListCategories.cls.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");


try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $list_cat_id = $dData['list_cat_id'];
    

    if ($list_cat_id == ''){
        $listOfCategories = ListCategories::getAllListCategories($connection);
        
        echo json_encode($listOfCategories);
    }
    else if ($list_cat_id !== '') {
        $l1 = new ListCategories();
        $l1->setId($list_cat_id);
        $listOfCategories = $l1->getListCategoriesById($connection);
        
        echo json_encode($listOfCategories);
    }
     else {
        echo json_encode("An error occurred, try again!");
    }
        
} catch (PDOException $e){
    
    $err = $connection->errorInfo();
    echo json_encode($err);
    
}