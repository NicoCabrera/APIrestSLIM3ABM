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

	public static function insert($table,$params){

        try{
			$db = GenericDAO::getPDO();

			$sql = "insert into ".$table . " (nombre, apellido, dni, foto, sexo) values (:nombre, :apellido, :dni, :foto, :sexo)"; //<--- modificar por los campos necesarios
			$statement = $db->sendQuery($sql);
			$statement->bindValue(":nombre", $params['nombre'], PDO::PARAM_STR);
			$statement->bindValue(":apellido", $params['apellido'], PDO::PARAM_STR);
			$statement->bindValue(":dni", $params['dni'], PDO::PARAM_STR);			 //para otros tipos de constantes predefinidas ver http://php.net/manual/es/pdo.constants.php
			$statement->bindValue(":foto", $params['foto'], PDO::PARAM_STR);
			$statement->bindValue(":sexo", $params['sexo'], PDO::PARAM_STR);
			$statement->execute();

		}catch(Exception $ex){
			$message = $ex->getMessage();
			die("Error: " . $ex->getMessage());
		}
    }

	public static function update($table,$params){

        try{
			$db = GenericDAO::getPDO();

			$sql = "update ".$table . " set nombre = :nombre,  apellido = :apellido, dni = :dni, foto = :foto, sexo = :sexo where id=:id"; //<---- modificar los campos que sean necesarios
			$statement = $db->sendQuery($sql);
			$statement->bindValue(":id", $params["id"], PDO::PARAM_INT);
			$statement->bindValue(":nombre", $params['nombre'], PDO::PARAM_STR);
			$statement->bindValue(":apellido", $params['apellido'], PDO::PARAM_STR);
			$statement->bindValue(":dni", $params['dni'], PDO::PARAM_STR);			//para otros tipos de constantes predefinidas ver http://php.net/manual/es/pdo.constants.php
			$statement->bindValue(":foto", $params['foto'], PDO::PARAM_STR);
			$statement->bindValue(":sexo", $params['sexo'], PDO::PARAM_STR);
			$statement->execute();

		}catch(Exception $ex){
			$message = $ex->getMessage();
			die("Error: " . $ex->getMessage());
		}
    }

	public static function delete($table,$id){

        try{
			$db = GenericDAO::getPDO();

			$sql = "delete from ".$table . " where id = :id"; //<--- modificar por la condición necesaria
			$statement = $db->sendQuery($sql);
			$statement->bindValue(":id", $id, PDO::PARAM_INT);	//para otros tipos de constantes predefinidas ver http://php.net/manual/es/pdo.constants.php
			$statement->execute();

		}catch(Exception $ex){
			$message = $ex->getMessage();
			die("Error: " . $ex->getMessage());
		}
    }
}
?>