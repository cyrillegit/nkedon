<?php
/* File: recapitulatif_inventaire.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer le recapitulatif de l'inventaire.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

	isset( $_POST ["id_recapitulatif"] ) ? $id_recapitulatif = $_POST ["id_recapitulatif"] : $id_recapitulatif = NULL;
	isset( $_POST ["id_user"] ) ? $id_user = $_POST ["id_user"] : $id_user = NULL;
	isset( $_POST ["ration"] ) ? $ration = addslashes(htmlspecialchars($_POST ["ration"])) : $ration = "";
	isset( $_POST ["dette_fournisseur"] ) ? $dette_fournisseur = addslashes(htmlspecialchars($_POST ["dette_fournisseur"])) : $dette_fournisseur = "";
	isset( $_POST ["depenses_diverses"] ) ? $depenses_diverses = addslashes(htmlspecialchars($_POST ["depenses_diverses"])) : $depenses_diverses = "";
	isset( $_POST ["avaries"] ) ? $avaries = addslashes(htmlspecialchars($_POST ["avaries"])) : $avaries = "";
	isset( $_POST ["credit_client"] ) ? $credit_client = addslashes(htmlspecialchars($_POST ["credit_client"])) : $credit_client = "";
	isset( $_POST ["fonds"] ) ? $fonds = addslashes(htmlspecialchars($_POST ["fonds"])) : $fonds = "";
	isset( $_POST ["capsules"] ) ? $capsules = addslashes(htmlspecialchars($_POST ["capsules"])) : $capsules = "";
	isset( $_POST ["recettes_percues"] ) ? $recettes_percues = addslashes(htmlspecialchars($_POST ["recettes_percues"])) : $recettes_percues = "";

if($id_recapitulatif != NULL)
{
	if( $id_user != NULL && 
		$ration != NULL && 
		$dette_fournisseur != NULL && 
		$depenses_diverses != NULL && 
		$avaries != NULL && 
		$credit_client != NULL &&
		$fonds != NULL && 
		$capsules != NULL && 
		$recettes_percues != NULL)
	{
		$ok = true;

		$ok &= isNumber($ration);
		$ok &= isNumber($dette_fournisseur);
		$ok &= isNumber($depenses_diverses);
		$ok &= isNumber($avaries);
		$ok &= isNumber($credit_client);
		$ok &= isNumber($fonds);
		$ok &= isNumber($capsules);
		$ok &= isNumber($recettes_percues);

		$date_inventaire = setLocalTime();

		$sql = "DELETE FROM t_recapitulatif";
		$ok &= $db->Execute ( $sql );

		$sql = "ALTER TABLE t_recapitulatif AUTO_INCREMENT = 1";
		$ok &= $db->Execute ( $sql );

		if( $ok )
		{
			$sql = "INSERT INTO t_recapitulatif
						(id_user,
						 ration,
						 dette_fournisseur,
						 depenses_diverses,
						 avaries,
						 credit_client,
						 fonds,
						 capsules,
						 recettes_percues,
						 date_inventaire)
			VALUES ('$id_user',
					'$ration',
					'$dette_fournisseur',
					'$depenses_diverses',
					'$avaries',
					'$credit_client',
					'$fonds',
					'$capsules',
					'$recettes_percues',
					'$date_inventaire')";

			if( $db->Execute ( $sql ) )
			{
			//	$db->commit ();

				$recap = $db->getAllRecapitulatif();
				$infos = $db->getAllAchatsVentesMois();

				$ventes_totales = 0;
				$achats_totales = 0;
				$montant_en_stock = 0;
				$benefice_brut = 0;
				$montant_charges_diverses = 0;
				$fonds_especes = 0;
				$patrimoine = 0;
				$benefice_net = 0;
				$ecart = 0;

				foreach ($infos as $info) 
				{
				    if($info["achat"] == NULL) $info["achat"] = 0;
				    $ventes_totales += ($info["stock_initial"] + $info["achat"] - $info["stock_physique"]) * $info["prix_vente"];
				    $achats_totales += $info["achat"] * $info["prix_achat"];
				    $montant_en_stock += $info["stock_physique"] * $info["prix_vente"];
				    $benefice_brut += ($info["prix_vente"] - $info["prix_achat"]) * ($info["stock_initial"] + $info["achat"] - $info["stock_physique"]);
				}

				$montant_charges_diverses = $recap["ration"] + $recap["dette_fournisseur"] + $recap["depenses_diverses"] + $recap["avaries"] + $recap["credit_client"];
			//	$fonds_especes = $recap["fonds"] - $recap["capsules"];
				$fonds_especes = $recap["fonds"];
				$patrimoine = $fonds_especes + $montant_en_stock + $recap["capsules"];
				$benefice_net = $benefice_brut - $montant_charges_diverses;
				$ecart = $ventes_totales - $recap["recettes_percues"] - $fonds_especes;
				$solde = $montant_charges_diverses - $ecart;
				$ration = $recap["ration"];
				$dette_fournisseur = $recap["dette_fournisseur"];
				$depenses_diverses = $recap["depenses_diverses"];
				$avaries = $recap["avaries"];
				$credit_client = $recap["credit_client"];
				$capsules = $recap["capsules"];

				$sql = " INSERT INTO t_historiques_syntheses(
									id_user,
									achats_mensuels,
									ventes_mensuelles,
									montant_stock,
									montant_charges_diverses,
									fonds_especes,
									patrimoine,
									recettes_percues,
									benefice_brut,
									benefice_net,
									ecart,
									date_inventaire,
									ration,
									dette_fournisseur,
									depenses_diverses,
									avaries,
									credit_client,
									capsules,
									solde
							)VALUES('$id_user',
									'$achats_totales',
									'$ventes_totales',
									'$montant_en_stock',
									'$montant_charges_diverses',
									'$fonds_especes',
									'$patrimoine',
									'$recettes_percues',
									'$benefice_brut',
									'$benefice_net',
									'$ecart',
									'$date_inventaire',
									'$ration',
									'$dette_fournisseur',
									'$depenses_diverses',
									'$avaries',
									'$credit_client',
									'$capsules',
									'$solde')";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue en base de données...'})";
				}
				
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue en base de données...'})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines valeurs de ce produit sont invalides...'})";
		}				
	}
	else
	{
		$db->rollBack();
		echo "({'result': 'Une erreur est survenue car certaines values du produit sont nulles... '})";
	}
/*
	//Mode mise à jour (post:update)
	else

	{
		if( $id_user != NULL && 
			$ration != NULL && 
			$dette_fournisseur != NULL && 
			$depenses_diverses != NULL && 
			$avaries != NULL && 
			$credit_client != NULL &&
			$fonds != NULL && 
			$capsules != NULL && 
			$recettes_percues != NULL)
		{
			$ok = true;

			$ok &= isNumber($ration);
			$ok &= isNumber($dette_fournisseur);
			$ok &= isNumber($depenses_diverses);
			$ok &= isNumber($avaries);
			$ok &= isNumber($credit_client);
			$ok &= isNumber($fonds);
			$ok &= isNumber($capsules);
			$ok &= isNumber($recettes_percues);

			$date_inventaire = setLocalTime();

			if($ok)
			{
				$sql = "UPDATE t_recapitulatif
						SET id_user = '$id_user',
							ration = '$ration',
							dette_fournisseur = '$dette_fournisseur',
							depenses_diverses = '$depenses_diverses',
							avaries = '$avaries',
							credit_client = '$credit_client',
							fonds = '$fonds',
							capsules = '$capsules',
							recettes_percues = '$recettes_percues',
							date_inventaire = '$date_inventaire'
						WHERE idt_recapitulatif = '$id_recapitulatif'";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour du recapitulatif de l \'inventaire en base de données... '})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour du recapitulatif de l \'inventaire en base de données, car les dates sont invalides... '})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour du recapitulatif de l \'inventaire en base de données car certaines valeurs sont nulles '})";
		}
	}
	//*/
}
else
{
	@header("Location: ../index.php");
}
?>