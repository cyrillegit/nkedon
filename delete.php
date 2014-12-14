<?php
	/**********************************************************************
	*
	* Auteur : Cyrille MOFFO
	* Date de création : 08/12/2013
	* Date de modification :
	*
	***********************************************************************
	* Gestion des suppressions.
	* Un premier essaie tente d'effectuer la suppression.
	* Si celle-ci échoue, car actuellement utilisée, on ouvrira une
	* autre page avec un filler de remplacement.
	* Sinon, la suppression est effectuée directement.
	*
	**********************************************************************/
	@session_start();
	
	@require_once("Smarty/libs/Smarty.class.php");
//	@require_once ("config/config.php");
//	@require_once ("include/function.php");
//	@require_once ("include/ClassTemplate.php");
//	@require_once ("include/MasterDB.php");
	@require_once ("include/ClassDB.php");
	@require_once ("include/ClassUser.php");
//	@require_once ("include/ClassMail.php");
	
	// On d&eacute;sactive les notices dans les messages d'erreur.
	
		
//	$tpl_index = new Templates ();
	$tpl_index = new Smarty;
	$User = new User();
	$db = new Database ();
	
	header ("Content-type: text/html; charset=UTF-8");
	if (isset($_GET['logout']))
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
		unset($_SESSION['infoUser']);
	//	@session_destroy();	   
	   header ("Location: index.php");
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
		@session_destroy();
		$tpl_index->display('notLogged.tpl');
	}
	else
	{
		$ok = true;
		$id = $_GET ["id"];
		
		$db->beginTransaction();
		if ($_GET ["target"] == "compte_utilisateur")
		{
			$ok &= $db->Execute ("DELETE FROM t_users WHERE idt_users=$id");

				if( $ok )
				{
					$tpl_index->assign ("message", $db->fixEncoding("La suppression de l'utilisateur a bien été réalisée."));
					$tpl_index->assign ("error", 0);
				}
				else
				{
					$tpl_index->assign ("message", $db->fixEncoding("La suppression de l'utilisateur a échouée."));
					$tpl_index->assign ("error", 1);
				}					
		}
		else if ( $_GET ["target"] == "type_user" )
		{
			$sql = "DELETE FROM t_types_users WHERE idt_types_users = $id";
			$ok &= $db->Execute ( $sql );
			if( $ok )
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du profil utilisateur a bien été réalisée."));
				$tpl_index->assign ("error", 0);
			}
			else
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du profil utilisateur a échouée."));
				$tpl_index->assign ("error", 1);
			}
		}
		else if ( $_GET ["target"] == "produit" )
		{
			$sql = "DELETE FROM t_produits WHERE idt_produits = $id";
			$ok &= $db->Execute ( $sql );
			if( $ok )
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du produit a bien été réalisée."));
				$tpl_index->assign ("error", 0);
			}
			else
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du produit a échouée."));
				$tpl_index->assign ("error", 1);
			}
		}
		else if ( $_GET ["target"] == "fournisseur" )
		{
			$sql = "DELETE FROM t_fournisseurs WHERE idt_fournisseurs = $id";
			$ok &= $db->Execute ( $sql );
			if( $ok )
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du fournisseur a bien été réalisée."));
				$tpl_index->assign ("error", 0);
			}
			else
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du fournisseur a échouée."));
				$tpl_index->assign ("error", 1);
			}
		}
		else if ( $_GET ["target"] == "edit_produit_achete" )
		{
			$sql = "DELETE FROM t_edit_facture WHERE idt_edit_facture = $id";
			$ok &= $db->Execute ( $sql );
			if( $ok )
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du produit acheté a bien été réalisée."));
				$tpl_index->assign ("error", 0);
			}
			else
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du produit acheté a échouée."));
				$tpl_index->assign ("error", 1);
			}
		}	
		else if ( $_GET ["target"] == "facture" )
		{
			$sql = "DELETE FROM t_achats WHERE id_facture = $id";
			$sql1 = "DELETE FROM t_factures WHERE idt_factures = $id";

			$ok &= $db->Execute ( $sql );
			$ok &= $db->Execute ( $sql1 );
			if( $ok )
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression de la facture a bien été réalisée."));
				$tpl_index->assign ("error", 0);
			}
			else
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression de la facture a échouée."));
				$tpl_index->assign ("error", 1);
			}
		}			
		else if($_GET ["target"] == "produit_facture")
		{
			$sql = "DELETE FROM t_produits_factures WHERE idt_produits_factures = $id";
			$ok &= $db->Execute ( $sql );
			if( $ok )
			{
				$tpl_index->assign ("message", $db->fixEncoding("Le produit a bien été supprimé de la facture."));
				$tpl_index->assign ("error", 0);
			}
			else
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression du produit dans la facture a échouée."));
				$tpl_index->assign ("error", 1);
			}
		}
		else if($_GET ["target"] == "delete_produits_facture")
		{
			$sql = "DELETE FROM t_produits_factures";
			$ok &= $db->Execute ( $sql );
			if( $ok )
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression de la facture a bien été réalisée."));
				$tpl_index->assign ("error", 0);
			}
			else
			{
				$tpl_index->assign ("message", $db->fixEncoding("La suppression de la facture a échouée."));
				$tpl_index->assign ("error", 1);
			}
		}				
		else
		{

		}

		if ($ok)
		{
			$db->commit();
		}
		else
		{
			$db->rollBack();
		}
		$tpl_index->assign ("show_return", true);
		$tpl_index->display('delete/result.tpl');
	}
?>