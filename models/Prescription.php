<?php


class Prescription{
    public $Presc_id;
    public $Presc_medicine;
    public $Presc_directions;
    public $Presc_course;
    public $Presc_instructions;
    public $diag_id;
    public $conn;
    private $table = "prescription";

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addPrescription()
    {
        $query = $this->conn->prepare("INSERT INTO ".$this->table." (Presc_medicine,Presc_directions,Presc_course,Presc_instructions,diag_id) VALUES (?,?,?,?,?)");
        $query->bind_param("ssiii",$this->Presc_medicine,$this->Presc_directions,$this->Presc_course,$this->Presc_instructions,$this->diag_id);
        if($query->execute()){
            $this->Presc_id = $query->insert_id;
            return true;
        }
        return false;
    }

    public function getPresciptions()
    {
        $query = "select * from ".$this->table." where diag_id=".$this->diag_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0)
            return $res;
        return false;
    }

    public function deletePrescription()
    {
        $query = "delete from " .$this->table." where Presc_id=".$this->Presc_id;
        if($this->conn->query($query))
            return true;
        return false;
    }
}


?>