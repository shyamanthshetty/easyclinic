<?php

class Users{
    public $U_id;
    public $U_name;
    public $U_clinic_name;
    public $U_email;
    public $U_password;
    public $Doc_id;
    public $createdAt;
    public $modifiedAt;
    public $conn;
    private $table = 'users';

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function clinics()
    {
        $query = 'select * from '.$this->table;
        $res = $this->conn->query($query);

        if($res->num_rows > 0)
            return $res;
        return false;
    }

    public function addUser()
    {
        $query = $this->conn->prepare("INSERT INTO ".$this->table." (U_name,U_clinic_name,U_email,U_password,Doc_id) VALUES (?,?,?,?,NULL);");
        $query->bind_param("ssss",$this->U_name,$this->U_clinic_name,$this->U_email,$this->U_password);
        if($query->execute()){
            $this->U_id = $query->insert_id;
            return true;
        }
        return false;
    }

    public function getDocId()
    {
        $query = $this->conn->prepare("select Doc_id from ".$this->table." where U_id=?");
        $query->bind_param("i",$this->U_id);
        if($query->execute()){
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            return $row;
        }
        return false;
    }

    public function updateDocId()
    {
        $query = $this->conn->prepare("update ".$this->table." set Doc_id=? where U_id=?");
        $query->bind_param("ii",$this->Doc_id,$this->U_id);
        if($query->execute())
            return true;
        return false;
    }

    public function validateUId()
    {
        $query = "select U_name from ".$this->table." where U_id=".$this->U_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0)
            return true;
        return false;
    }

    public function getDetailsByEmail()
    {
        $query = "select U_email,U_password,U_name,U_clinic_name,Doc_id from ".$this->table." where U_email='".$this->U_email."'";
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $this->U_name = $row['U_name'];
            $this->U_email = $row['U_email'];
            $this->U_password = $row['U_password'];
            $this->U_clinic_name = $row['U_clinic_name'];
            $this->Doc_id = $row['Doc_id'];
            return true;
        }
        return false;
    }
}

?>