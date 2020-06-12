<?php 
	require_once "Connection.php";

	class ServicesTypesDao{

        //SELECT
        public function selectServicesTypes(){
			$sql = "SELECT * FROM services_types";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
		}
    }
?>