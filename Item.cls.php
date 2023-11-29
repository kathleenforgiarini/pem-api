<?php

class Item {
    private $id;
    private $name;
    private $quantity;
    private $price;
    private $list_id;
    private $item_cat_id;
    private $done;
    
    function __construct($id = null, $name = null, $quantity = null, $price = null, $list_id = null, $item_cat_id = null, $done = null) {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->list_id = $list_id;
        $this->item_cat_id = $item_cat_id;
        $this->done = $done;
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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getList_id()
    {
        return $this->list_id;
    }

    /**
     * @return string
     */
    public function getItem_cat_id()
    {
        return $this->item_cat_id;
    }

    /**
     * @return string
     */
    public function getDone()
    {
        return $this->done;
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
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param string $list_id
     */
    public function setList_id($list_id)
    {
        $this->list_id = $list_id;
    }

    /**
     * @param string $item_cat_id
     */
    public function setItem_cat_id($item_cat_id)
    {
        $this->item_cat_id = $item_cat_id;
    }

    /**
     * @param string $done
     */
    public function setDone($done)
    {
        $this->done = $done;
    }

    public function create($connection){
        $name = $this->name;
        $quantity = $this->quantity;
        $price = $this->price;
        $list_id = $this->list_id;
        $item_cat_id = $this->item_cat_id;
        $done = $this->done;
        
        $sqlstmt = "INSERT INTO item (name, quantity, price, list_id, item_cat_id, done)
                        VALUES ('$name', $quantity, $price, $list_id, $item_cat_id, $done)";
        
        $result = $connection->exec($sqlstmt);
        
        return $result;
    }
    
    public function delete($connection){
        $sqlStmt = "DELETE from item WHERE id = $this->id";
        return $connection->exec($sqlStmt);
    }
    
    public static function update($connection, $id, $field, $value) {
        $sqlStmt = "UPDATE item SET $field = '$value' WHERE id = $id";
        
        return $connection->exec($sqlStmt);
        
    }
    
    public function getAllItems($connection){
        $sqlStmt = "SELECT * FROM item WHERE list_id=:id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $this->list_id);
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
