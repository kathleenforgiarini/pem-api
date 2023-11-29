<?php

class ItemCategories{
    private $id;
    private $name;
    private $description;
    private $list_categories_id;
    
    function __construct($id = null, $name = null, $description = null, $list_categories_id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->list_categories_id = $list_categories_id;
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
    public function getList_categories_id()
    {
        return $this->list_categories_id;
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
     * @param string $list_categories_id
     */
    public function setList_categories_id($list_categories_id)
    {
        $this->list_categories_id = $list_categories_id;
    }

    public static function getAllItemCategories($connection){
        $sqlStmt = "SELECT * FROM item_categories";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
    }
    
    public function getItemCategoriesByListCatId($connection){
        $id = $this->list_categories_id;
        $sqlStmt = "SELECT * FROM item_categories WHERE list_categories_id=:id";
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
    
}