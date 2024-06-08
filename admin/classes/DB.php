<?php

class DB
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $database = new Database();
        $this->conn = $database->connection();
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function connection()
    {
        return $this->conn;
    }

    public function add($table, $data)
    {
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO $table ($fields) VALUES ($values)";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function update($table, $data, $where)
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key=:$key, ";
        }
        $set = rtrim($set, ", ");

        $setWhere = '';
        foreach ($where as $key => $value) {
            if (count($where) > 1) {
                if (next($where)) {
                    $setWhere .= "$key=:$key AND ";
                } else {
                    $setWhere .= "$key=:$key";
                }
            } else {
                $setWhere .= "$key=:$key";
            }
        }
        $setWhere = rtrim($setWhere, ", ");

        $query = "UPDATE $table SET $set WHERE $setWhere";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }
}