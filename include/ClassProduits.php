<?php
	/**********************************************************************
	*
	* Auteur : Cyrille MOFFO
	* Date de création 		: 07/12/2013
	* Date de modification 	: 07/12/2013
	*
	***********************************************************************
	* Classe des produits.
	*		- Suivi des informations.
	* 		- Mise à jour des produits.
	*
	*
	*
	**********************************************************************/
	class Produits
	{
		private $designation;
		private $stockInitial;
		private $stockPhysique;
		private $prixAchat;
		private $prixVente;
		private $dateFabrication;
		private $datePeremption;
		private $dateInsertion;

		public function setDesignation($designation){
			$this->designation = strtoupper(htmlspecialchars($designation));
		}
		public function getDesignation(){
			return $this->designation;
		}
		
		public function setAchat($achat){
			$this->achat = htmlspecialchars($achat);
		}
		public function getAchat(){
			return $this->achat;
		}
		
		public function setStockPhysique($stockPhysique){
			$this->stockPhysique = htmlspecialchars($stockPhysique);
		}
		public function getStockPhysique(){
			return $this->stockPhysique;
		}
		
		public function setPrixAchat($prixAchat){
				$this->prixAchat = htmlspecialchars($prixAchat);
		}
		public function getPrixAchat(){
				return $this->prixAchat;
		}
		
		public function setPrixVente($prixVente){
				$this->prixVente = htmlspecialchars($prixVente);
		}
		public function getPrixVente(){
				return $this->prixVente;
		}
		
		public function setStockInitial($stockInitial){
				$this->stockInitial = htmlspecialchars($stockInitial);
		}
		public function getStockInitial(){
				return $this->stockInitial;
		}
		
		public function setDateFabrication($dateFabrication){
				$dateFabrication = htmlspecialchars($dateFabrication);
				if($this->validateDate($dateFabrication)){
					$this->dateFabrication = $this->changeDateTimeFormat($dateFabrication);
				}
		}
		public function getDateFabrication(){
				return $this->dateFabrication;
		}
		
		public function setDatePeremption($datePeremption){
				$datePeremption = htmlspecialchars($datePeremption);
				if($this->validateDate($datePeremption)){
					$this->datePeremption = $this->changeDateTimeFormat($datePeremption);
				}
		}
		public function getDatePeremption(){
				return $this->datePeremption;
		}
		
		public function setDateInsertion($dateInsertion){
				$this->dateInsertion = htmlspecialchars($dateInsertion);
		}
		public function getDateInsertion(){
				return $this->dateInsertion;
		}
		
		
		public function setLocalTime(){
				$date = new DateTime();
				$date->setTimezone(new DateTimeZone('UTC'));
				$date->setTimezone(new DateTimeZone('Africa/Douala'));
			$this->dateInsertion = $date->format('Y-m-d H:i:s');
		}
		
		public function convertDateTime($date){
			$dateTime = new DateTime($date);
			$convertedDateTime = $dateTime->format('d/m/Y H:i:s');
			if( $convertedDateTime == "01/01/1970 00:00:00"){
				return "";
			}else{
				return $convertedDateTime;
			}
		}

		public function convertDate($date){
			$dateTime = new DateTime($date);
			$convertedDate = $dateTime->format('d/m/Y');
			if( $convertedDate == "01/01/1970 00:00:00"){
				return "";
			}else{
				return $convertedDate;
			}
		}
		
		public function setDefaultDate($date){
			if($date == ""){
				return "01/01/1970";
			}
		}
		
		public function validateDate($dateTime){
				$dateTime = htmlspecialchars($dateTime);
				$dateRegex = "/^(([1-9]|[12]\d|3[0-1])\/)?([1-9]|1[0-2])\/(19|20)\d{2}$/";
				if(preg_match($dateRegex, $dateTime)){
					return true;
				}else{
					return false;
				}
		}
		
		public function changeDateTimeFormat($dateTime){
			$partDateRegex = "/^(0[1-9]|1[0-2])\/(19|20)\d{2}$/";
			if(preg_match($partDateRegex, $dateTime)){
				$dateTime = "01/".$dateTime;
			}
			return date("Y-m-d H:i:s", strtotime(str_replace('/','-',$dateTime)));
		}
		
		public function isNumber($number){
			return is_numeric($number);
		}
		
		public function isString($string){
			if(strlen($string) > 1){
				return true;
			}else {
				return false;
			}
		}
		
		public function setArticle($designation, $stockInitial, $stockPhysique, $prixAchat, $prixVente, $dateFabrication, $datePeremption){
			$this->setDesignation($designation);
			$this->setStockInitial($stockInitial);
			$this->setStockPhysique($stockPhysique);
			$this->setPrixAchat($prixAchat);
			$this->setPrixVente($prixVente);
			$this->setDateFabrication($dateFabrication);
			$this->setDatePeremption($datePeremption);
			$this->setLocalTime();	
		}
		
		public function setRecapitulatif($nomCaissier, $ration, $detteFournisseur, $depensesDiverses, $avaries, $creditClient, $fonds, $recettesPercues){
			$this->setNomCaissier($nomCaissier);
			$this->setRation($ration);
			$this->setDetteFournisseur($detteFournisseur);
			$this->setDepensesDiverses($depensesDiverses);
			$this->setAvaries($avaries);
			$this->setCreditClient($creditClient);
			$this->setFonds($fonds);
			$this->setRecettesPercues($recettesPercues);	
		}
	}
?>