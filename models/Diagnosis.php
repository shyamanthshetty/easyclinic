<?php

class Diagnosis{
    public $diag_id;
    public $diagnosis;
    public $app_id;
    public $conn;
    private $table = "diagnosis";

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getDiagnosis()
    {
        $query = "select * from ".$this->table." where app_id=".$this->app_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            return $res;
        }

        return false;
    }

    function addDiagnosis()
    {
        $query = $this->conn->prepare("INSERT INTO ".$this->table." (diagnosis,app_id) VALUES (?,?)");
        $query->bind_param("si",$this->diagnosis,$this->app_id);
        if($query->execute()){
            $this->diag_id = $query->insert_id;
            return true;
        }
        return false;


        // $query = "insert into ".$this->table." (diagnosis,app_id) values ('".$this->diagnosis."',".$this->app_id.")";
        // var_dump($query);
        // die("ksd");
        // if($this->conn->query($query)){
        //     return true;
        // }
        // return false;
    }

}

?>