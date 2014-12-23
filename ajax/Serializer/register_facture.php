<?php
/* File: register_facture.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer une facture.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["numero_facture"] ) ? $numero_facture = addslashes(htmlspecialchars($_POST ["numero_facture"])) : $numero_facture = "";
isset( $_POST ["id_fournisseur"] ) ? $id_fournisseur = addslashes(htmlspecialchars($_POST ["id_fournisseur"])) : $id_fournisseur = "";
isset( $_POST ["date_facture"] ) ? $date_facture = addslashes(htmlspecialchars($_POST ["date_facture"])) : $date_facture = "";

if( $numero_facture != NULL && $id_fournisseur != NULL && $date_facture != NULL)
{
	$nombre_produit = $db->getNbProduitsDistintsAchetes();
/*	$infoAllProduitsAchetes = $db->getAllProduitsAchetes();
	$date_facture = FrenchDateToSQLDate($date_facture);
	$date_insertion_facture = setLocalTime();
	$ok = true;
//*/
	print_r($nombre_produit);
	$sql = "INSERT INTO t_factures
					(numero_facture,
					 nombre_produit,
					 id_fournisseur,
					 date_facture,
					 date_insertion_facture)
		VALUES ('$numero_facture',
				'$nombre_produit',
				'$id_fournisseur',
				'$date_facture',
				'$date_insertion_facture')";

	echo "SUCCESS";
	if( $db->Execute ( $sql ) )
	{
		$id_facture = getLastInsertedId();
/*
		foreach ($infoAllProduitsAchetes as $info) 
		{

			$id_produit = $info["id_produit"];
			$quantite_achat = $info["quantite_achat"];

			$sql = "INSERT INTO t_achats
						(id_produit,
						 id_facture,
						 quantite_achat)
			VALUES ('$id_produit',
					'$id_facture',
					'$quantite_achat')";
			
			if($db->Execute($sql))
			{
				$ok &= true;
			}
			else
			{
				$ok &= false;
			}
			echo "id_produit: ".$id_produit;
		}
//*/
		if($ok)
		{
		//	$db->commit ();
		//	echo "({'result': 'SUCCESS'})";
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données...'})";
		}

	}
	else
	{
		$db->rollBack();
		echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données...'})";
	}
}
else
{
	@header("Location: ../index.php");
}
?>