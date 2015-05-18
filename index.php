<?php
	/**
		Fichier index.php
		-----------------
		Page d'index du site Internet, il permet d'initialiser les pages de connexion, et de donn�es
		communes dans le milieu de la page.
		
		On teste si on est connect�, en v�rifiant $smarty.session.connected en bool�en.
	*/
	
	@session_start();

	@require_once("Smarty/libs/Smarty.class.php");
	
	@require_once("config/config.php");
	@require_once("include/function.php");
//	@require_once("include/ClassTemplate.php");
	@require_once ("include/MasterDB.php");
	@require_once ("include/ClassDB.php");
	@require_once("include/ClassUser.php");

	
	// On d&eacute;sactive les notices dans les messages d'erreur.
	$tpl_index = new Smarty;
//	$tpl_index = new Templates ();

	$User = new User();
	$db = new Database ();
	$db->beginTransaction ();
    $logout = true;
	
	header ("Content-type: text/html; charset=UTF-8");
	if (isset($_GET['logout']))
	{
        if( $_GET["logout"] == "disconnect" ){

            $ok = true;
            $sql1 = "DELETE FROM t_produits_operations";
            $sql2 = "DELETE FROM t_produits_achats";
            $sql3 = "DELETE FROM t_produits_ventes";
            $ok &= $db->Execute( $sql1 );
            $ok &= $db->Execute( $sql2 );
            $ok &= $db->Execute( $sql3 );

            if( $ok )
            {
                $db->commit ();
                // On r�cup�re donc toutes les informations utiles ici.
                $_SESSION["wasConnected"] = true;
                $db->fixEncodingArray($_SESSION);
            }
            else
            {
                $db->rollBack();
            }

//            $logout = true;
//            header("Location: index.php");

            unset($_SESSION['login']);
            unset($_SESSION['password']);
            unset($_SESSION['connected']);
            @session_destroy();
            $wasDisconnected = true;

        //    $tpl_index->display('notLogged.tpl');
            header("Location: index.php");

        }else {
            $produits = $db->getAllOperationsJournal();

            if (count($produits) <= 0) {
                unset($_SESSION['login']);
                unset($_SESSION['password']);
                unset($_SESSION['infoUser']);
                //	@session_destroy();
                $logout = true;
                header("Location: index.php");
            } else {
                $logout = false;
            }
        }
	}

	// Modification des locales pour le site Internet.
	@setlocale(LC_ALL, array('fr_FR.utf8','fr_FR@euro','fr_FR','french'));

	if (isset($_SESSION['login']))
	{
		$User->connection($_SESSION['login'], $_SESSION['password']);
	}
	
	if ($User->Connected() != CONNECTED)
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
		unset($_SESSION['connected']);
		@session_destroy();
		$wasDisconnected = true;

		$tpl_index->display('notLogged.tpl');
	}
	else
	{
		if( !$_SESSION["wasConnected"] )
		{
		//	$master = new MasterDB ();
			$datetime_last_connected = setLocalTime();
			$nombre_connexion = $_SESSION["infoUser"]["nombre_connexion"] + 1;
			$id_user = $_SESSION["infoUser"]["idt_users"] ;

			$sql = "UPDATE t_users
					SET datetime_last_connected = '$datetime_last_connected',
						nombre_connexion = $nombre_connexion
					WHERE idt_users = $id_user";

			if( $db->Execute ( $sql ) )
			{
				$db->commit ();
                // set cookie for 25 years
                if( !isset( $_COOKIE["operation"] )){
                    setcookie("operation", 1, time()+3600*24*365*25);
                }
                if( !isset( $_COOKIE["ventes"] )){
                    setcookie("ventes", 1, time()+3600*24*365*25);
                }
				// On r�cup�re donc toutes les informations utiles ici.
				$_SESSION["wasConnected"] = true;
				$db->fixEncodingArray($_SESSION);
			}
			else
			{
				$db->rollBack();
			}
		}
		$_SESSION["infoUser"]["datetime_last_connected"] = SQLDateTimeToFrenchDateTime( $_SESSION["infoUser"]["datetime_last_connected"] );

        if( $logout == true ) {
            $tpl_index->display('index.tpl');
        }else{
            $montant_operation = 0;
            $nb_produits = 0;
            $id_journal = 0;
            $commentaire = "";

            $produits_operation = $db->getAllProduitsOperationsJournal();
            foreach( $produits_operation as $po ){
                $nb_produits++;
                $montant_operation += $po["quantite_vendue"] * $po["prix_vente"];
            }

            $tpl_index->assign( "id_journal", $id_journal);
            $tpl_index->assign( "commentaire", $commentaire );
            $tpl_index->assign("nb_produits", $nb_produits);
            $tpl_index->assign( "montant_journal", number_format( $montant_operation, 2, ',', ' ') );
            $tpl_index->display('magasin/gestion_journal/edit_operations_journal.tpl');
        }

	}
?>