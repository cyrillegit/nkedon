<?php
	/* ****************************************************************
	
	Fichier : config.php
	Version : 1.0
	Auteur : Cyrille MOFFO
	-------------------------------------------------------------------
	Liste des fonctions :
	-	__construct
	-	getValue
	-	initialize
	
	Param&egrave;tres principaux du site Qualiweb. Les informations de 
	connexion &agrave; la base de donn&eacute;es sont l&agrave;.
	
	On va utiliser la valeur ProductionEnvironment pour déterminer si on
	est bien dans un environnement propice à l'utilisation des répertoires
	spécifiques.
	
	**************************************************************** */
	class Configuration
	{
		private $cfg = null;
		static private $myself;

		private function __construct()
		{
			$path_root = $_SERVER ["DOCUMENT_ROOT"];
			
			$ProductionEnvironment = (($_SERVER["SERVER_NAME"] != "127.0.0.1"));
			$Local = $_SERVER['SERVER_NAME'] == "127.0.0.1";
			
			$TestEnvironment = false;
			$prefix = ($ProductionEnvironment ? "nkedon/" : "/nkedon/");
			$this->cfg = array(
				// ------------------------------------------------------------------------------------- //
				'common_host'				=> 'localhost',
				'common_dbname'				=> 'nkedon_db',
				'common_user'				=> $Local || !$ProductionEnvironment ? 'root' : 'root',
				'common_password'			=> $Local || !$ProductionEnvironment ? '' : '',
				// ------------------------------------------------------------------------------------- //
				'host' 						=> 'localhost',
				'dbname'	 				=> 'nkedon_db',
				'user' 						=> $Local || !$ProductionEnvironment ? 'root' : 'root',
				'password'					=> $Local || !$ProductionEnvironment ? '' : '',
				// ------------------------------------------------------------------------------------- //
				
				'VersionSite'				=> "1.0",
				'ProductionEnvironment'		=> $ProductionEnvironment,
				'IsLocal'					=> $Local,
				'TestEnvironment'			=> $TestEnvironment,
				'SIGNATURE'					=> "NKEDON",						// Nom du logiciel. Pour s'assurer du bon serveur.
				'admin_mail'				=> 'developpement@intelness.com',
				'documents_root'			=> $path_root . $prefix .'Documents/',
				'absolute_path_root'		=> $path_root,
				'path_root'					=> $path_root . $prefix .'',
				'UploadsPath'				=> $path_root . $prefix . 'Documents/uploads/',
				// La variable http_home permet de savoir sur quel serveur on est, celui de production ou celui de développement, cette partie est très importante.
				'http_home'					=> "http://".$_SERVER ["SERVER_NAME"].($ProductionEnvironment ? "/nkedon/" : "/nkedon/"),
				'use_mail_system'			=> false,
				'RowsToDeleteIfMax'			=> 100,
				'MaxRowsAllowedInWebAccessLog'	=> 10000,
				'ActivateEmailerLog'		=> false
			);
		}
		
		public static function getValue($key, $canFail = false)
		{
			if (array_key_exists($key, self::$myself->cfg))
				return self::$myself->cfg[$key];
			else{
				if ($canFail)
					return NULL;
			}
		}
		
		public static function initialize()
		{
			self::$myself = new Configuration();
		}
	}
	
	Configuration::initialize();

?>