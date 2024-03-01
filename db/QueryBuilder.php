<?php

class QueryBuilder {
    protected $table;
    protected $db;
    protected $where;

    public function __construct($db) {
        $this->db = $db;
    }

    public function table($table) {
        $this->table = $table;
        return $this;
    }

    public function getAll() {
        return $this->db->select($this->table);
    }

    public function first() {
        return $this->db->select($this->table)[0];
    }

    public function where($column, $operator , $value) {
        $this->where = "$column $operator '$value'";
        return $this;
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($data) {
        return $this->db->update($this->table, $data, $this->where);
    }

    public function select(...$columns) {
        return $this->db->select($this->table, implode(', ', $columns));
    }
}
?>