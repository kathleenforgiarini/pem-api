<?php

class SharedLists{
    private $id;
    private $user_id;
    private $list_id;
    
    function __construct($id = null, $user_id = null, $list_id = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->list_id = $list_id;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getList_id()
    {
        return $this->list_id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param string $list_id
     */
    public function setList_id($list_id)
    {
        $this->list_id = $list_id;
    }
    
    public function create($connection){
        $user_id = $this->user_id;
        $list_id = $this->list_id;
        
        $sqlstmt = "INSERT INTO user_list (user_id, list_id) VALUES ($user_id, $list_id)";
        
        $result = $connection->exec($sqlstmt);
        
        return $result;
    }
    
    public function delete($connection){
        $sqlStmt = "DELETE from user_list WHERE user_id = $this->user_id AND list_id = $this->list_id";
        return $connection->exec($sqlStmt);
    }
    
    public function getUserIdByListId($connection){
        $sqlStmt = "SELECT user_id FROM user_list WHERE list_id=:list_id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":list_id", $this->list_id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        if (sizeOf($result) > 0){
            return $result;
        }
    }
    
    public function getListIdByUserId($connection){
        $sqlStmt = "SELECT list_id FROM user_list WHERE user_id=:user_id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":user_id", $this->user_id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        if (sizeOf($result) > 0){
            return $result;
        }
    }
    
    public function getSharedLists($connection){
        $sqlStmt = "SELECT * FROM user_list WHERE list_id=:list_id AND user_id=:user_id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":list_id", $this->list_id);
        $prepare->bindValue(":user_id", $this->user_id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        if (sizeOf($result) > 0){
            return $result;
        }
    }

}