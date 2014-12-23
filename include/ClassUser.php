<?php
	/**********************************************************************
	*
	* Auteur : Cyrille MOFFO
	* Date de création 		: 07/12/2013
	* Date de modification 	: 07/12/2013
	*
	***********************************************************************
	* Classe des utilisateurs.
	*		- Suivi des informations.
	* 		- Mise à jour des connexions.
	*
	* MasterDB
	* --------
	* Classe de la base de données globale.
	*
	*
	**********************************************************************/
	@session_start ();
	require_once("ClassDB.php");
	/*Connect*/
	Define ("CONNECTED" , 1);
	Define ("BAD_LOGIN", -1);
	Define ("NOT_LOGGED" , 0);
	
	class User extends Database
	{
		private $Connect = NOT_LOGGED;
		
		function User()
		{
		}
		
		/**
		 * Fonction connection
		 * -------------------
		 * Fonction qui retourne True si la connexion a réussie et False sinon.
		 *
		 * @param string $login
		 * @param string $password
		 * @return boolean
		 */
		public function connection ($login, $password)
		{
			parent::__construct();

			if (!empty ($_SESSION) && isset($_SESSION ["connected"]) && $_SESSION ["connected"] == true)
			{
				$this->Connect = true;
				// Mise à jour des informations si le mdp a été modifié par exemple.
				$id_user = $this->GetIdUserFromLogin( $login );
				if( $id_user != NULL )
					$_SESSION ["infoUser"] = $this->GetInfoUser ($id_user);
			}
			else
			{
				if (!$this->Connect)
				{
					$connect = $this->authenticate($login, $password);
					$_SESSION['connected'] = $connect !== false;
					if ($_SESSION['connected'])
					{
						$id_user = $this->GetIdUserFromLogin( $login );
						if( $id_user != NULL )
						{
							$_SESSION ["infoUser"] = $this->GetInfoUser ($id_user);
							$_SESSION["wasConnected"] = false;
							// On indique ici une information de connexion dans la base de données.
							$this->Connect = CONNECTED;
						}
						else
						{
							$this->Disconnect(1);
						}
					}
					else
					{
						$this->Disconnect(1);
					}
				}
				else
				{
					// On met à jour l'information dans la session concernant cette personne.
					$id_user = $this->GetIdUserFromLogin( $login );
					if( $id_user != NULL )
					{
						$_SESSION ["infoUser"] = $this->GetInfoUser ($id_user);
						// On indique ici une information de connexion dans la base de données.
						$this->Connect = CONNECTED;
					}
					else
					{
						$this->Disconnect(1);
					}
				}
				return $this->Connect;
			}
		}

		public function Connected()
		{
			return $this->Connect;
		}

		public function Disconnect($error = 0)
		{
		  if ($error == 1)
		  {
			$this->Connect = BAD_LOGIN;
		  }
		  else
		  {
			$this->Connect = NOT_LOGGED;
		  }
		  return $this->Connect;
		}
		
		public function templateAssign(&$tpl,$data){
			foreach($data as $key=>$value){
				$tpl->assign($key,$value);
			}
		}
	}
?>