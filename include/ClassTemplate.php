<?php
	@define ("ROOT_FOLDER", Configuration::getValue ('path_root'));
	@require(ROOT_FOLDER.'Smarty/libs/Smarty.class.php');

	class Templates extends Smarty
	{
		//*
		function __construct()
		{
		//	$master = new MasterDB ();
			
			parent::__construct ();
			/**
				Activation du cache pour accélération des requêtes. Le fichier n'est regénéré QUE s'il a été modifié.
				Le cache n'est effectif QUE sur le serveur de production. En effet, le serveur de développement, ne convient pas à ça,
				vu la trop grande fréquence de mises à jour des documents...
			*/
				/*
			$this->caching = 0;
			$this->template_dir = ROOT_FOLDER.'templates/';
				
			$this->compile_dir = ROOT_FOLDER.'smarty/templates_c/';
				
			if (!file_exists ($this->compile_dir))
			{
				mkdir ($this->compile_dir);
			}
			$this->cache_dir = ROOT_FOLDER.'smarty/cache/';
			$this->config_dir = ROOT_FOLDER.'smarty/configs/';
			
			// Informations utiles affichées dans le backoffice.
			$this->assign ("session_id", session_id ());
			
			// Permet entre autres de désactiver les plans / google functions inutiles en local.
			$this->assign ("IsLocalEnvironment", Configuration::getValue ("IsLocal"));
			
			// Ssi on est connecté, on peut utiliser cette information.
			if (isset ($_SESSION ["connected"]) && ($_SESSION ["connected"]))
			{
			//	$db = new Database ();
				
				$config ["TestEnvironment"] = Configuration::getValue ("TestEnvironment");
				$this->assign ("Globals", $config);
			}
			
			
			if (isset($_SESSION ["connected"]) && $_SESSION ["connected"])
			{
			//	$db = new Database ();
				// Appel de la fonction qui va copier les droits pour l'administrateur.			
			}

			// Pour la gestion des clés Google Maps.
			$this->assign ("port", $_SERVER['SERVER_PORT']);
			$this->assign ("remote_addr", $_SERVER ["REMOTE_ADDR"]);
			$this->assign ("http_host", $_SERVER['HTTP_HOST']);
			$this->assign ("http_home", Configuration::getValue ("http_home"));
		}
		//*/
	}
?>