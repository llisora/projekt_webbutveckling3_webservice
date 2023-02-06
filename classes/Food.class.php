<?php
/* 
Code by Lisa Bäcklin, Mittuniversitetet
Email: liba2103@student.miun.se
*/
?>
<?php

class Food
{
    //Properties
    private $id;
    private $name;
    private $description;
    private $price;
    private $category;
    private $db;

    //Constructor med db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        if ($this->db->connect_errno > 0) {
            die("Error connecting" . $this->db->connect_error);
        }
    }


    //Get-metod för kurser
    public function getFood(): array
    {
        $sql = "SELECT * FROM food;";
        $result = $this->db->query($sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    //Hämta specifik kurs från id 
    public function getFoodById($id)
    {
        $id = intval($id);
        $sql = "SELECT * FROM food WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();

        $row = mysqli_fetch_array($result);

        return $row;
    }
    //Set-metod för kod, kursnamn, progression och kursplan
    public function setFood(string $name, string $description, string $price, string $category): bool
    {   
        if ($name != "" && $description != "" && $price > 5  && $category != "") {
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->category = $category;
            return true;
        } else {
            return false;
        }

        $name= strip_tags($name, '<i> <b> <em>');
        $description = strip_tags($description, '<i> <b> <em>');
        $price = strip_tags($price, '<i> <b> <em>');

        $name = $this->db->real_escape_string($name);
        $description = $this->db->real_escape_string($description);
        $price = $this->db->real_escape_string($price);
        $category = $this->db->real_escape_string($category);
    }

    //Set-metod för kurser samt ID
    public function setFoodAndId(int $id, string $name, string $description, string $price, string $category): bool
    {
        $id = intval($id);
        $this->id=$id;

        if ($name != "" && $description != "" && $price > 5 && $category != "") {
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->category = $category;
            return true;
        } else {
            return false;
        }
        $name= strip_tags($name, '<i> <b> <em>');
        $description = strip_tags($description, '<i> <b> <em>');
        $price = strip_tags($price, '<i> <b> <em>');

        $name = $this->db->real_escape_string($name);
        $description = $this->db->real_escape_string($description);
        $price = $this->db->real_escape_string($price);
        $category = $this->db->real_escape_string($category);
    }

    //Lägg till kurs
    public function createFood(): bool
    {        
        //Kolla så allt stämmer med hjälp av set-metoder
        if (!$this->setFood($this->name, $this->description, $this->price, $this->category)) return false;

        //SQL query 
        $sql = "INSERT INTO food(name, description, price, category)VALUES('" . $this->name . "','" . $this->description . "','" . $this->price . "','" . $this->category  . "');";

        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Uppdatera kurs
    public function updateFood(): bool
    {
        //Kolla så allt stämmer med hjälp av set-metoder
        if (!$this->setFoodAndId($this-> id, $this->name, $this->description, $this->price, $this->category)) return false;

        //SQL query
        $sql = "UPDATE food SET name='" . $this->name . "', description='" . $this->description . "', price='" .  $this->price . "', category='" . $this->category .  "' WHERE id=$this->id;";


        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Radera kurs
    public function deleteFood(int $id): bool
    {
        $id = intval($id);

        //Sql query
        $sql = "DELETE FROM food WHERE id=$id;";

        //Send query
        return mysqli_query($this->db, $sql);
    }

    //destructor
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
