<?php 
	require_once "Connection.php";

	class ServicesDao{
		//INSERTS
		public function insertService(Services $services){
			$sql = "INSERT INTO services (title, description, type, cep, neighborhood, state, city, phone, hidePhone, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $services->getTitle());
			$stmt->bindValue(2, $services->getDescription());
			$stmt->bindValue(3, $services->getType());
			$stmt->bindValue(4, $services->getCep());
			$stmt->bindValue(5, $services->getNeighborhood());
			$stmt->bindValue(6, $services->getState());
			$stmt->bindValue(7, $services->getCity());
			$stmt->bindValue(8, $services->getPhone());
			$stmt->bindValue(9, $services->getHidePhone());
			$stmt->bindValue(10, $services->getIdUser());			

			$stmt->execute();
		}

		//SELECTS
		public function selectUserServices($id_user) {
			$sql = "SELECT * FROM services WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $id_user);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["servicesNotFound"] = true;
			}
		}

		public function selectService($id_service, $id_user) {
			$sql = "SELECT * FROM services WHERE id_service = ? AND id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $id_service);
			$stmt->bindValue(2, $id_user);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["serviceNotFound"] = true;
			}
		}

		//UPDATES
		public function udpateService(Services $services){
			$sql = "UPDATE services SET title = ?, description = ?, type ?, cep = ?, neighborhood = ?, state = ?, city = ?, phone = ?, hidePhone = ? WHERE id_service = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $services->getTitle());
			$stmt->bindValue(2, $services->getDescription());
			$stmt->bindValue(3, $services->getType());
			$stmt->bindValue(4, $services->getCep());
			$stmt->bindValue(5, $services->getNeighborhood());
			$stmt->bindValue(6, $services->getState());
			$stmt->bindValue(7, $services->getCity());
			$stmt->bindValue(8, $services->getPhone());
			$stmt->bindValue(9, $services->getHidePhone());
			$stmt->bindValue(10, $services->getIdService());	
			$stmt->execute();			
		}

		//DELETES
		public function deleteService($idService){
			$sql = "DELETE FROM services WHERE id_service = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $idService);

			$stmt->execute();
		}
    }
?>