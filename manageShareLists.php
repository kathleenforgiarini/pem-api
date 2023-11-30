<?php

require_once 'dbConfig.php';
require_once 'User.cls.php';
require_once 'SharedLists.cls.php';
require_once 'List.cls.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $operation = $dData['operation'];
    
    function createShareWith(){
        global $connection;
        global $dData;
        $list_id = $dData['listId'];
        $email = $dData['email'];
        
        if ($list_id !== '' && $email !== ''){
            $user = new User();
            $user->setEmail($email);
            $user = $user->getUserByEmail($connection);
            
            if ($user){
                $userId = $user->getId();
                $sharing = new SharedLists();
                $sharing->setUser_id($userId);
                $sharing->setList_id($list_id);
                $isSharing = $sharing->getSharedLists($connection);
                
                if ($isSharing){
                    echo json_encode("User already have access to this list!");
                } else {
                    $newSharing = new SharedLists();
                    $newSharing->setUser_id($userId);
                    $newSharing->setList_id($list_id);
                    $result = $newSharing->create($connection);
                    
                    if ($result){
                        echo json_encode("User now have access to your list!");
                    } else {
                        echo json_encode("An error occurred, try again!");
                    }
                }
            } else {
                echo json_encode("User not found");
            }
        } else {
            echo json_encode("Please enter a valid email");
        }
        
    }
    
    function selectSharedWith(){
        global $connection;
        global $dData;
        $list_id = $dData['list'];
        
        if ($list_id !== ''){
            $userId = new SharedLists();
            $userId->setList_id($list_id);
            $userId = $userId->getUserIdByListId($connection);
            $users = [];
            if ($userId) {
                foreach ($userId as $oneUser) {
                    $u = new User();
                    $u->setId($oneUser['user_id']);
                    $userData = $u->getUserById($connection);
                    $users[] = [
                        'id' => $userData->getId(),
                        'name' => $userData->getName(),
                        'photo' => $userData->getPhoto()
                    ];
                }
            }
            echo json_encode($users);
            
        }
    }
    
    function deleteSharedWith(){
        global $connection;
        global $dData;
        
        $user_id = $dData['userId'];
        $list_id = $dData['listId'];
        $li = new SharedLists();
        $li->setUser_id($user_id);
        $li->setList_id($list_id);
        
        $isDeleted = $li->delete($connection);
        
        if ($isDeleted){
            echo json_encode("success");
        } else {
            echo json_encode("An error occurred, try again!");
        }
    }
    
    function getListsShared(){
        global $connection;
        global $dData;
        $user_id = $dData['userId'];
        $category = $dData['selectedCategory'];
        $name = $dData['name'];
        
        if ($user_id !== ''){
            $listsId = new SharedLists();
            $listsId->setUser_id($user_id);
            $listsId = $listsId->getListIdByUserId($connection);
            $lists = [];
            
            if ($listsId) {
                foreach ($listsId as $oneList) {
                    $l = new Lists();
                    $l->setId($oneList['list_id']);
                    
                    // Check if category and name are not empty
                    if ($category !== '' && $name !== '') {
                        $l->setList_cat_id($category);
                        $l->setName($name);
                        $listData = $l->getListsByIdCategoryAndName($connection);
                    }
                    // Check if category is not empty and name is empty
                    else if ($category !== '' && $name === '') {
                        $l->setList_cat_id($category);
                        $listData = $l->getListsByIdAndCategory($connection);
                    }
                    // Check if category is empty and name is not empty
                    else if ($category === '' && $name !== '') {
                        $l->setName($name);
                        $listData = $l->getListsByIdAndName($connection);
                    }
                    // Default case if both category and name are empty
                    else {
                        $listData = $l->getListsById($connection);
                    }
                    
                    if (!empty($listData)){
                        $lists[] = $listData;
                    }
                    
                }
                echo json_encode($lists);
            }
        }
    }
    
    
    switch ($operation){
        case 'create':
            createShareWith();
            break;
            
        case 'select':
            selectSharedWith();
            break;
            
        case 'delete':
            deleteSharedWith();
            break;
            
        case 'listsShared':
            getListsShared();
            break;
            
    }
    
    
    
} catch (PDOException $e){
    
    $err = $connection->errorInfo();
    echo json_encode($err);
    
}