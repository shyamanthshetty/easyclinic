<?php

class Patient{
    public $T_id;
    public $T_fees;
    public $T_name;
    public $Doc_id;
    public $App_id;
    public $conn;
    private $table = "treatment";

    function __construct($conn)
    {
        $this->conn = $conn;
    }

}

?>