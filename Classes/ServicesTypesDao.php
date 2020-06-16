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

		public function selectServicesTypesById($type){
			$sql = "SELECT description FROM services_types WHERE id_service_type = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $type);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
		}
    }
?>