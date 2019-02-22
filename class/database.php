<?php

namespace ablin42;
use PDO;

class database
{
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $dsn;
    private $pdo;
    private static $_instance;

    public function __construct($db_name, $db_host = "localhost", $db_user = "root", $db_pass = "root42")
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->dsn = "mysql:dbname={$db_name};host={$db_host}";
    }

    public static function getInstance($db_name)
    {
        if (is_null(self::$_instance))
            self::$_instance = new database($db_name);
        return self::$_instance;
    }

    private function getPDO()
    {
        if ($this->pdo === null)
        {
            $pdo = new PDO($this->dsn, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function lastInsertedId()
    {
        $req = $this->getPDO()->lastInsertId();
        return $req;
    }

    public function query($statement, $class_name = null)
    {
        $req = $this->getPDO()->query($statement);
        if ($class_name === null)
            $data = $req->fetchAll(PDO::FETCH_OBJ);
        else
            $data = $req->fetchAll(PDO::FETCH_CLASS, $class_name);
        return $data;
    }

    public function prepare($statement, $attributes, $one = false, $class_name = null)
    {
        $req = $this->getPDO()->prepare($statement);
        $req->execute($attributes);
        if (strpos($statement, "SELECT") !== false)
        {
            if ($class_name === null)
                $req->setFetchMode(PDO::FETCH_OBJ);
            else
                $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
            if ($one)
                $data = $req->fetch();
            else
                $data = $req->fetchAll();
            return $data;
        }
    }
}