<?php
/* File: edit_fournisseur.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier un fournisseur.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_fournisseur"] ) ? $id = $_POST ["id_fournisseur"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["nom_fournisseur"] ) ? $nom_fournisseur = strtoupper(addslashes(htmlspecialchars($_POST ["nom_fournisseur"]))) : $nom_fournisseur = "";
	isset( $_POST ["adresse_fournisseur"] ) ? $adresse_fournisseur = addslashes(htmlspecialchars($_POST ["adresse_fournisseur"])) : $adresse_fournisseur = "";
	isset( $_POST ["telephone_fournisseur"] ) ? $telephone_fournisseur = addslashes(htmlspecialchars($_POST ["telephone_fournisseur"])) : $telephone_fournisseur = "";

	//Mode création (post:insert)
	if( $id == 0 )
	{
		if( $nom_fournisseur != NULL && $adresse_fournisseur != NULL && $telephone_fournisseur != NULL)
		{
        //    print_r($nom_fournisseur);
			$ok = true;
			$infoAllFournisseurs = $db->getAllFournisseurs();
			foreach ($infoAllFournisseurs as $infoAllFournisseur)
			{
				if($infoAllFournisseur["nom_fournisseur"] == $nom_fournisseur)
				{
					$ok &=false;
				}
			}

			if(!validateNumeroTelephone($telephone_fournisseur)){
				$ok &=false;
			}
			else
			{
				$telephone_fournisseur = setNumeroTelephone($telephone_fournisseur);
			}

			$date_insertion = setLocalTime();
			$sql = "INSERT INTO t_fournisseurs
							(nom_fournisseur,
							 adresse_fournisseur,
							 telephone_fournisseur,
							 date_insertion)
				VALUES ('$nom_fournisseur',
						'$adresse_fournisseur',
						'$telephone_fournisseur',
						'$date_insertion')";

			if( $ok )
			{
				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion du fournisseur en base de données...'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car le format du numéro de téléphone n \'est pas correct ou/et ce fournisseur existe déjà en base de données...'})";
			}				
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values du fournisseur sont nulles... '})";
		}
		
	}
	//Mode mise à jour (post:update)
	else
	{
		if( $nom_fournisseur != NULL && $adresse_fournisseur != NULL && $telephone_fournisseur != NULL )
		{

			$ok = true;
			if(!validateNumeroTelephone($telephone_fournisseur))
			{
				$ok = false;
			}
			else
			{
				$telephone_fournisseur = setNumeroTelephone($telephone_fournisseur);
			}

			$sql = "UPDATE t_fournisseurs
					SET nom_fournisseur = '$nom_fournisseur',
						adresse_fournisseur = '$adresse_fournisseur',
						telephone_fournisseur = '$telephone_fournisseur'
					WHERE idt_fournisseurs = $id";

			if($ok){
				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour du fournisseur en base de données... '})";
				}
			}else{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour du fournisseur en base de données, car le numéro de téléphone est invalide... '})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour du fournisseur en base de données car certaines valeurs sont nulles '})";
		}
	}
}
else
{
	@header("Location: ../index.php");
}
?>