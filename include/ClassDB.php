<?php
	/**********************************************************************
	*
	* Auteur 				: Cyrille MOFFO (developpement@nemand-soft.com)
	* Date de cr�ation 		: 07/12/2013
	* Version 				: 1.0
	*
	***********************************************************************
	* Classe g�rant les acc�s � la base de donn�es et les requ�tes.
	*
	* Gestion des FetchRow et FetchRows.
	* Les logs stockent les requ�tes en erreur.
	*
	* Database
	* ********
	*	- Connection.
	*	- Logs trac�es.
	*	- Synth�se g�n�ralis�e.
	* 
	**********************************************************************/

    @session_start();

	define ("CRLF", "<br />");
	define ("CLASS_DB", "1");
	header ("Content-type: text/html; character=UTF-8");
	
	class Database extends PDO
	{
		// Ann�e par d�faut pour les filtres.
		protected $Annee;
		
		// Mois par d�faut pour les filtres.
		protected $Mois;
		
		// Requ�te SQL.
		protected $Sql;
		
		// Pointeur vers la base de donn�es centrale. Celle qui sera install�e en local sur le serveur central.
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

			 $hostname = DB_HOST;
			 $dbname = DB_NAME;
			 $username = DB_USER;
			 $password = DB_PASSWORD;
			 try
			 {
			 	$connectionString = "mysql:host=".$hostname.";dbname=".$dbname;
				
			 	parent::__construct(
			 		$connectionString,
			 		$username,
			 		$password
			 	);
			 }
			 catch (PDOException $dbex)
			 {
			 	echo "({'connected': 'false', 'message': 'Impossible de vous connecter � la base de donn�es de Nkedon.'})";
			 }

//			$this->Connection = array ();
//			$this->Sql = "";
//
//			try
//			{
//				$connectionString = "mysql:host=".Configuration::getValue('common_host').";dbname=".Configuration::getValue('common_dbname');
//
//				parent::__construct(
//					$connectionString,
//					Configuration::getValue('common_user'),
//					Configuration::getValue('common_password')
//				);
//			}
//			catch (PDOException $dbex) {
//				echo 'Impossible de vous connecter � la base de donn�es centrale du BackOffice.';
//				throw_error($dbex);
//			}
		}

		/**
		 * Fonction fixEncoding
		 * --------------------
		 * Cette fonction r�soud l'encodage UTF-8 en ISO pour g�rer correctement les accents.
		 *
		 * @param string $in_str
		 * @return string
		 */
		public function fixEncoding ($in_str)
		{
			$cur_encoding = mb_detect_encoding ($in_str) ;
			
			$buffer = mb_convert_encoding($in_str, 'ISO-8859-1',
						  mb_detect_encoding($in_str, 'UTF-8, ISO-8859-1', true)); 
						  
			// En m�me temps, �a gagne un temps pr�cieux.
			$buffer = utf8_encode ($buffer);
			return $buffer;
		}
		
		/**
		 * Fonction fixEncodingArray
		 * -------------------------
		 * Cette fonction r�soud l'encodage UTF-8 en ISO pour g�rer correctement les accents.
		 * Elle est r�cursive, attention.
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
		 * R�cup�ration d'une ligne dans la base de donn�es avec this->Sql d�j� initialis�.
		 * Le mode PDO est en option et par d�faut, il retourne tout le tableau.
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
		 * R�cup�ration de toutes les informations disponibles dans le tableau.
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
		 * ATTENTION, uniquement des requ�tes INSERT, UPDATE ou DELETE ici.
		 * 
		 * Si aucune donn&eacute;e n'a &eacute;t&eacute; &eacute;crite, si la requ�te n'est pas bonne, on sort False.  
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
					Requ�te SQL ex&eacute;cut&eacute;e : <b>".$this->Sql."</b><br />
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
		 * Cette fonction effectue le test en base de donn�es par rapport au login et au
		 * mot de passe envoy�s en param�tre.
		 *
		 * @param string $login.
		 * @param string $password  Il est envoy� d�j� crypt�.
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
		 * On envoie les informations de tous les utilisateurs en base de donn�es.
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
		 * Retourne l'id user de t_users depuis le login de la personne connect�
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
		 * Retourne le nombre de compte utilisateurs enregistr�s dans la base de donn�es.
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
		 * Retourne les comptes utilisateurs pr�sents en base de donn�es
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
		 * Retourne les comptes utilisateurs pr�sents en base de donn�es
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
		 * Retourne les types de comptes utilisateurs pr�sent en base de donn�es
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
		 * Retourne les types d'utilisateurs en base de donn�es qui ne sont pas "Administrateur" ou "Super Administrateur".
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
		 * Retourne le nombre de type de profils utilisateurs pr�sents en base de donn�es.
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
			$this->Sql = "SELECT COUNT(*) AS nb_produits FROM t_produits_achats";
			$res = $this->FetchRow();
			return $res ["nb_produits"];
		}

        /**
         * Fonction getNbOperationsJournal
         * -------------------
         * Retourne le nombre d'operation d'un journal.
         *
         * @return int
         */
        public function getNbOperationsJournal ()
        {
            $this->Sql = "SELECT COUNT(*) AS nb_operations FROM t_produits_operations";
            $res = $this->FetchRow();
            return $res ["nb_operations"];
        }

		/**
		 * Fonction getMaxIdInventaire
		 * -------------------
		 * Retourne le dernier recapitulatif d'inventaire.
		 *
		 * @return int
		 */
		public function getMaxIdInventaire ()
		{
			$this->Sql = "SELECT MAX(idt_inventaires) AS id_inventaire FROM t_inventaires";
			$res = $this->FetchRow();
			return $res ["id_inventaire"];
		}

        /**
         * Fonction getMaxIdJournal
         * -------------------
         * Retourne le dernier journal enregistré
         *
         * @return int
         */
        public function getMaxIdJournal ()
        {
            $this->Sql = "SELECT MAX(idt_journal) AS id_journal FROM t_journal";
            $res = $this->FetchRow();
            return $res ["id_journal"];
        }

        /**
         * Fonction getMaxIdFactureAchat
         * -------------------
         * Retourne la derniere facture c'achat enregistrée
         *
         * @return int
         */
        public function getMaxIdFactureAchat ()
        {
            $this->Sql = "SELECT MAX(idt_factures_achats) AS id_facture FROM t_factures_achats";
            $res = $this->FetchRow();
            return $res ["id_facture"];
        }

        /**
         * Fonction getMaxIdFactureVente
         * -------------------
         * Retourne la derniere facture ce vente enregistrée
         *
         * @return int
         */
        public function getMaxIdFactureVente ()
        {
            $this->Sql = "SELECT MAX(idt_factures_ventes) AS id_facture FROM t_factures_ventes";
            $res = $this->FetchRow();
            return $res ["id_facture"];
        }

        /**
		 * Fonction getInfoTypeUser
		 * -------------------
		 * Retourne les types d'utilisateurs en base de donn�es qui ne sont pas "Administrateur" ou "Super Administrateur".
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
		 * Retourne le nombre de type de produits pr�sents en base de donn�es.
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
		 * Retourne le nombre de type de fournisseurs pr�sents en base de donn�es.
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
         * Fonction getNbOperationsInDB
         * -------------------
         * Retourne le nombre de type d'operations pr�sents en base de donn�es.
         *
         * @return int
         */
        public function getNbOperationsInDB ()
        {
            $this->Sql = "SELECT COUNT(*) AS nb_operations FROM t_produits_operations";
            $res = $this->FetchRow();
            return $res ["nb_operations"];
        }

		/**
		 * Fonction getNbFacturesInDB
		 * -------------------
		 * Retourne le nombre de type de fournisseurs pr�sents en base de donn�es.
		 *
		 * @return int
		 */
		public function getNbFacturesInDB ()
		{
			$this->Sql = "SELECT COUNT(*) AS nb_factures FROM t_factures_achats";
			$res = $this->FetchRow();
			return $res ["nb_factures"];
		}

		/**
		 * Fonction getAllProduits
		 * -------------------
		 * Retourne les produits pr�sents en base de donn�es
		 *
		 * @return array
		 */
		public function getAllProduits ()
		{
			$this->Sql = "SELECT * FROM t_produits ORDER BY nom_produit";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllProduitsAchetesNonInventories
		 * -------------------
		 * Retourne les produits achetés et non deja inventaorés
		 *
		 * @return array
		 */
		public function getAllProduitsAchetesNonInventories ()
		{
			$this->Sql = "SELECT *, SUM(quantite_achat) AS quantite_achetee
                            FROM t_achats AS a
                            JOIN t_factures_achats AS f
                            ON a.id_facture = f.idt_factures_achats
                            WHERE f.id_inventaire = 0
                            GROUP BY a.id_produit";
			$res = $this->FetchAllRows();
			return $res;
		}

        /**
         * Fonction getProduitAcheteNonInventorie
         * -------------------
         * Retourne le produit acheté et non deja inventorié
         *
         * @return array
         */
        public function getInfosProduitAcheteByInventaire ( $id_produits, $id_inventaire )
        {
            $this->Sql = "SELECT *, SUM(quantite_achat) AS quantite_achetee
                            FROM t_achats AS a
                            JOIN t_factures_achats AS f
                            ON a.id_facture = f.idt_factures_achats
                            WHERE f.id_inventaire = $id_inventaire AND a.id_produit = $id_produits
                            GROUP BY a.id_produit";
            $res = $this->FetchRow();
            return $res;
        }

        /**
         * Fonction getProduitVenduNonInventorie
         * -------------------
         * Retourne le produit vendu et non deja inventorié
         *
         * @return array
         */
        public function getInfosProduitVenduByInventaire ( $id_produit, $id_inventaire )
        {
            $this->Sql = "SELECT *, SUM(v.quantite_vendue) AS quantite_vente
                            FROM t_ventes AS v
                            JOIN t_factures_ventes AS fv
                            ON v.id_facture_vente = fv.idt_factures_ventes
                            WHERE fv.id_inventaire = $id_inventaire AND v.id_produit = $id_produit
                            GROUP BY v.id_produit";
            $res = $this->FetchRow();
            return $res;
        }

        /**
         * Fonction getAllProduitsVendusNonInventories
         * -------------------
         * Retourne les produits vendus et non deja inventoriés
         *
         * @return array
         */
        public function getAllProduitsVendusNonInventories ( )
        {
            $this->Sql = "SELECT *, SUM(v.quantite_vendue) AS quantite_vente
                            FROM t_ventes AS v
                            JOIN t_factures_ventes AS fv
                            ON v.id_facture_vente = fv.idt_factures_ventes
                            WHERE fv.id_inventaire = 0
                            GROUP BY v.id_produit";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsFacturesVentesByInventaire
         * -------------------
         * Retourne les produits des facture de ventes par inventaire
         *
         * @return array
         */
        public function getAllProduitsFacturesVentesByInventaire ( $id )
        {
            $this->Sql = "SELECT *, SUM(v.quantite_vendue) AS quantite_vendue
                            FROM t_ventes AS v
                            JOIN t_factures_ventes AS fv ON v.id_facture_vente = fv.idt_factures_ventes
                            JOIN t_produits AS p ON v.id_produit = p.idt_produits
                            WHERE fv.id_inventaire = $id
                            GROUP BY v.id_produit
                            ORDER BY fv.date_facture";
            $res = $this->FetchAllRows();
            return $res;
        }
        /**
         * Fonction getAllProduitsVendusByInventaire
         * -------------------
         * Retourne les produits vendus par inventaire
         *
         * @return array
         */
        public function getAllProduitsVendusByInventaire ( $id )
        {
            $this->Sql = "SELECT *, SUM(o.quantite_vendue) AS quantite_vendue
                            FROM t_journal AS j
                            JOIN t_operations AS o ON j.idt_journal = o.id_journal
                            JOIN t_produits AS p ON o.id_produit = p.idt_produits
                            WHERE j.id_inventaire = $id
                            GROUP BY p.idt_produits
                            ORDER BY j.date_journal";
            $res = $this->FetchAllRows();
            return $res;
        }


        /**
         * Fonction getAllProduitsAchetesByInventaire
         * -------------------
         * Retourne les produits achetes par inventaire
         *
         * @return array
         */
        public function getAllProduitsAchetesByInventaire ( $id )
        {
            $this->Sql = "SELECT *, SUM(a.quantite_achat) AS quantite_achetee
                            FROM t_factures_achats AS f
                            JOIN t_achats AS a ON f.idt_factures_achats = a.id_facture
                            JOIN t_produits AS p ON a.id_produit = p.idt_produits
                            WHERE f.id_inventaire = $id
                            GROUP BY p.idt_produits
                            ORDER BY f.date_facture";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsAchetesLastYear
         * -------------------
         * Retourne les produits achetes pendant les 12 derniers mois
         *
         * @return array
         */
        public function getAllProduitsAchetesLastYear ( )
        {
            $date_debut = getLocalTimeOneYearAgo();
            $date_fin = setLocalTime();

            $sql_where = " WHERE f.date_insertion_facture BETWEEN '$date_debut' AND '$date_fin' ";

            $this->Sql = "SELECT *, SUM(a.quantite_achat) AS quantite_achetee
                            FROM t_factures_achats AS f
                            JOIN t_achats AS a ON f.idt_factures_achats = a.id_facture
                            JOIN t_produits AS p ON a.id_produit = p.idt_produits
                            ".$sql_where."
                            GROUP BY p.idt_produits
                            ORDER BY f.date_facture";

            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsVenudusLastYear
         * -------------------
         * Retourne les produits vendus pendant les 12 derniers mois
         *
         * @return array
         */
        public function getAllProduitsVenudusLastYear ( )
        {
            $date_debut = getLocalTimeOneYearAgo();
            $date_fin = setLocalTime();

            $sql_where = " WHERE fv.date_facture BETWEEN '$date_debut' AND '$date_fin' ";

            $this->Sql = "SELECT *, SUM(v.quantite_vendue) AS quantite_vendue
                            FROM t_factures_ventes AS fv
                            JOIN t_ventes AS v ON fv.idt_factures_ventes = v.id_facture_vente
                            JOIN t_produits AS p ON v.id_produit = p.idt_produits
                            ".$sql_where."
                            GROUP BY p.idt_produits
                            ORDER BY fv.date_facture";

            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsOperationsJournalLastYear
         * -------------------
         * Retourne les produits vendus a partir du journal pendant les 12 derniers mois
         *
         * @return array
         */
        public function getAllProduitsOperationsJournalLastYear ( )
        {
            $date_debut = getLocalTimeOneYearAgo();
            $date_fin = setLocalTime();

            $sql_where = " WHERE j.date_journal BETWEEN '$date_debut' AND '$date_fin' ";

            $this->Sql = "SELECT *, SUM(o.quantite_vendue) AS quantite_vendue
                            FROM t_journal AS j
                            JOIN t_operations AS o ON j.idt_journal = o.id_journal
                            JOIN t_produits AS p ON o.id_produit = p.idt_produits
                            ".$sql_where."
                            GROUP BY p.idt_produits
                            ORDER BY j.date_journal";

            $res = $this->FetchAllRows();
            return $res;
        }

		/**
		 * Fonction getAutoCompleteProduits
		 * -------------------
		 * Retourne les produits pr�sents en base de donn�es
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
		 * Retourne les factures pr�sentes en base de donn�es
		 *
		 * @return array
		 */
		public function getAllFactures ()
		{
			$this->Sql = "SELECT * 
							FROM t_factures_achats AS fa
							JOIN t_fournisseurs AS fo ON fa.id_fournisseur = fo.idt_fournisseurs
							ORDER BY fa.idt_factures_achats";
			$res = $this->FetchAllRows();
			return $res;
		}

        /**
         * Fonction getAllFacturesAchatsByDate
         * -------------------
         * Retourne les factures en fonction de la date
         * remplacer les arguments manquants par ""
         * exemple : getAllFacturesAchatsByDate("","",2015) retourne les factures a partir de 2015
         *
         * @return array
         */
        public function getAllFacturesAchatsByDate ($jour, $mois, $annee )
        {
            if( $annee != "" ) {
                $date_fin = $annee."-12-31";
                if( $mois != "" ){
                    if( $jour != "" ){
                        $date_debut = $annee."-".$mois."-".$jour;
                    }else{
                        $date_debut = $annee."-".$mois."-01";
                    }
                }else{
                    $date_debut = $annee."-01-01";
                }

            //    $sql_where = "WHERE fa.date_facture >= '$date_debut'";
                $sql_where = "WHERE fa.date_facture BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }

            $this->Sql = "SELECT *
							FROM t_factures_achats AS fa
							JOIN t_fournisseurs AS fo ON fa.id_fournisseur = fo.idt_fournisseurs
							".$sql_where."
							ORDER BY fa.idt_factures_achats";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllJournalByDate
         * -------------------
         * Retourne les factures en fonction de la date
         * remplacer les arguments manquants par ""
         * exemple : getAllJournalByDate("","",2015) retourne les factures a partir de 2015
         *
         * @return array
         */
        public function getAllJournalByDate ($jour, $mois, $annee )
        {
            if( $annee != "" ) {
                $date_fin = $annee."-12-31";
                if( $mois != "" ){
                    if( $jour != "" ){
                        $date_debut = $annee."-".$mois."-".$jour;
                    }else{
                        $date_debut = $annee."-".$mois."-01";
                    }
                }else{
                    $date_debut = $annee."-01-01";
                }

                $sql_where = "WHERE j.date_journal BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }

            $this->Sql = "SELECT *
							FROM t_journal AS j
							".$sql_where."
							ORDER BY j.idt_journal";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllFacturesVentesByDate
         * -------------------
         * Retourne les factures en fonction de la date
         * remplacer les arguments manquants par ""
         * exemple : getAllFacturesVentesByDate("","",2015) retourne les factures a partir de 2015
         *
         * @return array
         */
        public function getAllFacturesVentesByDate ($jour, $mois, $annee )
        {
            if( $annee != "" ) {
                $date_fin = $annee."-12-31";
                if( $mois != "" ){
                    if( $jour != "" ){
                        $date_debut = $annee."-".$mois."-".$jour;
                    }else{
                        $date_debut = $annee."-".$mois."-01";
                    }
                }else{
                    $date_debut = $annee."-01-01";
                }

                //    $sql_where = "WHERE fa.date_facture >= '$date_debut'";
                $sql_where = "WHERE fv.date_facture BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }

            $this->Sql = "SELECT *
							FROM t_factures_ventes AS fv
							".$sql_where."
							ORDER BY fv.idt_factures_ventes";
            $res = $this->FetchAllRows();
            return $res;
        }
        /**
         * Fonction getAllFacturesVentes
         * -------------------
         * Retourne les factures de ventes présentes en base de donn�es
         *
         * @return array
         */
        public function getAllFacturesVentes ()
        {
            $this->Sql = "SELECT *
							FROM t_factures_ventes AS fv
							ORDER BY fv.idt_factures_ventes";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllFacturesByAnnee
         * -------------------
         * Retourne les factures pr�sentes en base de donn�es pour une annee donnée
         *
         * @return array
         */
        public function getAllFacturesByAnnee ($annee)
        {
            if( $annee != "" ) {
                $date_debut = $annee."-01-01";
                $date_fin = $annee."-12-31";
                $sql_where = "WHERE date_facture BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT *
							FROM t_factures_achats AS fa
							".$sql_where."
							ORDER BY fa.idt_factures_achats";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllFacturesVentesByAnnee
         * -------------------
         * Retourne les factures de ventes presentes en base de données pour une annee donnée
         *
         * @return array
         */
        public function getAllFacturesVentesByAnnee ($annee)
        {
            if( $annee != "" ) {
                $date_debut = $annee."-01-01 00:00:00";
                $date_fin = $annee."-12-31 23:59:59";
                $sql_where = "WHERE fv.date_facture BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT *
							FROM t_factures_ventes AS fv
							".$sql_where."
							ORDER BY fv.idt_factures_ventes";
            $res = $this->FetchAllRows();
            return $res;
        }

		/**
		 * Fonction getRecapitulatifInventaire
		 * -------------------
		 * Retourne le recapituatif d'inventaire présents en base de données
		 *
		 * @return array
		 */
		public function getRecapitulatifInventaire( $id )
		{
			$this->Sql = "SELECT * 
							FROM t_inventaires AS i
							JOIN t_users AS u ON i.id_user = u.idt_users
							WHERE idt_inventaires = $id";
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
		 * Fonction getAllAchatsInventaire
		 * -------------------
		 * Retourne le total des achats presents d'un inventaire en base de donn�es
		 *
		 * @return array
		 */
		public function getAllAchatsInventaire( $id )
		{
			$this->Sql = "SELECT *, SUM(a.quantite_achat) AS quantite_achetee
							FROM t_produits AS p
							LEFT JOIN t_achats AS a ON p.idt_produits = a.id_produit
							JOIN t_factures_achats AS f ON a.id_facture = f.idt_factures_achats
							WHERE f.id_inventaire = $id
							GROUP BY p.idt_produits";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllProduitsAssocToFactures
		 * -------------------
		 * Retourne les produits d'une facture pr�sents en base de donn�es
		 *
		 * @return array
		 */
		public function getAllProduitsAssocToFactures ($id)
		{
			$this->Sql = "SELECT * 
							FROM t_achats AS a
							JOIN t_factures_achats AS f ON a.id_facture = f.idt_factures_achats
							JOIN t_produits AS p ON a.id_produit = p.idt_produits
							WHERE idt_factures_achats = $id
							ORDER BY p.nom_produit";
			$res = $this->FetchAllRows();
			return $res;
		}

        /**
         * Fonction getAllProduitsAssocToFactures
         * -------------------
         * Retourne les produits d'une facture d'achat pr�sents en base de donn�es
         *
         * @return array
         */
        public function getAllProduitsAchetesByFacture ($id)
        {
            $this->Sql = "SELECT *
							FROM t_achats AS a
							JOIN t_factures_achats AS f ON a.id_facture = f.idt_factures_achats
							JOIN t_produits AS p ON a.id_produit = p.idt_produits
							WHERE f.idt_factures_achats = $id
							ORDER BY a.idt_achats";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsVendusByFacture
         * -------------------
         * Retourne les produits d'une facture de vente présents en base de données
         *
         * @return array
         */
        public function getAllProduitsVendusByFacture ($id)
        {
            $this->Sql = "SELECT *
							FROM t_ventes AS v
							JOIN t_factures_ventes AS fv ON v.id_facture_vente = fv.idt_factures_ventes
							JOIN t_produits AS p ON v.id_produit = p.idt_produits
							WHERE fv.idt_factures_ventes = $id
							ORDER BY v.idt_ventes";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsOperationsByJournal
         * -------------------
         * Retourne les produits d'un journal donné
         *
         * @return array
         */
        public function getAllProduitsOperationsByJournal ($id)
        {
            $this->Sql = "SELECT *
							FROM t_operations AS o
							JOIN t_journal AS j ON o.id_journal = j.idt_journal
							JOIN t_produits AS p ON o.id_produit = p.idt_produits
							WHERE j.idt_journal = $id
							ORDER BY o.idt_operations";
            $res = $this->FetchAllRows();
            return $res;
        }
		/**
		 * Fonction getAllFournisseurs
		 * -------------------
		 * Retourne les fournisseurs pr�sents en base de donn�es
		 *
		 * @return array
		 */
		public function getAllFournisseurs ()
		{
			$this->Sql = "SELECT COUNT(fo.idt_fournisseurs) AS nb_factures, fo.idt_fournisseurs, fa.idt_factures_achats, fo.nom_fournisseur, fo.adresse_fournisseur, fo.telephone_fournisseur, fo.date_insertion, MAX(fa.date_insertion_facture) AS date_insertion_facture
							FROM t_fournisseurs AS fo
							LEFT JOIN t_factures_achats AS fa ON fo.idt_fournisseurs = fa.id_fournisseur
							GROUP BY fo.idt_fournisseurs";
			$res = $this->FetchAllRows();
			return $res;
		}

		/**
		 * Fonction getAllProduitsAchetes
		 * -------------------
		 * Retourne tous les produits achet�s d'une facture
		 *
		 * @return array
		 */
		public function getAllProduitsAchetes ()
		{
			$this->Sql = "SELECT * FROM t_produits_achats";
			$res = $this->FetchAllRows();
			return $res;
		}

        /**
         * Fonction getAllProduitsVendus
         * -------------------
         * Retourne tous les produits vendus d'une facture
         *
         * @return array
         */
        public function getAllProduitsVendus ()
        {
            $this->Sql = "SELECT * FROM t_produits_ventes";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllOperationsJournal
         * -------------------
         * Retourne tous les operations du journal
         *
         * @return array
         */
        public function getAllOperationsJournal ()
        {
            $this->Sql = "SELECT * FROM t_produits_operations";
            $res = $this->FetchAllRows();
            return $res;
        }

		/**
		 * Fonction getInfosFactureEnCours
		 * -------------------
		 * Retourne les informations des produits presentements eregistr�s sur une facture
		 *
		 * @return array
		 */
		public function getInfosFactureEnCours ()
		{
			$this->Sql = "SELECT * 
							FROM t_produits AS p
							JOIN t_produits_achats AS ef ON ef.id_produit = p.idt_produits";
			$res = $this->FetchAllRows();
			return $res;
		}	

//		/**
//		 * Fonction getInfosFactureAchatById
//		 * -------------------
//		 * Retourne les informations d'une facture
//		 *
//		 * @return array
//		 */
//		public function getInfosFactureAchatById ($id)
//		{
//			$this->Sql = "SELECT *
//							FROM t_factures_achats AS fa
//							JOIN t_fournisseurs AS fo ON fa.id_fournisseur = fo.idt_fournisseurs
//							JOIN t_users AS u ON fa.id_user = u.idt_users
//							WHERE fa.idt_factures_achats = $id";
//			$res = $this->FetchAllRows();
//			return $res;
//		}

		/**
		 * Fonction getInfoProduit
		 * -------------------
		 * Retourne les informations d'un produit en base de donn�es.
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
         * Fonction getInfoProduitByNom
         * -------------------
         * Retourne les informations d'un produit en base de donn�es connaissant le nom du produit.
         *
         * @return Array
         */
        public function getInfoProduitByNom ( $id )
        {
            $this->Sql = "SELECT * FROM t_produits WHERE nom_produit = '$id'";
            $res = $this->FetchRow();
            return $res;
        }

		/**
		 * Fonction getInfoFournisseur
		 * -------------------
		 * Retourne les informations d'un fournisseur en base de donn�es.
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
							FROM `t_produits_achats` AS ef
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
		 * Retourne tous les elements de la table t_factures_achats
		 *
		 * @return array
		 */
		public function getTableFactures()
		{
			$this->Sql = "SELECT * FROM t_factures_achats";
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
         * Fonction getAllFacturesAchatsByJourMoisAnnee
         * -------------------
         * Retourne les factures correspondant a un mois et une annee precise
         *
         * @return array
         */
        public function getAllFacturesAchatsByJourMoisAnnee( $jour, $mois, $annee )
        {
            if( $annee != "" ) {
                $date_fin = $annee."-12-31";
                if( $mois != "" ){
                    if( $jour != "" ){
                        $date_debut = $annee."-".$mois."-".$jour;
                    }else{
                        $date_debut = $annee."-".$mois."-01";
                    }
                }else{
                    $date_debut = $annee."-01-01";
                }

                $sql_where = "WHERE fa.date_facture BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }

            $this->Sql = "SELECT *
							FROM t_factures_achats AS fa
							JOIN t_fournisseurs AS f ON fa.id_fournisseur = f.idt_fournisseurs
							JOIN t_users AS u ON fa.id_user = u.idt_users
							".$sql_where."
							ORDER BY fa.idt_factures_achats DESC";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllFacturesVentesByMoisAnnee
         * -------------------
         * Retourne les factures de ventes correspondant a un mois et une annee precise
         *
         * @return array
         */
        public function getAllFacturesVentesByMoisAnnee( $jour, $mois, $annee )
        {
            if( $annee != "" ) {
                $date_fin = $annee."-12-31";
                if( $mois != "" ){
                    if( $jour != "" ){
                        $date_debut = $annee."-".$mois."-".$jour;
                    }else{
                        $date_debut = $annee."-".$mois."-01";
                    }
                }else{
                    $date_debut = $annee."-01-01";
                }

                $sql_where = "WHERE fv.date_facture BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT *
							FROM t_factures_ventes AS fv
							JOIN t_users AS u ON fv.id_user = u.idt_users
							".$sql_where."
							ORDER BY fv.idt_factures_ventes";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getNbFacturesByMoisAnnee
         * -------------------
         * Retourne le nombre de  factures correspondant a un mois et une annee precise
         *
         * @return array
         */
        public function getNbFacturesByMoisAnnee( $mois, $annee )
        {
            if( $annee != "" ) {
                $date_debut = $annee."-".$mois."-01 00:00:00";
                $date_fin = $annee."-".$mois."-31 23:59:59";
                $sql_where = "WHERE date_facture BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT COUNT(*) AS nb
							FROM t_factures_achats AS fa
							".$sql_where."
							ORDER BY fa.idt_factures_achats";
            $res = $this->FetchRow();
            return $res ["nb"];
        }

        /**
         * Fonction getNbFacturesVentesByMoisAnnee
         * -------------------
         * Retourne le nombre de  factures de ventes correspondant a un mois et une annee precise
         *
         * @return array
         */
        public function getNbFacturesVentesByMoisAnnee( $mois, $annee )
        {
            if( $annee != "" ) {
                $date_debut = $annee."-".$mois."-01 00:00:00";
                $date_fin = $annee."-".$mois."-31 23:59:59";
                $sql_where = "WHERE fv.date_facture BETWEEN '$date_debut' AND '$date_fin'";
            //    $sql_where = "WHERE fv.date_facture >= '$date_debut' AND fv.date_facture <= '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT COUNT(*) AS nb
							FROM t_factures_ventes AS fv
							".$sql_where."
							ORDER BY fv.idt_factures_ventes";
            $res = $this->FetchRow();
            return $res ["nb"];
        }

        /**
         * Fonction getNbInventairesAnnee
         * -------------------
         * Retourne le nombre de  inventaires correspondant a une annee precise
         *
         * @return array
         */
        public function getNbInventairesAnnee( $annee )
        {
            if( $annee != "" ) {
                $date_debut = $annee."-01-01 00:00:00";
                $date_fin = $annee."-12-31 23:59:59";
                $sql_where = "WHERE i.date_inventaire BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT COUNT(*) AS nb
							FROM t_inventaires AS i
							".$sql_where."
							ORDER BY i.idt_inventaires";
            $res = $this->FetchRow();
            return $res ["nb"];
        }

		/**
		 * Fonction getAllProduitsFactureAchats
		 * -------------------
		 * Retourne les produits contenus dans une facture
		 *
		 * @return array
		 */
		public function getAllProduitsFactureAchats()
		{
			$this->Sql = "SELECT * 
							FROM t_produits_achats AS pa
							JOIN t_produits AS p ON pa.id_produit = p.idt_produits
							ORDER BY pa.idt_produits_achats DESC";

			$res = $this->FetchAllRows();
			return $res;
		}

        /**
         * Fonction getAllProduitsFactureVente
         * -------------------
         * Retourne les produits contenus dans une facture
         *
         * @return array
         */
        public function getAllProduitsFactureVente()
        {
            $this->Sql = "SELECT *
							FROM t_produits_ventes AS pv
							JOIN t_produits AS p ON pv.id_produit = p.idt_produits
							ORDER BY pv.idt_produits_ventes DESC";

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
							FROM t_produits_achats AS pf
							JOIN t_produits AS p ON pf.id_produit = p.idt_produits
							WHERE pf.idt_produits_factures = $id";

			$res = $this->FetchRow();
			return $res;
		}

        /**
         * Fonction getInfoProduitOperation
         * -------------------
         * Retourne les informations d'une operation
         *
         * @return array
         */
        public function getInfoProduitOperation( $id )
        {
            $this->Sql = "SELECT *
							FROM t_produits_operations AS po
							JOIN t_produits AS p ON po.id_produit = p.idt_produits
							WHERE po.idt_produits_operations = $id";

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
			$this->Sql = "SELECT SUM(prix_total_produits) AS prix_total_produits FROM t_produits_achats";
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
			$this->Sql = "SELECT COUNT(*) AS nb_produits FROM t_produits_achats";
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
		 * Fonction getAllNumberFacturesFournisseurCurrent
		 * -------------------
		 * Retourne les infos de tous les factures courantes et fournisseurs
		 *
		 * @return array
		 */
		public function getAllNumberFacturesFournisseurCurrent()
		{
			$this->Sql = "SELECT COUNT(fa.idt_factures_achats) AS nb_factures , fa.date_facture, fo.nom_fournisseur
							FROM t_fournisseurs AS fo
							LEFT JOIN t_factures_achats AS fa ON fa.id_fournisseur = fo.idt_fournisseurs
							GROUP BY fo.idt_fournisseurs";
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
							JOIN t_factures_achats AS fa ON a.id_facture = fa.idt_factures_achats
							JOIN t_fournisseurs AS fo ON fa.id_fournisseur = fo.idt_fournisseurs
							".$sql_where;

			$res = $this->FetchAllRows();
			return $res;
		}
//*/
		/**
		 * Fonction getProduitWithAchat
		 * -------------------
		 * Retourne les produits et les achats de ce produit en base de donn�es
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
		 * Retourne les comptes utilisateurs caissier pr�sents en base de donn�es
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
		 * Retourne tous les achats d'une facture en base de donn�es
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
		 * Fonction getAllHistoriquesAchatsByFacture
		 * -------------------
		 * Retourne tous les historiques des achats d'une facture en base de donn�es
		 *
		 * @return array
		 */
		public function getAllHistoriquesAchatsByFacture ( $id )
		{
			$this->Sql = "SELECT *
							FROM t_achats AS a
							JOIN t_produits AS p ON a.id_produit = p.idt_produits
							WHERE a.id_facture = $id";
			$res = $this->FetchAllRows();
			return $res;
		}

        /**
         * Fonction getAllHistoriquesVentesByFacture
         * -------------------
         * Retourne tous les historiques des ventes d'une facture en base de donn�es
         *
         * @return array
         */
        public function getAllHistoriquesVentesByFacture ( $id )
        {
            $this->Sql = "SELECT *
                                FROM t_ventes AS v
                                JOIN t_produits AS p ON v.id_produit = p.idt_produits
                                WHERE v.id_facture_vente = $id";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getInfosFactureAchatById
         * -------------------
         * Retourne tous les infos sur une facture d'achat
         *
         * @return array
         */
        public function getInfosFactureAchatById( $id )
        {
            $this->Sql = "SELECT *
                            FROM t_factures_achats AS f
                            JOIN t_achats AS a ON a.id_facture = f.idt_factures_achats
                            JOIN t_fournisseurs AS fo ON fo.idt_fournisseurs = f.id_fournisseur
                            JOIN t_users AS u ON f.id_user = u.idt_users
                            JOIN t_produits AS p ON a.id_produit = p.idt_produits
                            WHERE f.idt_factures_achats = $id";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getInfosFactureAchatById
         * -------------------
         * Retourne tous les infos sur une facture de vente
         *
         * @return array
         */
        public function getInfosFactureVenteyId( $id )
        {
            $this->Sql = "SELECT *
                                FROM t_factures_ventes AS fv
                                JOIN t_ventes AS v ON v.id_facture_vente = fv.idt_factures_ventes
                                JOIN t_users AS u ON fv.id_user = u.idt_users
                                JOIN t_produits AS p ON v.id_produit = p.idt_produits
                                WHERE fv.idt_factures_ventes = $id";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getInfosFactureAchatById
         * -------------------
         * Retourne tous les infos sur un journal
         *
         * @return array
         */
        public function getInfosJournalById( $id )
        {
            $this->Sql = "SELECT *
                                FROM t_journal AS j
                                JOIN t_operations AS o ON o.id_journal = j.idt_journal
                                JOIN t_users AS u ON j.id_user = u.idt_users
                                JOIN t_produits AS p ON o.id_produit = p.idt_produits
                                WHERE j.idt_journal = $id";
            $res = $this->FetchAllRows();
            return $res;
        }

		/**
		 * Fonction getAllCurrentQuantiteProduitsByPeriode
		 * -------------------
		 * Retourne les quantit�s de produits vendus
		 *
		 * @return array
		 */
		public function getAllCurrentQuantiteProduitsByPeriode( $date_debut, $date_fin )
		{			
			$this->Sql = "SELECT SUM(ha.quantite_achat) AS quantite_achat, SUM(p.stock_initial) AS stock_initial, SUM(p.stock_physique) AS stock_physique
							FROM t_achats AS ha
							JOIN t_factures_achats AS hf ON ha.id_facture = hf.idt_factures_achats
							JOIN t_produits AS p ON ha.id_produit = p.idt_produits
							WHERE hf.date_facture >= '$date_fin' AND hf.date_facture <= '$date_debut'";

			$res = $this->FetchRow();
			return $res;
		}

        /**
         * Fonction getProduitsOperations
         * -------------------
         * Retourne les operations d'un journal
         *
         * @return array
         */
        public function getProduitsOperations()
        {
            $this->Sql = "SELECT *
							FROM t_produits_operations AS po
							JOIN t_produits AS p ON po.id_produit = p.idt_produits
							ORDER BY po.idt_produits_operations DESC";

            $res = $this->FetchAllRows();
            return $res;
        }

         /**
         * Fonction getOperationByIdOperation
         * -------------------
         * Retourne une operation connaissant l'id
         *
         * @return array
         */
        public function getOperationByIdOperation ( $id )
        {
            $this->Sql = "SELECT *
                            FROM t_produits_operations AS po
                            WHERE po.idt_produits_operations = $id";
            $res = $this->FetchRow();
            return $res;
        }

        /**
         * Fonction getAllProduitsOperationsJournal
         * -------------------
         * Retourne tous les produits des operations deja enegistrées
         *
         * @return array
         */
        public function getAllProduitsOperationsJournal()
        {
            $this->Sql = "SELECT *
                                FROM t_produits_operations AS po
                                JOIN t_produits AS p
                                ON p.idt_produits = po.id_produit";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsOperationsFacture
         * -------------------
         * Retourne tous les produits d'un facture d'achat en cours d'enregistrement
         *
         * @return Array
         */
        public function getAllProduitsOperationsFacture()
        {
            $this->Sql = "SELECT *
                                FROM t_produits_achats AS pf
                                JOIN t_produits AS p
                                ON p.idt_produits = pf.id_produit";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsOperationsVentesFacture
         * -------------------
         * Retourne tous les produits d'un facture de vente en cours d'enregistrement
         *
         * @return Array
         */
        public function getAllProduitsOperationsVentesFacture()
        {
            $this->Sql = "SELECT *
                                    FROM t_produits_ventes AS pv
                                    JOIN t_produits AS p
                                    ON p.idt_produits = pv.id_produit";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllProduitsVendusFacture
         * -------------------
         * Retourne tous les produits d'une facture de vente
         *
         * @return Array
         */
        public function getAllProduitsVendusFacture()
        {
            $this->Sql = "SELECT *
                                    FROM t_produits_ventes AS pv
                                    JOIN t_produits AS p
                                    ON p.idt_produits = pv.id_produit";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllJournal
         * -------------------
         * Retourne tous les journaux
         *
         * @return Array
         */
        public function getAllJournal()
        {
            $this->Sql = "SELECT * FROM t_journal ORDER BY idt_journal";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllInventaires
         * -------------------
         * Retourne tous les inventaires
         *
         * @return Array
         */
        public function getAllInventaires()
        {
            $this->Sql = "SELECT * FROM t_inventaires ORDER BY idt_inventaires";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllInventaires
         * -------------------
         * Retourne tous les inventaires
         *
         * @return Array
         */
        public function getInfosInventairesUneAnnee()
        {
            $this->Sql = "SELECT *
                          FROM t_inventaires AS i
                          ORDER BY i.date_inventaire DESC
                          LIMIT 12";
            $res = $this->FetchAllRows();
            return $res;
        }

    /**
         * Fonction getAllJournalByAnnee
         * -------------------
         * Retourne les journaux présents en base de données pour une annee donnée
         *
         * @return array
         */
        public function getAllJournalByAnnee ($annee)
        {
            if( $annee != "" ) {
                $date_debut = $annee."-01-01";
                $date_fin = $annee."-12-31";
                $sql_where = "WHERE date_journal BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT *
                                FROM t_journal AS j
                                ".$sql_where."
                                ORDER BY j.idt_journal";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getNbJournalByMoisAnnee
         * -------------------
         * Retourne le nombre de journaux correspondant a un mois et une annee precise
         *
         * @return array
         */
        public function getNbJournalByMoisAnnee( $mois, $annee )
        {
            if( $annee != "" ) {
                $date_debut = $annee."-".$mois."-01";
                $date_fin = $annee."-".$mois."-31";
                $sql_where = "WHERE j.date_journal BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT COUNT(*) AS nb
                                FROM t_journal AS j
                                ".$sql_where."
                                ORDER BY j.idt_journal";
            $res = $this->FetchRow();
            return $res ["nb"];
        }

        /**
         * Fonction getAllJournalByMoisAnnee
         * -------------------
         * Retourne les journaux correspondants a un mois et une annee precise
         *
         * @return array
         */
        public function getAllJournalByMoisAnnee( $jour, $mois, $annee )
        {
            if( $annee != "" ) {
                $date_fin = $annee."-12-31";
                if( $mois != "" ){
                    if( $jour != "" ){
                        $date_debut = $annee."-".$mois."-".$jour;
                    }else{
                        $date_debut = $annee."-".$mois."-01";
                    }
                }else{
                    $date_debut = $annee."-01-01";
                }

                $sql_where = "WHERE j.date_journal BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT *
                                FROM t_journal AS j
                                JOIN t_users AS u ON j.id_user = u.idt_users
                                ".$sql_where."
                                ORDER BY j.idt_journal DESC";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllInventairesAnnee
         * -------------------
         * Retourne les inventaires correspondants a un mois et une annee precise
         *
         * @return array
         */
        public function getAllInventairesAnnee( $jour, $mois, $annee )
        {
            if( $annee != "" ) {
                $date_fin = $annee."-12-31";
                if( $mois != "" ){
                    if( $jour != "" ){
                        $date_debut = $annee."-".$mois."-".$jour;
                    }else{
                        $date_debut = $annee."-".$mois."-01";
                    }
                }else{
                    $date_debut = $annee."-01-01";
                }

                $sql_where = "WHERE i.date_inventaire BETWEEN '$date_debut' AND '$date_fin'";
            }else {
                $sql_where = "";
            }
            $this->Sql = "SELECT *
                                    FROM t_inventaires AS i
                                    JOIN t_users AS u ON i.id_user = u.idt_users
                                    ".$sql_where."
                                    ORDER BY i.idt_inventaires DESC";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getAllHistoriquesOperationsByJournal
         * -------------------
         * Retourne tous les historiques des operations d'un journal en base de données
         *
         * @return array
         */
        public function getAllHistoriquesOperationsByJournal ( $id )
        {
            $this->Sql = "SELECT *
                                FROM t_operations AS o
                                JOIN t_produits AS p ON o.id_produit = p.idt_produits
                                WHERE o.id_journal = $id";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getInfosProduitByInventaire
         * -------------------
         * Retourne les infos d'un produit pour un inventaire donné
         *
         * @return array
         */
        public function getInfosProduitJournalByInventaire ( $id_produit, $id_inventaire )
        {
            $this->Sql = "SELECT *, SUM(o.quantite_vendue) AS qte_vendue
                                FROM t_journal AS j
                                JOIN t_operations AS o ON j.idt_journal = o.id_journal
                                WHERE j.id_inventaire = $id_inventaire AND o.id_produit = $id_produit
                                GROUP BY o.id_produit";
            $res = $this->FetchRow();
            return $res;
        }

        /**
         * Fonction getAllMatieresPremieres
         * -------------------
         * Retourne les matieres premieres pr�sentes en base de donn�es
         *
         * @return array
         */
        public function getAllMatieresPremieres ()
        {
            $this->Sql = "SELECT * FROM t_matieres_premieres ORDER BY nom_matiere_premiere";
            $res = $this->FetchAllRows();
            return $res;
        }

        /**
         * Fonction getNbMatieresPremieresInDB
         * -------------------
         * Retourne le nombre de type de matieres premieres présentes en base de données.
         *
         * @return int
         */
        public function getNbMatieresPremieresInDB ()
        {
            $this->Sql = "SELECT COUNT(*) AS nb FROM t_matieres_premieres";
            $res = $this->FetchRow();
            return $res ["nb"];
        }
	}
?>