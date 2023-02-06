<?php
/* 
Code by Lisa Bäcklin, Mittuniversitetet
Email: liba2103@student.miun.se
*/
?>

<?php

class Login
{
    //Properties
    private $username;
    private $password;
    private $db;

    //Constructor med db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        if ($this->db->connect_errno > 0) {
            die("Error connecting" . $this->db->connect_error);
        }
    }
    
    //Set-metod
    public function setUser(string $username, string $password)
    {
        if ($username && $password != "") {
            $this->username = $username;
            $this->password = $password;
            return true;
        } else {
            return false;
        }

        $username= strip_tags($username, '<i> <b> <em>');
        $password = strip_tags($password, '<i> <b> <em>');

        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);
    }


      //Login existing user
    public function loginUser($username, $password): bool
    {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);

        $sql = "SELECT * FROM users WHERE username = '$username';";
        $result = $this->db->query($sql);



        //Check if username and password is in database
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $password = $row['password'];
            $username = $row['username'];

            if ($password == $password) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //destructor
    function __destruct()
    {
        mysqli_close($this->db);
    }

}
