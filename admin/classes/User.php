<?php
date_default_timezone_set('Asia/Jakarta');

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->connection();
    }
}
