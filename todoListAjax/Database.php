<?php

class Database
{
        private PDO $db;

        public function __construct()
        {
                $this->db = new PDO('mysql:host=localhost:3306;dbname=todos', 'root', '1234');
        }

        public function query($sql)
        {
                return $this->db->query($sql);
        }

        public function fetch($sql)
        {
                return $this->query($sql)->fetch();
        }

        public function fetchAll($sql)
        {
                return $this->query($sql)->fetchAll();
        }

        public function insert($table, $data)
        {
                $fields = implode(', ', array_keys($data));
                $values = implode("', '", $data);
                $sql = "INSERT INTO $table ($fields) VALUES ('$values')";
                return $this->query($sql);
        }

        public function update($table, $data, $where)
        {
                $set = '';
                foreach ($data as $field => $value) {
                        $set .= "$field = '$value', ";
                }
                $set = rtrim($set, ', ');
                $sql = "UPDATE $table SET $set WHERE $where";
                return $this->query($sql);
        }

        public function delete($table, $where)
        {
                $sql = "DELETE FROM $table WHERE $where";
                return $this->query($sql);
        }

        public function lastInsertId()
        {
                return $this->db->lastInsertId();
        }

        public function count($sql)
        {
                return $this->query($sql)->rowCount();
        }

        public function escape($string)
        {
                return $this->db->quote($string);
        }

        public function error()
        {
                return $this->db->errorInfo();
        }
}