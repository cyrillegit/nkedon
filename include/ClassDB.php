<?php
	/**********************************************************************
	*
	* Auteur 				: Cyrille MOFFO (developpement@nemand-soft.com)
	* Date de création 		: 07/12/2013
	* Version 				: 1.0
	*
	***********************************************************************
	* Classe gérant les accès à la base de données et les requêtes.
	*
	* Gestion des FetchRow et FetchRows.
	* Les logs stockent les requêtes en erreur.
	*
	* Database
	* ********
	*	- Connection.
	*	- Logs tracées.
	*	- Synthèse généralisée.
	* 
	**********************************************************************/
	
	@session_start ();
	define ("CRLF", "<br />");
	define ("CLASS_DB", "1");
	header ("Content-type: text/html; character=UTF-8");
	
	class Database extends PDO
	{
		// Année par défaut pour les filtres.
		protected $Annee;
		
		// Mois par défaut pour les filtres.
		protected $Mois;
		
		// Requête SQL.
		protected $Sql;
		
		// Pointeur vers la base de données centrale. Celle qui sera installée en local sur le serveur central.
	//	protected $MasterDB;
		
		protected $LastErrorString;

		// ConnectionString
		protected $Connection;
		
		/**
		 * Constructeur
		 * ------------
		 * Constructeur principal de la classe.
		 *
		 * @return Database
		 */
		function Database ()
		{
			setlocale(LC_TIME, "fr_FR.UTF-8");

			// $hostname = "localhost";
			// $dbname = "nkedon_db";
			// $username = "root";
			// $password = "";
			// try 
			// {
			// 	$connectionString = "mysql:host=".$hostname.";dbname=".$dbname;
				
			// 	parent::__construct(
			// 		$connectionString,
			// 		$username,
			// 		$password
			// 	);
			// }
			// catch (PDOException $dbex) 
			// {
			// 	echo "({'connected': 'false', 'message': 'Impossible de vous connecter à la base de données de Nkedon.'})";
			// }	

			$this->Connection = array ();
			$this->Sql = "";
			
			try 
			{
				$connectionString = "mysql:host=".Configuration::getValue('common_host').";dbname=".Configuration::getValue('common_dbname');
				
				parent::__construct(
					$connectionString,
					Configuration::getValue('common_user'),
					Configuration::getValue('common_password')
				);
			}
			catch (PDOException $dbex) {
				echo 'Impossible de vous connecter à la base de données centrale du BackOffice.';
				throw_error($dbex);
			}	
		}

		/**
		 * Fonction fixEncoding
		 * --------------------
		 * Cette fonction résoud l'encodage UTF-8 en ISO pour gérer correctement les accents.
		 *
		 * @param string $in_str
		 * @return string
		 */
		public function fixEncoding ($in_str)
		{
			$cur_encoding = mb_detect_encoding ($in_str) ;
			
			$buffer = mb_convert_encoding($in_str, 'ISO-8859-1',
						  mb_detect_encoding($in_str, 'UTF-8, ISO-8859-1', true)); 
						  
			// En même temps, ça gagne un temps précieux.
			$buffer = utf8_encode ($buffer);
			return $buffer;
		}
		
		/**
		 * Fonction fixEncodingArray
		 * -------------------------
		 * Cette fonction résoud l'encodage UTF-8 en ISO pour gérer correctement les accents.
		 * Elle est récursive, attention.
		 *
		 * @param Array $array
		 * @return array
		 */
		public function fixEncodingArray(&$array)
		{
			if (($array !== NULL) && (is_array ($array)))
			{
				foreach ($array as &$a)
				{
					if (is_array ($a))
					{
						$this->fixEncodingArray ($a);
					}
					else
					{
						$a = $this->fixEncoding($a);
					}
				}
			}
		}
		
		
		/**
		 * Fonction FetchRow
		 * -----------------
		 * Récupération d'une ligne dans la base de données avec this->Sql déjà initialisé.
		 * Le mode PDO est en option et par défaut, il retourne tout le tableau.
		 * 
		 * @return Array or Null
		 */
		public function FetchRow ($mode = PDO::FETCH_BOTH)
		{
			$recordset = $this->query ($this->Sql);
			if ($recordset)
			{
				$recordset = $recordset->fetch ($mode);
				if (!is_null ($recordset))
				{
					$this->fixEncodingArray ($recordset);
				}
				return $recordset;
			}
			else
			{
				return NULL;
			}
		}
		
		/**
		 * Fonction FetchAllRows
		 * ---------------------
		 * Récupération de toutes les informations disponibles dans le tableau.
		 * 
		 * @return Array or Null
		 */
		public function FetchAllRows ($mode = PDO::FETCH_BOTH)
		{
			$recordset = $this->query ($this->Sql);
			if ($recordset)
			{
				$recordset = $recordset->fetchAll ($mode);
				if (!is_null ($recordset))
				{
					$this->fixEncodingArray ($recordset);
				}
				return $recordset;
			}
			else
			{
				return NULL;
			}
		}

		/**
		 * Fonction Execute
		 * ----------------
		 * Retourne 0 en cas d'erreur et 1 en cas de succ&egrave;s. 
		 * ATTENTION, uniquement des requêtes INSERT, UPDATE ou DELETE ici.
		 * 
		 * Si aucune donn&eacute;e n'a &eacute;t&eacute; &eacute;crite, si la requête n'est pas bonne, on sort False.  
		 *
		 * @param string $this->Sql
		 * @return int
		 */
		public function Execute ($sql)
		{
			try 
			{
				$this->Sql = $sql;
				
				$nb = $this->exec ($this->Sql);
				if ($nb === FALSE)
				{
					error_log ($sql);
					$errorInfo = $this->errorInfo ();
					$mail = new Mail ();
				
					$mail->AddSubject("Nkedon -- Fonction ClassDB::Execute");
					$mail->AddRecipients(array ("Equipe de developpement Nemand Softwares" => Configuration::getValue ("admin_mail")), "To");
					$body = " 
					<html>
					<head>
					</head>
					<body>
					<b><h2>Nkedon</h2></b><br />
					Requête SQL ex&eacute;cut&eacute;e : <b>".$this->Sql."</b><br />
					Code de l'erreur :<br />
					".$errorInfo [1]."
					</br /></br />Description de l'erreur :<br />
					".$errorInfo [2]."
					<br />
					L'&eacute;quipe informatique
					</body>
					</html>";
					$mail->AddBody($body);
					$mail->sendMail();
					return false;
				}
				else
				{
					return true;
				}
			}
			catch (PDOException $e)
			{
				error_log ($sql);
				$mail = new Mail ();
				
				$mail->AddSubject("Nkedon -- Fonction ClassDB::Execute");
				$mail->AddRecipients(array ("Equipe de developpement Nemand Softwares" => Configuration::getValue ("admin_mail")), "To");
				$body = " 
				<html>
				<head>
				</head>
				<body>
				<b><h2>Nkedon</h2></b><br />
				Description de l'erreur :<br />".$e->getMessage()."
				<br />
				Fichier source : ".$e->getFile()."<br />
				Ligne : ".$e->getLine().".<br /><br /><br />
				L'&eacute;quipe informatique
				</body>
				</html>";
				$mail->AddBody($body);
				$mail->sendMail();
				return false;
			}
		}
		
		/**
		 * Fonction authenticate
		 * ---------------------
		 * Cette fonction effectue le test en base de données par rapport au login et au
		 * mot de passe envoyés en paramètre.
		 *
		 * @param string $login.
		 * @param string $password  Il est envoyé déjà crypté.
		 * @return boolean
		 */
		function authenticate ( $login, $password )
		{
			$this->Sql = "SELECT COUNT(*) AS nb 
							FROM t_users u
							WHERE u.login = '$login'
							AND	u.password = '$password'";
			$res = $this->FetchRow ();
			return ($res ["nb"] > 0) ? true : false;
		}

		/**
		 * Fonction getLastInsertedId
		 * --------------------------
		 * On va retourner le dernier ID g&eacute;n&eacute;r&eacute; par une commande INSERT.
		 * 
		 * @return int
		 */
		public function getLastInsertedId ()
		{
			$this->Sql = "SELECT LAST_INSERT_ID()";
			
			$res = $this->query ($this->Sql);
			$row = $res->fetch();
			return $row [0];
		}		
		
		/**
		 * Fonction GetInfoAllUsers
		 * --------------------
		 * On envoie les informations de tous les utilisateurs en base de données.
		 * 
		 * @return Array
		 */
		public function GetInfoAllUsers ()
		{
			$this->Sql = "SELECT *
							FROM t_users";

			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction GetIdUserFromLogin
		 * -------------------
		 * Retourne l'id user de t_users depuis le login de la personne connecté
		 *
		 * @param string $login
		 * @return int
		 */
		public function GetIdUserFromLogin( $login ) 
		{
			$this->Sql = "SELECT idt_users FROM t_users WHERE login = '$login'";
			$res = $this->FetchRow();
			return $res[0];
		}	

		/**
		 * Fonction getNbComptesUtilisateursInDB
		 * -------------------
		 * Retourne le nombre de compte utilisateurs enregistrés dans la base de données.
		 *
		 * @return int
		 */
		public function getNbComptesUtilisateursInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_compte FROM t_users";
			$res = $this->FetchRow();
			return $res ["nb_compte"];
		}	

		/**
		 * Fonction getAllComptesUtilisateurs
		 * -------------------
		 * Retourne les comptes utilisateurs présents en base de données
		 *
		 * @return int
		 */
		public function getAllComptesUtilisateurs ()
		{
			$this->Sql = "SELECT * 
							FROM t_users u 
							JOIN t_types_users tu ON u.id_type_user = tu.idt_types_users";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllComptesUtilisateursWithoutAdmin
		 * -------------------
		 * Retourne les comptes utilisateurs présents en base de données
		 *
		 * @return int
		 */
		public function getAllComptesUtilisateursWithoutAdmin ()
		{
			$this->Sql = "SELECT * 
							FROM t_users u 
							JOIN t_types_users tu ON u.id_type_user = tu.idt_types_users
							WHERE tu.idt_types_users <> 1 AND tu.idt_types_users <> 2";
			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction GetInfoUser
		 * --------------------
		 * On envoie l'identifiant user et toutes ses informations en retour de cette fonction.
		 * 
		 * @return Array
		 */
		public function GetInfoUser ($id_user)
		{
			$this->Sql = "SELECT *
							FROM t_users u
							JOIN t_types_users tu ON tu.idt_types_users = u.id_type_user
							WHERE idt_users = $id_user";

			$res = $this->FetchRow ();

			return $res;
		}

		/**
		 * Fonction getAllTypesComptesUtilisateurs
		 * -------------------
		 * Retourne les types de comptes utilisateurs présent en base de données
		 *
		 * @return int
		 */
		public function getAllTypesComptesUtilisateurs ()
		{
			$this->Sql = "SELECT * 
							FROM t_types_users" ;
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllTypesUsersWithoutAdmin
		 * -------------------
		 * Retourne les types d'utilisateurs en base de données qui ne sont pas "Administrateur" ou "Super Administrateur".
		 *
		 * @return Array
		 */
		public function getAllTypesUsersWithoutAdmin ()
		{
			$this->Sql = "SELECT * 
							FROM t_types_users 
							WHERE (idt_types_users <> 1 AND idt_types_users <> 2)";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getNbTypesUsersInDB
		 * -------------------
		 * Retourne le nombre de type de profils utilisateurs présents en base de données.
		 *
		 * @return int
		 */
		public function getNbTypesUsersInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_profils FROM t_types_users";
			$res = $this->FetchRow();
			return $res ["nb_profils"];
		}

		/**
		 * Fonction getNbProduitsDistintsAchetes
		 * -------------------
		 * Retourne le nombre de produits distints sur une facture.
		 *
		 * @return int
		 */
		public function getNbProduitsDistintsAchetes ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_produits FROM t_produits_factures";
			$res = $this->FetchRow();
			return $res ["nb_produits"];
		}

		/**
		 * Fonction getNbRecapitulatifInventaireInDB
		 * -------------------
		 * Retourne le nombre de recapitulatif d'inventaire.
		 *
		 * @return int
		 */
		public function getNbRecapitulatifInventaireInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_recapitulatif FROM t_recapitulatif";
			$res = $this->FetchRow();
			return $res ["nb_recapitulatif"];
		}				

		/**
		 * Fonction getInfoTypeUser
		 * -------------------
		 * Retourne les types d'utilisateurs en base de données qui ne sont pas "Administrateur" ou "Super Administrateur".
		 *
		 * @return Array
		 */
		public function getInfoTypeUser ( $id )
		{
			$this->Sql = "SELECT * FROM t_types_users WHERE idt_types_users = $id";
			$res = $this->FetchRow();
			return $res;
		}


		/**
		 * Fonction getNbProduitsInDB
		 * -------------------
		 * Retourne le nombre de type de produits présents en base de données.
		 *
		 * @return int
		 */
		public function getNbProduitsInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_produits FROM t_produits";
			$res = $this->FetchRow();
			return $res ["nb_produits"];
		}

		/**
		 * Fonction getNbFournisseursInDB
		 * -------------------
		 * Retourne le nombre de type de fournisseurs présents en base de données.
		 *
		 * @return int
		 */
		public function getNbFournisseursInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_fournisseurs FROM t_fournisseurs";
			$res = $this->FetchRow();
			return $res ["nb_fournisseurs"];
		}	

		/**
		 * Fonction getNbFacturesInDB
		 * -------------------
		 * Retourne le nombre de type de fournisseurs présents en base de données.
		 *
		 * @return int
		 */
		public function getNbFacturesInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_factures FROM t_factures";
			$res = $this->FetchRow();
			return $res ["nb_factures"];
		}

		/**
		 * Fonction getNbHistoriqueSyntheseInDB
		 * -------------------
		 * Retourne le nombre d'historique de syntheses en base de données.
		 *
		 * @return int
		 */
		public function getNbHistoriqueSyntheseInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_histo_syntheses FROM t_historiques_syntheses";
			$res = $this->FetchRow();
			return $res ["nb_histo_syntheses"];
		}

		/**
		 * Fonction getNbHistoriquesFacturesInDB
		 * -------------------
		 * Retourne le nombre d'historique de factures en base de données.
		 *
		 * @return int
		 */
		public function getNbHistoriquesFacturesInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_histo_factures FROM t_historiques_factures";
			$res = $this->FetchRow();
			return $res ["nb_histo_factures"];
		}	

		/**
		 * Fonction getNbHistoriquesFacturesByGroupInDB
		 * -------------------
		 * Retourne le nombre d'historique de factures par groupe en base de données.
		 *
		 * @return int
		 */
		public function getNbHistoriquesFacturesByGroupInDB ( $id )
		{
			$this->Sql = "SELECT COUNT(*) AS nb_histo_factures FROM t_historiques_factures WHERE id_groupes_factures = $id";
			$res = $this->FetchRow();
			return $res ["nb_histo_factures"];
		}	

		/**
		 * Fonction getNbGroupesFacturesInDB
		 * -------------------
		 * Retourne le nombre de groupe de factures en base de données.
		 *
		 * @return int
		 */
		public function getNbGroupesFacturesInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_groupes_factures FROM t_groupes_factures";
			$res = $this->FetchRow();
			return $res ["nb_groupes_factures"];
		}								

		/**
		 * Fonction getNbFacturesInGroupe
		 * -------------------
		 * Retourne le nombre de factures dans un groupe.
		 *
		 * @return int
		 */
		public function getNbFacturesInGroupe ( $id )
		{
			$this->Sql = "SELECT COUNT(*) AS nb_factures_synthese
							FROM t_historiques_factures AS hf
							WHERE hf.id_groupes_factures = $id";
			$res = $this->FetchRow();
			return $res ["nb_factures_synthese"];
		}

		/**
		 * Fonction getAllProduits
		 * -------------------
		 * Retourne les produits présents en base de données
		 *
		 * @return array
		 */
		public function getAllProduits ()
		{
			$this->Sql = "SELECT * FROM t_produits";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllProduitsWithAchats
		 * -------------------
		 * Retourne les produits présents et les quantité correspondantes en base de données
		 *
		 * @return array
		 */
		public function getAllProduitsWithAchats ()
		{
			$this->Sql = "SELECT p.idt_produits, p.nom_produit, p.stock_initial, p.stock_physique, p.prix_achat, p.prix_vente, SUM(a.quantite_achat) AS quantite_achat
							FROM t_produits AS p
							LEFT JOIN t_achats AS a ON p.idt_produits = a.id_produit
							GROUP BY p.idt_produits";
			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction getAutoCompleteProduits
		 * -------------------
		 * Retourne les produits présents en base de données
		 *
		 * @return array
		 */
		public function getAutoCompleteProduits ($produit)
		{
			$this->Sql = "SELECT * 
							FROM t_produits
							WHERE nom_produit like '%".$produit."%'
							ORDER BY nom_produit";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllFactures
		 * -------------------
		 * Retourne les factures présentes en base de données
		 *
		 * @return array
		 */
		public function getAllFactures ()
		{
			$this->Sql = "SELECT * 
							FROM t_factures AS fa
							JOIN t_fournisseurs AS fo ON fa.id_fournisseur = fo.idt_fournisseurs
							ORDER BY fa.idt_factures";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllRecapitulatif
		 * -------------------
		 * Retourne les recapituatifs d'inventaire présents en base de données
		 *
		 * @return array
		 */
		public function getAllRecapitulatif()
		{
			$this->Sql = "SELECT * 
							FROM t_recapitulatif AS r
							JOIN t_users AS u ON r.id_user = u.idt_users";
			$res = $this->FetchRow();
			return $res;
		}

		/**
		 * Fonction getSynthese
		 * -------------------
		 * Retourne la synthse de l'inventaire
		 *
		 * @return array
		 */
		public function getSynthese()
		{
			$this->Sql = "SELECT p.nom_produit, p.stock_initial, SUM(a.quantite_achat) AS achat, p.stock_physique, p.prix_vente, p.prix_achat
							FROM t_produits AS p
							LEFT JOIN t_achats AS a ON p.idt_produits = a.id_produit
							GROUP BY p.idt_produits
							ORDER BY p.nom_produit";
			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction getAllAchatsVentesMois
		 * -------------------
		 * Retourne le total des achats et ventes du mois present en base de données
		 *
		 * @return array
		 */
		public function getAllAchatsVentesMois()
		{
			$this->Sql = "SELECT p.nom_produit, p.idt_produits, p.stock_initial, SUM(a.quantite_achat) AS achat, p.stock_physique, p.prix_vente, p.prix_achat
							FROM t_produits AS p
							LEFT JOIN t_achats AS a ON p.idt_produits = a.id_produit
							GROUP BY p.idt_produits";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllProduitsAssocToFactures
		 * -------------------
		 * Retourne les produits d'une facture présents en base de données
		 *
		 * @return array
		 */
		public function getAllProduitsAssocToFactures ($id)
		{
			$this->Sql = "SELECT * 
							FROM t_achats AS a
							JOIN t_factures AS f ON a.id_facture = f.idt_factures
							JOIN t_produits AS p ON a.id_produit = p.idt_produits
							WHERE idt_factures = $id
							ORDER BY p.nom_produit";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllFournisseurs
		 * -------------------
		 * Retourne les fournisseurs présents en base de données
		 *
		 * @return array
		 */
		public function getAllFournisseurs ()
		{
			$this->Sql = "SELECT COUNT(fo.idt_fournisseurs) AS nb_factures, fo.idt_fournisseurs, fa.idt_factures, fo.nom_fournisseur, fo.adresse_fournisseur, fo.telephone_fournisseur, fo.date_insertion, MAX(fa.date_insertion_facture) AS date_insertion_facture
							FROM t_fournisseurs AS fo
							LEFT JOIN t_factures AS fa ON fo.idt_fournisseurs = fa.id_fournisseur
							GROUP BY fo.idt_fournisseurs";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllProduitsAchetes
		 * -------------------
		 * Retourne tous les produits achetés d'une facture
		 *
		 * @return array
		 */
		public function getAllProduitsAchetes ()
		{
			$this->Sql = "SELECT * FROM t_produits_factures";
			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction getInfosFactureEnCours
		 * -------------------
		 * Retourne les informations des produits presentements eregistrés sur une facture
		 *
		 * @return array
		 */
		public function getInfosFactureEnCours ()
		{
			$this->Sql = "SELECT * 
							FROM t_produits AS p
							JOIN t_produits_factures AS ef ON ef.id_produit = p.idt_produits";
			$res = $this->FetchAllRows();
			return $res;
		}	

		/**
		 * Fonction getInfosFacture
		 * -------------------
		 * Retourne les informations d'une facture
		 *
		 * @return array
		 */
		public function getInfosFacture ($id)
		{
			$this->Sql = "SELECT * 
							FROM t_factures AS fa
							JOIN t_fournisseurs AS fo ON fa.id_fournisseur = fo.idt_fournisseurs
							WHERE fa.idt_factures = $id";
			$res = $this->FetchAllRows();
			return $res;
		}			

		/**
		 * Fonction getInfoProduit
		 * -------------------
		 * Retourne les informations d'un produit en base de données.
		 *
		 * @return Array
		 */
		public function getInfoProduit ( $id )
		{
			$this->Sql = "SELECT * FROM t_produits WHERE idt_produits = $id";
			$res = $this->FetchRow();
			return $res;
		}

		/**
		 * Fonction getInfoFournisseur
		 * -------------------
		 * Retourne les informations d'un fournisseur en base de données.
		 *
		 * @return Array
		 */
		public function getInfoFournisseur ( $id )
		{
			$this->Sql = "SELECT * FROM t_fournisseurs WHERE idt_fournisseurs = $id";
			$res = $this->FetchRow();
			return $res;
		}

		/**
		 * Fonction getInfosProduitsAchetes
		 * -------------------
		 * Retourne les informations d'un produit connaissant sa designation.
		 *
		 * @return Array
		 */
		public function getInfosProduitsAchetes ( $id )
		{
			$this->Sql = "SELECT idt_produits, nom_produit 
							FROM t_produits 
							WHERE nom_produit = '$id'";
			$res = $this->FetchRow();
			return $res;
		}

		/**
		 * Fonction getInfosProduitsAchetesForEdit
		 * -------------------
		 * Retourne les informations d'un produit connaissant sa designation pour une modification.
		 *
		 * @return Array
		 */
		public function getInfosProduitsAchetesForEdit ( $id )
		{
			$this->Sql = "SELECT *
							FROM t_achats AS a 
							WHERE a.id_facture = '$id'";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getInfosProduitAchete
		 * -------------------
		 * Retourne les informations d'un produit parmi les produits d'une facture.
		 *
		 * @return Array
		 */
		public function getInfoProduitAchete ( $id )
		{
			$this->Sql = "SELECT *
							FROM `t_produits_factures` AS ef
							JOIN t_produits AS p ON ef.id_produit = p.idt_produits
							WHERE idt_produits_factures ='$id'";
			$res = $this->FetchRow();
			return $res;
		}

		/**
		 * Fonction getTableProduits
		 * -------------------
		 * Retourne tous les elements de la table t_produits
		 *
		 * @return array
		 */
		public function getTableProduits ()
		{
			$this->Sql = "SELECT * FROM t_produits";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getTableAchats
		 * -------------------
		 * Retourne tous les elements de la table t_achats
		 *
		 * @return array
		 */
		public function getTableAchats()
		{
			$this->Sql = "SELECT * FROM t_achats";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getTableFactures
		 * -------------------
		 * Retourne tous les elements de la table t_factures
		 *
		 * @return array
		 */
		public function getTableFactures()
		{
			$this->Sql = "SELECT * FROM t_factures";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getTableFournisseurs
		 * -------------------
		 * Retourne tous les elements de la table t_fournisseurs
		 *
		 * @return array
		 */
		public function getTableFournisseurs()
		{
			$this->Sql = "SELECT * FROM t_fournisseurs";
			$res = $this->FetchAllRows();
			return $res;
		}	

		/**
		 * Fonction getTableRecapitulatif
		 * -------------------
		 * Retourne tous les elements de la table recapitulatif
		 *
		 * @return array
		 */
		public function getTableRecapitulatif()
		{
			$this->Sql = "SELECT * FROM t_recapitulatif";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getTableTypesUsers
		 * -------------------
		 * Retourne tous les elements de la table t_types_users
		 *
		 * @return array
		 */
		public function getTableTypesUsers()
		{
			$this->Sql = "SELECT * FROM t_types_users";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getTableUsers
		 * -------------------
		 * Retourne tous les elements de la table t_users
		 *
		 * @return array
		 */
		public function getTableUsers()
		{
			$this->Sql = "SELECT * FROM t_users";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getHistoriqueSynthese
		 * -------------------
		 * Retourne l'historique des synthese
		 *
		 * @return array
		 */
		public function getHistoriqueSynthese()
		{
			$this->Sql = "SELECT * 
							FROM t_historiques_syntheses AS hs
							JOIN t_users AS u ON hs.id_user = u.idt_users
							ORDER BY hs.date_inventaire DESC";

			$res = $this->FetchAllRows();
			return $res;
		}	

		/**
		 * Fonction getHistoriqueSyntheseById
		 * -------------------
		 * Retourne l'historique des synthese par id
		 *
		 * @return array
		 */
		public function getHistoriqueSyntheseById( $id )
		{
			$this->Sql = "SELECT * 
							FROM t_historiques_syntheses AS hs
							JOIN t_users AS u ON hs.id_user = u.idt_users
							WHERE hs.idt_historiques_syntheses = $id";

			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction getHistoriqueSyntheseByDate
		 * -------------------
		 * Retourne l'historique des synthese
		 *
		 * @return array
		 */
		public function getHistoriqueSyntheseByDate($date_histo_synthese)
		{
			$this->Sql = "SELECT * 
							FROM t_historiques_syntheses AS hs
							JOIN t_users AS u ON hs.id_user = u.idt_users
							WHERE hs.date_inventaire >= '$date_histo_synthese'";

			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getHistoriquesFacturesByDate
		 * -------------------
		 * Retourne l'historique des synthese
		 *
		 * @return array
		 */
		public function getHistoriquesFacturesByDate( $date_histo_facture, $id_groupe )
		{
			if( $date_histo_facture != "" ){ 
				if ( $id_groupe != "" ) {
					$sql_where = "WHERE hf.id_groupes_factures = $id_groupe AND  hf.date_facture <= '$date_histo_facture'";
				}else{
					$sql_where = "WHERE hf.date_facture <= '$date_histo_facture'";
				}
			}else{
				if ( $id_groupe != "" ) {
					$sql_where = "WHERE hf.id_groupes_factures = $id_groupe";
				}else{
					$sql_where = "";
				}	
			}

			$this->Sql = "SELECT * 
							FROM t_historiques_factures AS hf
							JOIN t_fournisseurs AS f ON hf.id_fournisseur = f.idt_fournisseurs
							".$sql_where;

			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction getAllProduitsFacture
		 * -------------------
		 * Retourne les produits contenus dans une facture
		 *
		 * @return array
		 */
		public function getAllProduitsFacture()
		{
			$this->Sql = "SELECT * 
							FROM t_produits_factures AS pf
							JOIN t_produits AS p ON pf.id_produit = p.idt_produits
							ORDER BY pf.idt_produits_factures DESC";

			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getInfoProduitFacture
		 * -------------------
		 * Retourne les informations du produit de la facture
		 *
		 * @return array
		 */
		public function getInfoProduitFacture( $id )
		{
			$this->Sql = "SELECT * 
							FROM t_produits_factures AS pf
							JOIN t_produits AS p ON pf.id_produit = p.idt_produits
							WHERE pf.idt_produits_factures = $id";

			$res = $this->FetchRow();
			return $res;
		}

		/**
		 * Fonction getIdProduitByNom
		 * -------------------
		 * Retourne l'id du produit.
		 *
		 * @return Array
		 */
		public function getIdProduitByNom ( $id )
		{
			$this->Sql = "SELECT idt_produits FROM t_produits WHERE nom_produit = '$id'";
			$res = $this->FetchRow();
			return $res[0];
		}

		/**
		 * Fonction getPrixAchatProduitByNom
		 * -------------------
		 * Retourne le prix d'achat du produit.
		 *
		 * @return Array
		 */
		public function getPrixAchatProduitByNom ( $id )
		{
			$this->Sql = "SELECT prix_achat FROM t_produits WHERE nom_produit = '$id'";
			$res = $this->FetchRow();
			return $res[0];
		}

		/**
		 * Fonction getPrixTotalProduitsFacture
		 * -------------------
		 * Retourne somme prix d'achat total des produits dans une facture.
		 *
		 * @return Array
		 */
		public function getPrixTotalProduitsFacture()
		{
			$this->Sql = "SELECT SUM(prix_total_produits) AS prix_total_produits FROM t_produits_factures";
			$res = $this->FetchRow();
			return $res[0];
		}		

		/**
		 * Fonction getInfosProduitByNom
		 * -------------------
		 * Retourne l'id, prix d'achat du produit.
		 *
		 * @return Array
		 */
		public function getInfosProduitByNom ( $id )
		{
			$this->Sql = "SELECT * FROM t_produits WHERE nom_produit = '$id'";
			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction getNbProduitsInFacture
		 * -------------------
		 * Retourne le nombre de produits dans la facture.
		 *
		 * @return int
		 */
		public function getNbProduitsInFacture ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_produits FROM t_produits_factures";
			$res = $this->FetchRow();
			return $res ["nb_produits"];
		}

		/**
		 * Fonction getProduitsByFacture
		 * -------------------
		 * Retourne les produits d'une facture
		 *
		 * @return array
		 */
		public function getProduitsByFacture ( $id )
		{
			$this->Sql = "SELECT *
							FROM t_achats AS a
							JOIN t_produits AS p ON a.id_produit = p.idt_produits
							WHERE a.id_facture = $id";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getLastInsertedIdInHistoriquesSyntheses
		 * -------------------
		 * Retourne le dernier id de la table t_historiques_syntheses.
		 *
		 * @return int
		 */
		public function getLastInsertedIdInHistoriquesSyntheses ()
		{
			$this->Sql = "SELECT MAX( idt_historiques_syntheses ) AS id FROM t_historiques_syntheses";
			$res = $this->FetchRow();
			return $res ["id"];
		}

		/**
		 * Fonction getLastInsertedIdInGroupesFactures
		 * -------------------
		 * Retourne le dernier id de la table t_groupes_factures.
		 *
		 * @return int
		 */
		public function getLastInsertedIdInGroupesFactures ()
		{
			$this->Sql = "SELECT MAX( idt_groupes_factures ) AS id FROM t_groupes_factures";
			$res = $this->FetchRow();
			return $res ["id"];
		}


		/**
		 * Fonction getLastInsertedIdInHistoriquesFactures
		 * -------------------
		 * Retourne le dernier id de la table t_historiques_factures.
		 *
		 * @return int
		 */
		public function getLastInsertedIdInHistoriquesFactures ()
		{
			$this->Sql = "SELECT MAX( idt_historiques_factures ) AS id FROM t_historiques_factures";
			$res = $this->FetchRow();
			return $res ["id"];
		}

		/**
		 * Fonction getAllNumberUsersByTypesUSers
		 * -------------------
		 * Retourne le nombre d'users par types de comptes
		 *
		 * @return array
		 */
		public function getAllNumberUsersByTypesUSers()
		{
			$this->Sql = "SELECT tu.nom_type_user, u.idt_users, COUNT(tu.idt_types_users) AS nb
							FROM t_types_users AS tu
							LEFT JOIN t_users AS u ON tu.idt_types_users = u.id_type_user
							WHERE tu.idt_types_users > 2
							GROUP BY tu.idt_types_users";

			$res = $this->FetchAllRows();
			return $res;
		}	

		/**
		 * Fonction getAllNumberConnectionsByUSers
		 * -------------------
		 * Retourne les infos de tous les users
		 *
		 * @return array
		 */
		public function getAllNumberConnectionsByUSers()
		{
			$this->Sql = "SELECT *
							FROM t_users";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllNumberFacturesFournisseur
		 * -------------------
		 * Retourne les infos de tous les factures et fournisseurs
		 *
		 * @return array
		 */
		public function getAllNumberFacturesFournisseur()
		{
			$this->Sql = "SELECT COUNT(fa.idt_historiques_factures) AS nb_factures , fa.date_facture, fo.nom_fournisseur
							FROM t_fournisseurs AS fo
							LEFT JOIN t_historiques_factures AS fa ON fa.id_fournisseur = fo.idt_fournisseurs
							GROUP BY fo.idt_fournisseurs";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllNumberFacturesFournisseurCurrent
		 * -------------------
		 * Retourne les infos de tous les factures courantes et fournisseurs
		 *
		 * @return array
		 */
		public function getAllNumberFacturesFournisseurCurrent()
		{
			$this->Sql = "SELECT COUNT(fa.idt_factures) AS nb_factures , fa.date_facture, fo.nom_fournisseur
							FROM t_fournisseurs AS fo
							LEFT JOIN t_factures AS fa ON fa.id_fournisseur = fo.idt_fournisseurs
							GROUP BY fo.idt_fournisseurs";
			$res = $this->FetchAllRows();
			return $res;
		}		

		/**
		 * Fonction getAllHistoriquesSyntheses
		 * -------------------
		 * Retourne les infos de l'historiques de syntheses
		 *
		 * @return array
		 */
		public function getAllHistoriquesSyntheses()
		{
			$this->Sql = "SELECT *
							FROM t_historiques_syntheses
							ORDER BY date_inventaire
							LIMIT 0, 6";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllProduitsWithDatePeremption
		 * -------------------
		 * Retourne les produits et date de peremption
		 *
		 * @return array
		 */
		public function getAllProduitsWithDatePeremption ( $date_peremption )
		{
			if( $date_peremption != "" ) 
				$sql_where = "WHERE a.date_peremption <= '$date_peremption'";
			else
				$sql_where = "";

			$this->Sql = "SELECT *
							FROM t_produits AS p
							JOIN t_achats AS a ON p.idt_produits = a.id_produit
							JOIN t_factures AS fa ON a.id_facture = fa.idt_factures
							JOIN t_fournisseurs AS fo ON fa.id_fournisseur = fo.idt_fournisseurs
							".$sql_where;

			$res = $this->FetchAllRows();
			return $res;
		}
//*/
		/**
		 * Fonction getProduitWithAchat
		 * -------------------
		 * Retourne les produits et les achats de ce produit en base de données
		 *
		 * @return array
		 */
		public function getProduitWithAchat ( $id )
		{
			$this->Sql = "SELECT p.idt_produits, p.nom_produit, p.stock_initial, p.stock_physique, SUM(a.quantite_achat) AS quantite_achat, p.prix_achat, p.prix_vente
							FROM t_produits AS p
							LEFT JOIN t_achats AS a ON p.idt_produits = a.id_produit
							WHERE p.idt_produits = $id
							GROUP BY p.idt_produits";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllComptesUtilisateursCaissier
		 * -------------------
		 * Retourne les comptes utilisateurs caissier présents en base de données
		 *
		 * @return int
		 */
		public function getAllComptesUtilisateursCaissier ()
		{
			$this->Sql = "SELECT * 
							FROM t_users u 
							JOIN t_types_users tu ON u.id_type_user = tu.idt_types_users
							WHERE tu.idt_types_users = 5";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllAchatsByFacture
		 * -------------------
		 * Retourne tous les achats d'une facture en base de données
		 *
		 * @return array
		 */
		public function getAllAchatsByFacture ( $id )
		{
			$this->Sql = "SELECT *
							FROM t_achats AS a
							WHERE a.id_facture = $id";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getHistoriquesFactures
		 * -------------------
		 * Retourne l'historique des factures
		 *
		 * @return array
		 */
		public function getHistoriquesFactures()
		{
			$this->Sql = "SELECT * 
							FROM t_historiques_factures AS hf
							JOIN t_fournisseurs AS f ON hf.id_fournisseur = f.idt_fournisseurs";
			$res = $this->FetchAllRows();
			return $res;
		}
		/**
		 * Fonction getAllHistoriquesAchatsByFacture
		 * -------------------
		 * Retourne tous les historiques des achats d'une facture en base de données
		 *
		 * @return array
		 */
		public function getAllHistoriquesAchatsByFacture ( $id )
		{
			$this->Sql = "SELECT *
							FROM t_historiques_achats AS ha 
							JOIN t_produits AS p ON ha.id_produit = p.idt_produits
							WHERE ha.id_facture = $id";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllquantiteProduitsAchetesByPeriode
		 * -------------------
		 * Retourne les quantités de produits achetés
		 *
		 * @return array
		 */
		public function getAllquantiteProduitsAchetesByPeriode( $date_debut, $date_fin )
		{			
			$this->Sql = "SELECT SUM(ha.quantite_achat) AS quantite_achat
							FROM t_historiques_achats AS ha
							JOIN t_historiques_factures AS hf ON ha.id_facture = hf.idt_historiques_factures
							WHERE hf.date_facture >= '$date_fin' AND hf.date_facture <='$date_debut'";

			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllHistoriqueQuantiteProduitsByPeriode
		 * -------------------
		 * Retourne les quantités de produits vendus
		 *
		 * @return array
		 */
		public function getAllHistoriqueQuantiteProduitsByPeriode( $date_debut, $date_fin )
		{			
			$this->Sql = "SELECT SUM(ha.quantite_achat) AS quantite_achat, SUM(p.stock_initial) AS stock_initial, SUM(p.stock_physique) AS stock_physique
							FROM t_historiques_achats AS ha
							JOIN t_historiques_factures AS hf ON ha.id_facture = hf.idt_historiques_factures
							JOIN t_produits AS p ON ha.id_produit = p.idt_produits
							WHERE hf.date_facture >= '$date_fin' AND hf.date_facture <= '$date_debut'";

			$res = $this->FetchRow();
			return $res;
		}

		/**
		 * Fonction getAllCurrentQuantiteProduitsByPeriode
		 * -------------------
		 * Retourne les quantités de produits vendus
		 *
		 * @return array
		 */
		public function getAllCurrentQuantiteProduitsByPeriode( $date_debut, $date_fin )
		{			
			$this->Sql = "SELECT SUM(ha.quantite_achat) AS quantite_achat, SUM(p.stock_initial) AS stock_initial, SUM(p.stock_physique) AS stock_physique
							FROM t_achats AS ha
							JOIN t_factures AS hf ON ha.id_facture = hf.idt_factures
							JOIN t_produits AS p ON ha.id_produit = p.idt_produits
							WHERE hf.date_facture >= '$date_fin' AND hf.date_facture <= '$date_debut'";

			$res = $this->FetchRow();
			return $res;
		}	

		/**
		 * Fonction getHistoriquesFactures
		 * -------------------
		 * Retourne les groupes de factures
		 *
		 * @return array
		 */
		public function getGroupesFactures()
		{
			$this->Sql = "SELECT * 
							FROM t_groupes_factures";
			$res = $this->FetchAllRows();
			return $res;
		}																																										
	}
?>