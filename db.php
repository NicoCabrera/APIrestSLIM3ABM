<?php
class DB{
    private static $instance;
    private $_instancePDO;
 
    private function __construct()
    {
        try { 
            $DNS = 'mysql:host=localhost;';
            $DBName = 'dbname=abmexample;';
            $username = 'root';
            $password = '';

            $this->_instancePDO = new PDO($DNS. $DBName . 'charset=utf8', $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->_instancePDO->exec("SET CHARACTER SET utf8");
            } 
        catch (PDOException $e) { 
            print "Error!: " . $e->getMessage(); 
            die();
        }
    }
 
    public function sendQuery($sql)
    { 
        return $this->_instancePDO->prepare($sql); 
    }
    
    public static function getInstance()
    { 
        if (!isset(self::$instance)) {          
            self::$instance = new DB(); 
        } 
        return self::$instance;        
    }
 
    // Prevents the object from being cloned
    public function __clone()
    { 
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR); 
    }
}

?>