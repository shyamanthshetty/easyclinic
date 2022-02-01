<?php

class Appointment{
    public $App_id;
    public $App_time;
    public $App_date;
    public $App_done;
    public $Doc_id;
    public $P_id;
    public $conn;
    private $table = 'appointment';

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addAppointment()
    {
        $query = $this->conn->prepare("insert into ".$this->table." (App_time,App_date,Doc_id,P_id) values (?,?,?,?)");
        $query->bind_param("isii",$this->App_time,$this->App_date,$this->Doc_id,$this->P_id);
        if($query->execute())
            return true;
        return false;
    }

    public function getTodaysAppointmentCount()
    {
        $query = "select count(*) from ".$this->table." where App_date='".$this->App_date."' and Doc_id=".$this->Doc_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            return $row['count(*)'];
        }
        return 0;
    }

    public function getTodaysAppointmentDoneCount()
    {
        $query = "select count(*) from ".$this->table." where App_date='".$this->App_date."' and App_done=1 and Doc_id=".$this->Doc_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            return $row['count(*)'];
        }
        return 0;
    }

    public function getTodaysAppointmentPendingCount()
    {
        $query = "select count(*) from ".$this->table." where App_date='".$this->App_date."' and App_done=0 and Doc_id=".$this->Doc_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            return $row['count(*)'];
        }
        return 0;
    }

    public function getAppointments()
    {
        $query = "select * from ".$this->table." where App_date='".$this->App_date."' and App_done=0 and Doc_id=".$this->Doc_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            return $res;
        }
        return 0;
    }

    public function getAppointmentsByPatientId()
    {
        $query = "select * from ".$this->table." where App_date='".$this->App_date."' and App_done=0 and P_id=".$this->P_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            return $res;
        }
        return 0;
    }

    public function getDiagnosedAppointmentsByPatientId()
    {
        $query = "select * from ".$this->table." where App_done=1 and P_id=".$this->P_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            return $res;
        }
        return 0;
    }

    public function getAppointment()
    {
        $query = "select * from ".$this->table." where App_id=".$this->App_id;
        $res = $this->conn->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            return $row;
        }
        return 0;
    }

    public function deleteAppointment()
    {
        $query = "delete from " .$this->table." where App_id=".$this->App_id;
        if($this->conn->query($query))
            return true;
        return false;
    }

    public function updateAppointment()
    {
        $query = "update " .$this->table." set App_done=1 where App_id=".$this->App_id;
        if($this->conn->query($query))
            return true;
        return false;
    }
}

?>