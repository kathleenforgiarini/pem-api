<?php

require_once 'dbConfig.php';
require_once 'ItemCategories.cls.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");


try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $list_cat_id = $dData['list'];
    
    
    if ($list_cat_id !== ''){
        $l1 = new ItemCategories();
        $l1->setList_categories_id($list_cat_id);
        $listOfCategories = $l1->getItemCategoriesByListCatId($connection);
        
        echo json_encode($listOfCategories);
    }
    else {
        echo json_encode("An error occurred, try again!");
    }
    
} catch (PDOException $e){
    
    $err = $connection->errorInfo();
    echo json_encode($err);
    
}