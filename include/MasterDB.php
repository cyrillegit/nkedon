<?php
/**
	La classe MasterDB va récupérer uniquement les informations nécessaires au bon fonctionnement
	des accès aux bases de données. Dans cette base, on fera uniquement une requête pour avoir la CN String utile.
*/
@session_start ();
class MasterDB extends PDO
{
	// ConnectionString
	protected $Connection;
	
	// Requête SQL interne.
	protected $Sql;
	
	/**
		MasterDB
		--------
		Constructeur par défaut de la connexion à la base de données globale.
	*/
	function MasterDB()
	{
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
		SetSql
		------
		Initialise le pointeur de la chaîne contenant la requête SQL.
		
		@param string $sql
		@return void
	*/
	public function SetSql ($sql)
	{
		$this->Sql = $sql;
	}
	
	/**
		ConnectNormal
		-------------
		Effectue une connexion vers le serveur

		@return boolean
	*/
	public function ConnectNormal ()
	{
		$this->Connection = array 
		(
			"hostname" => Configuration::getValue ("host"),
			"db_name" => Configuration::getValue ("dbname"),
			"user" => Configuration::getValue ("user"),
			"password" => Configuration::getValue ("password")
		);
		return true;
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
	 * @return void
	 */
	public function fixEncodingArray( &$array )
	{
		// JPerciot, correctif sur la donnée $array, si c'est un tableau, on fait le traitement, sinon on sort.
		if (is_array ($array))
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
		try
		{
			$recordset = $this->query ($this->Sql);
			if ($recordset)
			{
				$recordset = $recordset->fetch ($mode);
				$this->fixEncodingArray ($recordset);
				return $recordset;
			}
			else
			{
				$mail = new Mail ();
			
				$mail->AddSubject("Voirie -- Fonction ClassDB::FetchRow");
				$mail->AddRecipients(array ("Equipe de developpement id2tel" => Configuration::getValue ("admin_mail")), "To");
				$body = " 
				<html>
				<head>
				</head>
				<body>
				<b><h2>Site ESP ESV Voirie</h2></b><br />
				Requête SQL exécutée : <b>".$this->Sql."</b><br />
				<br />
				L'équipe de developpement id2tel
				</body>
				</html>";
				$mail->AddBody($body);
				$mail->sendMail();
				return NULL;
			}
		}
		catch (PDOException $e)
		{
			echo 'Exception : ' . $e->getMessage();
			throw_error($dbex);
			return NULL;
		}
	}
	
	/**
	 * Fonction FetchAllRows
	 * ---------------------
	 * Récupération d'e toutes les informations disponibles dans le tableau.
	 * 
	 * @return Array or Null
	 */
	public function FetchAllRows ($mode = PDO::FETCH_BOTH)
	{
		$recordset = $this->query ($this->Sql);
		if ($recordset)
		{
			$recordset = $recordset->fetchAll ($mode);
			$this->fixEncodingArray ($recordset);
			return $recordset;
		}
		else
		{
			$mail = new Mail ();
		
			$mail->AddSubject("Voirie -- Fonction ClassDB::FetchAllRows");
			$mail->AddRecipients(array ("Equipe de developpement id2tel" => Configuration::getValue ("admin_mail")), "To");
			$body = " 
			<html>
			<head>
			</head>
			<body>
			<b><h2>Site ESV ESD Voirie</h2></b><br />
			Requête SQL exécutée : <b>".$this->Sql."</b><br />
			<br />
			L'équipe de developpement id2tel
			</body>
			</html>";
			$mail->AddBody($body);
			$mail->sendMail();
			return NULL;
		}
	}
	
	/**
		GetConnectionInfo
		-----------------
		Renvoie l'information sur la base de données master. Sur le serveur central.
		
		@return Array
	*/
	public function GetConnectionInfo ()
	{
		return $this->Connection;
	}

	/**
	 * Fonction GetSqlErrorAjax
	 * ------------------------
	 * Cette fonction renvoie au format Ajax/Json une erreur humainement interprétable.
	 *
	 * @return string
	 */
	public function GetSqlErrorAjax ()
	{
		$error = $this->errorInfo();
		$this->Sql = $this->Sql;
		$this->Sql = str_replace ("'", "&rsquo;", $this->Sql);
		$this->Sql = json_encode ($this->Sql);
		$msg = "Code erreur : " . $error [0] . "<br />Desc. : " . $err [1] . "<br />SQL : $this->Sql";
		$string = "({'result': 'FAILED', 'message': '$msg'})";
		return $string;
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
				$errorInfo = $this->errorInfo ();
				$mail = new Mail ();
			
				$mail->AddSubject("Voirie-- Fonction MasterDB::Execute");
				$mail->AddRecipients(array ("Equipe de developpement id2tel" => Configuration::getValue ("admin_mail")), "To");
				$body = " 
				<html>
				<head>
				</head>
				<body>
				<b><h2>Site ESV ESD Voirie</h2></b><br />
				Requête SQL ex&eacute;cut&eacute;e : <b>".$this->Sql."</b><br />
				Code de l'erreur :<br />
				".$errorInfo [1]."
				</br /></br />Description de l'erreur :<br />
				".$errorInfo [2]."
				<br />
				L'&eacute;quipe de developpement id2tel
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
			$mail = new Mail ();
			
			$mail->AddSubject("Voirie -- Fonction MasterDB::Execute");
			$mail->AddRecipients(array ("Equipe de developpement id2tel" => Configuration::getValue ("admin_mail")), "To");
			$body = " 
			<html>
			<head>
			</head>
			<body>
			<b><h2>Site ESV ESD</h2></b><br />
			Description de l'erreur :<br />".$e->getMessage()."
			<br />
			Fichier source : ".$e->getFile()."<br />
			Ligne : ".$e->getLine().".<br /><br /><br />
			L'&eacute;quipe de developpement id2tel
			</body>
			</html>";
			$mail->AddBody($body);
			$mail->sendMail();
			return false;
		}
	}
}
?>