<?php

class Lists {
    private $id;
    private $name;
    private $description;
    private $list_cat_id;
    private $max_price;
    private $total_price;
    private $user_id;
    
    function __construct($id = null, $name = null, $description = null, $list_cat_id = null, $max_price = null, $total_price = null, $user_id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->list_cat_id = $list_cat_id;
        $this->max_price = $max_price;
        $this->total_price = $total_price;
        $this->user_id = $user_id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getList_cat_id()
    {
        return $this->list_cat_id;
    }

    /**
     * @return string
     */
    public function getMax_price()
    {
        return $this->max_price;
    }

    /**
     * @return string
     */
    public function getTotal_price()
    {
        return $this->total_price;
    }

    /**
     * @return string
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $list_cat_id
     */
    public function setList_cat_id($list_cat_id)
    {
        $this->list_cat_id = $list_cat_id;
    }

    /**
     * @param string $max_price
     */
    public function setMax_price($max_price)
    {
        $this->max_price = $max_price;
    }

    /**
     * @param string $total_price
     */
    public function setTotal_price($total_price)
    {
        $this->total_price = $total_price;
    }

    /**
     * @param string $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    
    public function create($connection){
        $name = $this->name;
        $description = $this->description;
        $max_price = $this->max_price;
        $user_id = $this->user_id;
        $list_cat_id = $this->list_cat_id;
        
        $sqlstmt = "INSERT INTO list (name, description, list_cat_id, max_price, user_id)
                        VALUES ('$name', '$description', '$list_cat_id', '$max_price', '$user_id')";
        
        $result = $connection->exec($sqlstmt);
        
        return $result;
    }
    
    public function delete($connection){
        $sqlStmt = "DELETE from list WHERE id = $this->id";
        return $connection->exec($sqlStmt);
    }
    
    public static function update($connection, $id, $field, $value) {
        $sqlStmt = "UPDATE list SET $field = '$value' WHERE id = $id";
        
        return $connection->exec($sqlStmt);
       
    }
    
    public function getAllLists($connection){
        $sqlStmt = "SELECT * FROM list WHERE user_id=:id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $this->user_id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    
    public function getListsByCategory($connection){
        $id = $this->user_id;
        $list_cat_id = $this->list_cat_id;
        $sqlStmt = "SELECT * FROM list WHERE user_id=:userId AND list_cat_id=:list_cat_id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":userId", $id);
        $prepare->bindValue(":list_cat_id", $list_cat_id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    public function getListsByName($connection){
        $id = $this->user_id;
        $name = $this->name;
        $sqlStmt = "SELECT * FROM list WHERE user_id =:userId AND name LIKE :name";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":userId", $id);
        $prepare->bindValue(":name", '%' . $name . '%');
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    public function getListsByNameAndCategory($connection){
        $id = $this->user_id;
        $name = $this->name;
        $list_cat_id = $this->list_cat_id;
        $sqlStmt = "SELECT * FROM list WHERE user_id = :userId AND list_cat_id = :list_cat_id AND name LIKE :name";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":userId", $id);
        $prepare->bindValue(":list_cat_id", $list_cat_id);
        $prepare->bindValue(":name", '%' . $name . '%');
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    public function getListsById($connection){
        $id = $this->id;
        $sqlStmt = "SELECT * FROM list WHERE id =:id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    public function getListsByIdAndName($connection){
        $id = $this->id;
        $name = $this->name;
        $sqlStmt = "SELECT * FROM list WHERE id =:id AND name LIKE :name";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $id);
        $prepare->bindValue(":name", '%' . $name . '%');
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    public function getListsByIdAndCategory($connection){
        $id = $this->id;
        $list_cat_id = $this->list_cat_id;
        $sqlStmt = "SELECT * FROM list WHERE id =:id AND list_cat_id =:list_cat_id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $id);
        $prepare->bindValue(":list_cat_id", $list_cat_id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    public function getListsByIdCategoryAndName($connection){
        $id = $this->id;
        $list_cat_id = $this->list_cat_id;
        $name = $this->name;
        $sqlStmt = "SELECT * FROM list WHERE id =:id AND list_cat_id =:list_cat_id AND name LIKE :name";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $id);
        $prepare->bindValue(":list_cat_id", $list_cat_id);
        $prepare->bindValue(":name", '%' . $name . '%');
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
        
    }
    
    
}
?>
