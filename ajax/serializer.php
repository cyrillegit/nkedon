<?php
/**
	Fichier de sérialisation
	------------------------
	Ce fichier permet d'enregistrer des informations dans la base de données.
	
	Auteur : Cyrille MOFFO
	Copyright : Nemand Softwares. 2013-2014.
	Tous droits réservés.
*/
@require_once ("../config/config.php");
@require_once ("../include/function.php");
//@require_once ("../include/MasterDB.php");
@require_once ("../include/ClassDB.php");
//@require_once ("../include/ClassMail.php");
@require_once ("../include/ClassUser.php");

// On redémarre la session.
@session_start ();

if (!$_SESSION["connected"])
{
	// On est plus connecté, on sort.
	$_SESSION ["sessionExpired"] = true;
	header ("Location: ../index.php");
}
else
{
	/**
		errorHandler
		------------
		
		Fonction pour être absolument certain d'avoir une réponse enn toute circonstances, même en cas de plantage du PHP ou du serveur.
	*/
	function errorHandler($n, $m, $f, $l) 
	{
		$err = error_get_last();
		if($err)
		{
			echo "({'result': 'FAILED', 'message': 'Erreur interne du serveur. Le support technique en a été informé.'})";
		}
	}
	
	//register_shutdown_function('errorHandler');
	if ((!isset ($_SESSION ['infoUser'])))
	{

		echo "({'result': 'FAILED', 'message': 'Erreur de sécurité. Vous êtes déconnecté.'})";
	}
	else
	{
		try
		{

			$db = new Database ();

			if ($_POST ["target"] == "produits")
			{
				include ("Serializer/edit_produit.php");
			}
			else if ($_POST ["target"] == "fournisseurs")
			{
				include ("Serializer/edit_fournisseur.php");
			}
			else if ($_POST ["target"] == "facture_achat")
			{
				include ("Serializer/edit_facture_achat.php");
			}						
			else if ($_POST ["target"] == "compte_utilisateur")
			{
				include ("Serializer/compte_utilisateur.php");
			}
			else if ($_POST ["target"] == "types_users")
			{
				include ("Serializer/types_users.php");
			}
			else if ($_POST ["target"] == "password_oublie")
			{
				include ("Serializer/password_oublie.php");
			}
			else if ($_POST ["target"] == "edit_facture")
			{
				include ("Serializer/edit_produit_facture.php");
			}
			else if ($_POST ["target"] == "edit_produit_achete")
			{
				include ("Serializer/edit_produit_achete.php");
			}
			else if ($_POST ["target"] == "inventaire_produit")
			{
				include ("Serializer/inventaire_produit.php");
			}
			else if ($_POST ["target"] == "inventaire")
			{
				include ("Serializer/inventaire.php");
			}
			else if ($_POST ["target"] == "produits_facture")
			{
				include ("Serializer/produits_facture.php");
			}
            else if ($_POST ["target"] == "produits_vente")
            {
                include ("Serializer/produits_vente.php");
            }
            else if ($_POST ["target"] == "facture_vente")
            {
                include ("Serializer/edit_facture_vente.php");
            }
            else if ($_POST ["target"] == "operations_journal")
            {
                include ("Serializer/operations_journal.php");
            }
            else if ($_POST ["target"] == "journal")
            {
                include ("Serializer/edit_journal.php");
            }
            else if ($_POST ["target"] == "matieres_premieres")
            {
                include ("Serializer/edit_matiere_premiere.php");
            }
			else
			{
				echo "({'result': 'FAILED', 'message': 'La cible (\'<strong>".$_POST ["target"]."</strong>\') est inconnue.'})";
			}
		}
		catch (Exception $e)
		{
			$msg = $e->getMessage();
			echo "({'result': 'FAILED', 'message': 'Exception : ".$msg."'})";
		}
	}
}
?>