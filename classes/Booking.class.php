<?php
/* 
Code by Lisa Bäcklin, Mittuniversitetet
Email: liba2103@student.miun.se
*/
?>

<?php

class Booking
{
    //Properties
    private $id;
    private $name;
    private $time;
    private $date;
    private $quantity;
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
    public function getReservation(): array
    {
        $sql = "SELECT * FROM booking;";
        $result = $this->db->query($sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    //Hämta specifik kurs från id 
    public function getReservationById($id)
    {
        $id = intval($id);
        $sql = "SELECT * FROM booking WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();

        $row = mysqli_fetch_array($result);

        return $row;
    }
    //Set-metod för kod, kursnamn, progression och kursplan
    public function setReservation(string $name, string $time, string $date, int $quantity): bool
    {   
        if ($name && $time && $date && $quantity != "") {
            $this->name = $name;
            $this->time = $time;
            $this->date = $date;
            $this->quantity = $quantity;
            return true;
        } else {
            return false;
        }

        $name= strip_tags($name, '<i> <b> <em>');
        $time= strip_tags($time, '<i> <b> <em>');
        $date = strip_tags($date, '<i> <b> <em>');
        $quantity = strip_tags($quantity, '<i> <b> <em>');

        $name = $this->db->real_escape_string($name);
        $time = $this->db->real_escape_string($time);
        $date = $this->db->real_escape_string($date);
        $quantity = $this->db->real_escape_string($quantity);
    }

    //Set-metod för kurser samt ID
    public function setReservationAndId(int $id, string $name, string $time, string $date, int $quantity): bool
    {
        $id = intval($id);
        $this->id=$id;

        if ($name && $time && $date && $quantity != "") {
            $this->name = $name;
            $this->time = $time;
            $this->date = $date;
            $this->quantity = $quantity;
            return true;
        } else {
            return false;
        }

       $name= strip_tags($name, '<i> <b> <em>');
       $time= strip_tags($time, '<i> <b> <em>');
        $date = strip_tags($date, '<i> <b> <em>');
        $quantity = strip_tags($quantity, '<i> <b> <em>');

        $name = $this->db->real_escape_string($name);
        $time = $this->db->real_escape_string($time);
        $date = $this->db->real_escape_string($date);
        $quantity = $this->db->real_escape_string($quantity);
    }

    //Lägg till kurs
    public function createReservation(): bool
    {        
        //Kolla så allt stämmer med hjälp av set-metoder
        if (!$this->setReservation($this->name, $this->time, $this->date, $this->quantity)) return false;

        //SQL query 
        $sql = "INSERT INTO booking(name, time, date, quantity)VALUES('" . $this->name . "','" .$this->time . "','" . $this->date . "','" . $this->quantity . "');";

        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Uppdatera kurs
    public function updateReservation(): bool
    {
        //Kolla så allt stämmer med hjälp av set-metoder
        if (!$this->setReservationAndId($this-> id, $this->time, $this->name, $this->date, $this->quantity)) return false;

        //SQL query
        $sql = "UPDATE booking SET name='" . $this->name . "', time='" . $this->time ."', date='" . $this->date . "', quantity='" .  $this->quantity . "' WHERE id=$this->id;";


        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Radera kurs
    public function deleteReservation(int $id): bool
    {
        $id = intval($id);

        //Sql query
        $sql = "DELETE FROM booking WHERE id=$id;";

        //Send query
        return mysqli_query($this->db, $sql);
    }

    //destructor
    function __destruct()
    {
        mysqli_close($this->db);
    }
}