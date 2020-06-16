<?php 
	require_once "Connection.php";

	class UfDao{
				//SELECTS
		public function selectUf() {
			$sql = "SELECT Uf FROM states";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			} 
		}
    }
?>