<?php
	@session_start();

	@require_once("./config/config.php");
	@require_once("./include/function.php");
//	@require_once("./include/ClassTemplate.php");
	@require_once("./include/ClassUser.php");
	@require_once("./include/ClassDownloadFactureAchat.php");
    @require_once("./include/ClassDownloadFactureVente.php");
    @require_once("./include/ClassDownloadJournal.php");
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
			if( $target == "facture_achat" )
			{
                isset($_GET ["id_facture"]) ? $id_facture = addslashes(htmlspecialchars($_GET ["id_facture"])) : $id_facture = "";
                if( $id_facture != "" ){
                    $html = new FactureAchat( $id_facture );
                    $htmlContent = $html->buildHtml();
                    $html->buildPdf( $htmlContent );
                }else{
                    echo "Facture introuvable";
                }
			}
            else if( $target == "facture_vente" )
            {
                isset($_GET ["id_facture"]) ? $id_facture = addslashes(htmlspecialchars($_GET ["id_facture"])) : $id_facture = "";
                if( $id_facture != "" ){
                    $html = new FactureVente( $id_facture );
                    $htmlContent = $html->buildHtml();
                    $html->buildPdf( $htmlContent );
                }else{
                    echo "Facture introuvable";
                }
            }
            else if( $target == "journal" )
            {
                isset($_GET ["id_journal"]) ? $id_journal = addslashes(htmlspecialchars($_GET ["id_journal"])) : $id_journal = "";
                if( $id_journal != "" ){
                    $html = new Journal( $id_journal );
                    $htmlContent = $html->buildHtml();
                    $html->buildPdf( $htmlContent );
                }else{
                    echo "Journal introuvable";
                }
            }
            else if( $target == "inventaire" )
            {
                isset($_GET ["id_inventaire"]) ? $id_inventaire = addslashes(htmlspecialchars($_GET ["id_inventaire"])) : $id_inventaire = "";
                if( $id_inventaire != "" ){
                    $inventaire = $db->getRecapitulatifInventaire( $id_inventaire );
                    $filepath = $inventaire["filepath"];
                    $content = readfile( $filepath );
                    echo $content;
                }else{
                    echo "synthese introuvable";
                }

            }
            else if( $target == "edit_historique_facture_achat" )
            {

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
	//	$tpl_index->display('historiques/'.$target.'.tpl');
	}
?>