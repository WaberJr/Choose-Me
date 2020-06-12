<?php 
	require_once "Connection.php";

	class UserDao{
		//INSERTS

		//Insert User
		public function insert(User $user){
			$sql = "INSERT INTO users (name, password, email, vKey) VALUES (?, ?, ?, ?)";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $user->getName());
			$stmt->bindValue(2, $user->getPassword());
			$stmt->bindValue(3, $user->getEmail());
			$stmt->bindValue(4, $user->getVKey());

			$stmt->execute();
		}

		public function insertUserPhone($phone, $id){
			$sql = "INSERT INTO phones (phone, id_user) VALUES (?, ?)";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $phone);
			$stmt->bindValue(2, $id);

			$stmt->execute();
		}

		public function insertUserAddress($cep, $street, $number, $neighborhood, $complement, $city, $state, $id){
			$sql = "INSERT INTO address (cep, street, number, neighborhood, complement, city, state, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $cep);
			$stmt->bindValue(2, $street);
			$stmt->bindValue(3, $number);
			$stmt->bindValue(4, $neighborhood);
			$stmt->bindValue(5, $complement);
			$stmt->bindValue(6, $city);
			$stmt->bindValue(7, $state);
			$stmt->bindValue(8, $id);

			$stmt->execute();
		}

		//DELETES

		public function deleteUserPhone($id){
			$sql = "DELETE FROM phones WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $id);

			$stmt->execute();
		}

		//SELECTS

		//E-mail and Login validation
		public function selectUserEmail($email){
			$sql = "SELECT email, verified, createData FROM users WHERE email = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $email);

			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if($result["0"]["verified"] == 1){
					$_SESSION["emailVerified"] = true;
					return $result;
				}
				else{
					$_SESSION["dateSent"] = $result["0"]["createData"];
					$_SESSION["emailNotVerified"] = true;
				}
			}
			else{
				$_SESSION["emailNotFound"] = true;
			}
		}

		public function selectUser($email, $password){
			$sql = "SELECT * FROM users WHERE email = ? AND password = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $email);
			$stmt->bindValue(2, $password);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["userNotFound"] = true;
			}
		}

		public function selectUserById($id){
			$sql = "SELECT * FROM users WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $id);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
		}

		public function selectVerifyUser($vKey){
			$sql = "SELECT verified, vKey FROM users WHERE verified = 0 AND vKey = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $vKey);
			$stmt->execute();

			if($stmt->rowCount() != null){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			else{
				$_SESSION["verificationNotFound"] = true;
			}
		}	
		
		public function selectUserPhones($id){
			$sql = "SELECT * FROM phones WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $id);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$_SESSION["phoneNotFound"] = false;
				return $result;
			}
			else{
				$_SESSION["phoneNotFound"] = true;
			}
		}

		public function selectUserAddress($id){
			$sql = "SELECT * FROM address WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $id);
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$_SESSION["addressNotFound"] = false;
				return $result;
			}
			else{
				$_SESSION["addressNotFound"] = true;
			}
		}

		//UPDATES
		public function udpateUserData(User $user, $id){
			$sql = "UPDATE users SET name = ?, cpf = ?, rg = ? WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $user->getName());
			$stmt->bindValue(2, $user->getCpf());
			$stmt->bindValue(3, $user->getRg());
			$stmt->bindValue(4, $id);
			$stmt->execute();			
		}

		public function updateUserPhone($phone, $id){
			$sql = "UPDATE phones SET phone = ? WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $phone);
			$stmt->bindValue(2, $id);			
			$stmt->execute();			
		}

		public function udpateUserAddress($cep, $street, $number, $neighborhood, $complement, $city, $state, $id){
			$sql = "UPDATE address SET cep = ?, street = ?, number = ?, neighborhood = ?, complement = ?, city = ?, state = ? WHERE id_user = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $cep);
			$stmt->bindValue(2, $street);
			$stmt->bindValue(3, $number);
			$stmt->bindValue(4, $neighborhood);
			$stmt->bindValue(5, $complement);
			$stmt->bindValue(6, $city);
			$stmt->bindValue(7, $state);
			$stmt->bindValue(8, $id);
			$stmt->execute();			
		}

		//VERIFICATION
		public function verifyUser($vKey){
			$sql = "UPDATE users SET verified = 1 WHERE vKey = ?";

			$stmt = Conexao::getConn()->prepare($sql);
			$stmt->bindValue(1, $vKey);
			$stmt->execute();
		}
	}
?>