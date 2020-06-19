<?php 
	require_once "Connection.php";

	class ServicesDao{
		//INSERTS
		public function insertService(Services $services){
			$sql = "INSERT INTO services (title, description, type, cep, neighborhood, state, city, phone, hidePhone, id_user, identifier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
			$stmt->bindValue(11, $services->getIdentifier());			

			$stmt->execute();
		}

		//SELECTS
		public function selectUserServices($id_user) {
			$sql = "SELECT * FROM services WHERE id_user = ? ORDER BY createData DESC";

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

		public function selectByIdServiceAndIdentifier($id_service, $identifier) {
			$sql = "SELECT * FROM services WHERE id_service = ? AND identifier = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $id_service);			
			$stmt->bindValue(2, $identifier);			
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["serviceNotFound"] = true;
			}
		}

		public function selectTop6Services() {
			$sql = "SELECT * FROM services ORDER BY createData DESC LIMIT 6";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["serviceNotFound"] = true;
			}
		}

		public function selectAllServicesWhere($search) {
			$sql = "SELECT * FROM services WHERE title LIKE ? OR description LIKE ? ORDER BY createData DESC";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, "%". $search ."%");	
			$stmt->bindValue(2, "%". $search ."%");
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["serviceNotFound"] = "Nenhum anúncio foi encontrado com esse termo de pesquisa :(";
			}
		}

		public function selectServiceByUf($uf) {
			$sql = "SELECT * FROM services WHERE state = ? ORDER BY createData DESC";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $uf);			
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["serviceNotFound"] = "Ainda não há anúncios no estado de ". $uf .".";
			}
		}

		//UPDATES
		public function udpateService(Services $services){
			$sql = "UPDATE services SET title = ?, description = ?, type = ?, cep = ?, neighborhood = ?, state = ?, city = ?, phone = ?, hidePhone = ? WHERE id_service = ?";

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