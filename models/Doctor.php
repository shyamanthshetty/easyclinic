<?php

class Doctor{
    public $Doc_id;
    public $Doc_name;
    public $Doc_contact;
    public $Doc_specialization;
    public $conn;
    private $table = 'doctor';

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addDoctor()
    {
        $query = $this->conn->prepare("insert into ".$this->table." (Doc_name,Doc_contact,Doc_specialization) values (?,?,?)");
        $query->bind_param("sss",$this->Doc_name,$this->Doc_contact,$this->Doc_specialization);
        if($query->execute()){
            $this->Doc_id = $query->insert_id;
            return true;
        }
        return false;
    }

    public function getDoctor()
    {
        $query = "select * from ".$this->table." where Doc_id=".$this->Doc_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            return $res;
        }
        return false;
    }

    public function updateDoctor()
    {
        $query = "update ".$this->table." set Doc_name='".$this->Doc_name."' , Doc_contact='".$this->Doc_contact."' , Doc_specialization='".$this->Doc_specialization."' where Doc_id=".$this->Doc_id;
        if($this->conn->query($query)){
            return true;
        }
        return false;
    }
}

?>