<?php

class User {
    private $id;
    private $name;
    private $email;
    private $password;
    private $photo;
    
    function __construct($id = null, $name = null, $email = null, $password = null, $photo = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
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
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    
    public function create($connection){
        $name = $this->name;
        $email = $this->email;
        $password = $this->password;
        
        $sqlstmt = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$password')";
        
        $result = $connection->exec($sqlstmt);
        
        return $result;
    }
    
    public function delete($connection){
        $sqlStmt = "DELETE from user WHERE id = $this->id";
        return $connection->exec($sqlStmt);
    }
    
    public function update($connection) {
        $sqlStmt = "UPDATE user SET name =:name, email =:email, password =:password, photo =:photo WHERE id =:id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $this->id);
        $prepare->bindValue(":name", $this->name);
        $prepare->bindValue(":email", $this->email);
        $prepare->bindValue(":password", $this->password);
        $prepare->bindValue(":photo", base64_decode($this->photo));
        $isUpdated = $prepare->execute();
        
        return $isUpdated;
        
    }
    
    public function getUserByEmail($connection){
        $sqlStmt = "SELECT * FROM user WHERE email=:email";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":email", $this->email);
        $prepare->execute();
        $result = $prepare->fetchAll();
        $tObj = "";
        if (sizeOf($result) > 0){
            $tObj = new User();
            foreach ($result as $oneRec){
                $tObj->id = $oneRec["id"];
                $tObj->name = $oneRec["name"];
                $tObj->email = $oneRec["email"];
                $tObj->password = $oneRec["password"];
                $tObj->photo = base64_encode($oneRec["photo"]);
            }
        }
        
        return $tObj;
    }
    
    public function getUserById($connection){
        $sqlStmt = "SELECT * FROM user WHERE id=:id";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":id", $this->id);
        $prepare->execute();
        $result = $prepare->fetchAll();
        $tObj = "";
        if (sizeOf($result) > 0){
            $tObj = new User();
            foreach ($result as $oneRec){
                $tObj->id = $oneRec["id"];
                $tObj->name = $oneRec["name"];
                $tObj->email = $oneRec["email"];
                $tObj->password = $oneRec["password"];
                $tObj->photo = base64_encode($oneRec["photo"]);
            }
        }
        
        return $tObj;
    }
    
    public function login($connection){
        $sqlStmt = "SELECT * FROM user WHERE email=:email AND password=:password";
        $prepare = $connection->prepare($sqlStmt);
        $prepare->bindValue(":email", $this->email);
        $prepare->bindValue(":password", $this->password);
        $prepare->execute();
        $result = $prepare->fetchAll();
        $tObj = "";
        if (sizeOf($result) > 0){
            $tObj = new User();
            foreach ($result as $oneRec){
                $tObj->id = $oneRec["id"];
                $tObj->name = $oneRec["name"];
                $tObj->email = $oneRec["email"];
                $tObj->photo = base64_encode($oneRec["photo"]);
            }
        }
        
        return $tObj;
    }
}