<?php

class ListCategories{
    private $id;
    private $name;
    private $description;
    
    function __construct($id = null, $name = null, $description = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
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
    
    public static function getAllListCategories($connection){
        $sqlStmt = "SELECT * FROM list_categories";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->execute();
        $result = $prepare->fetchAll();
        
        if (sizeOf($result) > 0) {
            return $result;
        } else {
            return [];
        }
    }
    
    public function getListCategoriesById($connection){
        $id = $this->id;
        $sqlStmt = "SELECT * FROM list_categories WHERE id=:id";
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