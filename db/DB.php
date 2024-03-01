<?php
include 'QueryBuilder.php';
class DB {
    private $host = '192.168.68.222';
    private $db_name = 'sample';
    private $username = 'betsdev';
    private $password = 'betsdev';
    private $port = '3306'; // Default MySQL port

    public function __construct() {
        $this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->db_name}", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function insert($table, $data) {
        $keys = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($keys) VALUES ($values)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);
        return $this->conn->lastInsertId();
    }



    public function delete($table, $where) {
        $query = "DELETE FROM $table WHERE $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function select($table, $columns = '*', $where = '', $join = '', $orderBy = '', $limit = '') {
        $query = "SELECT $columns FROM $table $join";
        if (!empty($where)) {
            $query .= " WHERE $where";
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY $orderBy";
        }
        if (!empty($limit)) {
            $query .= " LIMIT $limit";
        }

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            exit(); 
        }
    }

    public function whereOr($conditions) {
        $where = 'WHERE ';
        foreach ($conditions as $key => $value) {
            $where .= "$key = :$key OR ";
        }
        return rtrim($where, 'OR ');
    }

    public function whereAnd($conditions) {
        $where = 'WHERE ';
        foreach ($conditions as $key => $value) {
            $where .= "$key = :$key AND ";
        }
        return rtrim($where, 'AND ');
    }

    public function join($table, $on, $type = '') {
        return "$type JOIN $table ON $on";
    }

    public function leftJoin($table, $on) {
        return $this->join($table, $on, 'LEFT');
    }

    public function query() {
        return new QueryBuilder($this);
    }
}

?>