<?php
	@session_start();
	@require_once("./config/config.php");
	@require_once("./include/function.php");
//	@require_once("./include/ClassTemplate.php");
	@require_once("./include/ClassUser.php");
//	@require_once("./include/MasterDB.php");
	@require_once("./include/ClassDB.php");	
	@require_once("Smarty/libs/Smarty.class.php");

	// On d&eacute;sactive les notices dans les messages d'erreur.
	ini_set("error_reporting",E_ALL & ~E_NOTICE);
	ini_set("display_errors", true);
	
//	$tpl_index = new Templates();
	$tpl_index = new Smarty;

	$User = new User();
	$db = new Database();
	$db->beginTransaction ();
	
	header ("Content-type: text/html; charset=UTF-8");
	if (isset($_GET['logout']))
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
		unset($_SESSION['infoUser']);
		@session_destroy();
	   
	   $tpl_index->display ('notLogged.tpl');
	}

	if (isset($_SESSION['login']))
	{
		$User->connection($_SESSION['login'], $_SESSION['password']);
	}
	
	if ($User->Connected() != CONNECTED)
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
		session_destroy();

		$tpl_index->display('notLogged.tpl');
	}
	else
	{
		$infos = array ();
		$target = $_GET ["sub"];

		if ($target == "")
		{
			$target = "main";
		}
		else
		{
			if( $target == "historiques_journal" )
			{
                if(isset($_GET["annee"])) {
                    $annee = $_GET["annee"];

                    if ($annee == "") {
                        $target = "main";
                    } else {
                        if(isset($_GET["mois"])){
                            $mois = $_GET["mois"];

                            if ($mois == "") {
                                $target = "main";
                            } else {
                                $nb_journal = $db->getNbJournalByMoisAnnee( $mois, $annee );

                                $tpl_index->assign("nb_journal", $nb_journal );
                                $tpl_index->assign("mois_annee", getLitterateMonth( $mois )." ".$annee);
                                $target = "historiques_journal/journal_mois";
                            }
                        }else{
                            $tpl_index->assign("annee", $annee);
                            $target = "historiques_journal/journal_annee";
                        }
                    }
                }else{
                    $target = "historiques_journal/historiques_journal";
                }
			}
            else if( $target == "historiques_factures" )
            {
                if(isset($_GET["annee"])) {
                    $annee = $_GET["annee"];

                    if ($annee == "") {
                        $target = "main";
                    } else {
                        if(isset($_GET["mois"])){
                            $mois = $_GET["mois"];

                            if ($mois == "") {
                                $target = "main";
                            } else {
                                $nb_factures = $db->getNbFacturesByMoisAnnee( $mois, $annee );

                                $tpl_index->assign("nb_factures", $nb_factures );
                                $tpl_index->assign("mois_annee", getLitterateMonth( $mois )." ".$annee);
                                $target = "historiques_factures/factures_mois";
                            }
                        }else{
                            $tpl_index->assign("annee", $annee);
                            $target = "historiques_factures/factures_annee";
                        }
                    }
                }else{
                    $target = "historiques_factures/historiques_factures";
                }
            }
            else if( $target == "historiques_inventaires" )
            {
                if(isset($_GET["annee"])) {
                    $annee = $_GET["annee"];

                    if ($annee == "") {
                        $target = "main";
                    } else {
                        $nb_inventaires = $db->getNbInventairesAnnee( $annee );
                        $tpl_index->assign("annee", $annee);
                        $tpl_index->assign("nb_inventaires", $nb_inventaires );
                        $target = "historiques_inventaires/inventaires_annee";
                    }
                }else{
                    $target = "historiques_inventaires/historiques_inventaires";
                }
            }
            else if( $target == "statistiques" )
            {
                $target = "statistiques/statistiques";
            }
			else if( $target == "backupdb" )
			{
				
			}																										
			else
			{
				$target = "main";
			}
		}
		$tpl_index->display('historiques/'.$target.'.tpl');
	}
?>