<?php 
	class User{
		private $id;
		private $name;
		private $password;
		private $email;
		private $phone;
		private $vKey;
		private $verified;
		private $createData;
		private $cpf;
		private $rg;

		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->name = $name;
		}

		public function getPassword(){
			return $this->password;
		}

		public function setPassWord($password){
			$this->password = $password;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getPhone(){
			return $this->phone;
		}

		public function setPhone($phone){
			$this->phone = $phone;
		}

		public function getVKey(){
			return $this->vKey;
		}

		public function setVKey($vKey){
			$this->vKey = $vKey;
		}

		public function getVerified(){
			return $this->verified;
		}

		public function setVerified($verified){
			$this->verified = $verified;
		}

		public function getCreateData(){
			return $this->createData;
		}

		public function setCreateData($createData){
			$this->createData = $createData;
		}

		public function getCpf(){
			return $this->cpf;
		}

		public function setCpf($cpf){
			$this->cpf = $cpf;
		}

		public function getRg(){
			return $this->rg;
		}

		public function setRg($rg){
			$this->rg = $rg;
		}
	}
?>