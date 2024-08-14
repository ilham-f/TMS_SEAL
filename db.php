<?php 

class db{
 
    function __construct(){

        $dbname = "task_management";
        $host = "localhost";
        $uname = "root";
        $pass = "";

        $this->db = new PDO("mysql:host=$host;dbname=$dbname", $uname, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

}
 
?>