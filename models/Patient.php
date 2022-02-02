<?php

class Patient{
    public $P_id;
    public $P_name;
    public $P_contact;
    public $P_address;
    public $P_password;
    public $conn;
    private $table = "patient";

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    
    function addPatient()
    {
        $query = $this->conn->prepare("INSERT INTO ".$this->table." (P_name,P_contact,P_address,P_password) VALUES (?,?,?,?);");
        $query->bind_param("sdss",$this->P_name,$this->P_contact,$this->P_address,$this->P_password);

        if($query->execute()){
            $this->P_id = $query->insert_id;
            return true;
        }
        return false;
    }

    public function getPatientNameById($pid)
    {
        $query = "select P_name from ".$this->table." where P_id='$pid'";
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            return $row['P_name'];
        }
        return false;
    }
    public function getDetailsByEmail()
    {
        $query = "select P_id,P_name,P_contact,P_password from ".$this->table." where P_contact='".$this->P_contact."'";
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $this->P_id = $row['P_id'];
            $this->P_name = $row['P_name'];
            $this->P_contact = $row['P_contact'];
            $this->P_password = $row['P_password'];
            return true;
        }
        return false;
    }
    public function getPatientDetails()
    {
        $query = "select * from ".$this->table." where P_id=".$this->P_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            return $res;
        }
        return false;
    }

    public function updatePatient()
    {
        $query = "update ".$this->table." set P_name='".$this->P_name."' , P_contact='".$this->P_contact."' , P_address='".$this->P_address."' , P_password='".$this->P_password."' where P_id=".$this->P_id;
        if($this->conn->query($query)){
            return true;
        }
        return false;
    }
}

?>