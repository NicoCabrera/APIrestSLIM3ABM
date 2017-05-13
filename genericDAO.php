<?php 

require_once 'db.php';

class GenericDAO
{

	private static function getPDO() 
	{	
		return $PDOInstance = DB::getInstance(); 
	}

    public static function getAll($table){

        try{
			$db = GenericDAO::getPDO();

			$sql = "select * from ".$table;
			$statement = $db->sendQuery($sql);
			$statement->execute();
            $rv = $statement->fetchAll(PDO::FETCH_ASSOC);
			return json_encode($rv);
		}catch(Exception $ex){
			die("Error: " . $ex->getMessage());
		}
    }

    /* TODO: add more methods */
}
?>