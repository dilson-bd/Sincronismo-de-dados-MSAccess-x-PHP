<?php
class conexDB_class{
  private $_database;

    public function __construct(PDO $pdo) {
        $this->_database = $pdo;
    }
    
    public function getConectar(){
        return $this->_database;
    }
}