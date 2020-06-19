<?php 
	class Services{
		private $idService;
		private $title;
		private $description;
		private $type;
		private $cep;
		private $neighborhood;
		private $state;
		private $city;
		private $phone;
        private $hidePhone;
        private $idUser;
		private $identifier;
		
		public function getIdService(){
			return $this->idService;
		}

		public function setIdService($idService){
			$this->idService = $idService;
		}

		public function getTitle(){
			return $this->title;
		}

		public function setTitle($title){
			$this->title = $title;
		}

		public function getDescription(){
			return $this->description;
		}

		public function setDescription($description){
			$this->description = $description;
		}

		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}

		public function getCep(){
			return $this->cep;
		}

		public function setCep($cep){
			$this->cep = $cep;
		}

		public function getNeighborhood(){
			return $this->neighborhood;
		}

		public function setNeighborhood($neighborhood){
			$this->neighborhood = $neighborhood;
		}

		public function getState(){
			return $this->state;
		}

		public function setState($state){
			$this->state = $state;
		}

		public function getCity(){
			return $this->city;
		}

		public function setCity($city){
			$this->city = $city;
		}

		public function getPhone(){
			return $this->phone;
		}

		public function setPhone($phone){
			$this->phone = $phone;
		}

		public function getHidePhone(){
			return $this->hidePhone;
		}

		public function setHidePhone($hidePhone){
			$this->hidePhone = $hidePhone;
        }
        
        public function getIdUser(){
			return $this->idUser;
		}

		public function setIdUser($idUser){
			$this->idUser = $idUser;
		}

		public function getIdentifier(){
			return $this->identifier;
		}

		public function setIdentifier($identifier){
			$this->identifier = $identifier;
		}
	}
?>