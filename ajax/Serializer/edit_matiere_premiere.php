<?php
/* File: edit_produit.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier une matiere premiere.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_matiere_premiere"] ) ? $id = $_POST ["id_matiere_premiere"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["nom_matiere_premiere"] ) ? $nom_matiere_premiere = strtoupper(addslashes(htmlspecialchars($_POST ["nom_matiere_premiere"]))) : $nom_matiere_premiere = "";
	isset( $_POST ["prix_achat"] ) ? $prix_achat = addslashes(htmlspecialchars($_POST ["prix_achat"])) : $prix_achat = "";
	isset( $_POST ["quantite"] ) ? $quantite = addslashes(htmlspecialchars($_POST ["quantite"])) : $quantite = "";

	//Mode création (post:insert)
	if( $id == 0 ) {
        if ($nom_matiere_premiere != NULL && $prix_achat != NULL && $quantite != NULL) {
            $nom_matiere_premiere = trim(preg_replace('/\s+/', ' ', $nom_matiere_premiere));

            $ok = true;
            $infosMatieresPremieres = $db->getAllMatieresPremieres();
            foreach ($infosMatieresPremieres as $infoProduit) {
                if ($infoProduit["nom_matiere_premiere"] == $nom_matiere_premiere) {
                    $ok &= false;
                }
            }

            if ($ok) {

                $ok &= isNumber($prix_achat);
                $ok &= isNumber($quantite);
                $date_matiere_premiere = setLocalTime();

                if ($ok) {
                    $sql = "INSERT INTO t_matieres_premieres
                                    (nom_matiere_premiere,
                                     prix_achat,
                                     quantite,
                                     date_matiere_premiere)
                        VALUES ('$nom_matiere_premiere',
                                $prix_achat,
                                $quantite,
                                '$date_matiere_premiere')";

                    if ($db->Execute($sql)) {
                        $db->commit();
                        echo "({'result': 'SUCCESS'})";
                    } else {
                        $db->rollBack();
                        echo "({'result': 'Une erreur est survenue lors de l \'insertion de la matiere premiere en base de données...'})";
                    }
                } else {
                    $db->rollBack();
                    echo "({'result': 'Une erreur est survenue car certaines valeurs de la matiere premiere sont invalides...'})";
                }

            }else{
                $db->rollBack();
                echo "({'result': 'Une erreur est survenue car la designation de la matiere premiere existe deja... '})";
            }

        } else {
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values de la matiere premiere sont nulles... '})";
		}
		
	}
	//Mode mise à jour (post:update)
	else
	{
		if( $nom_matiere_premiere != NULL && $prix_achat != NULL && $quantite != NULL )
		{
			str_replace( "  ", " ", trim( $nom_matiere_premiere ));
			$ok = true;

			$ok &= isNumber($prix_achat);
			$ok &= isNumber($quantite);
            $date_matiere_premiere = setLocalTime();

			if($ok)
			{
				$sql = "UPDATE t_matieres_premieres
						SET nom_matiere_premiere = '$nom_matiere_premiere',
							prix_achat = '$prix_achat',
							quantite = '$quantite',
							date_matiere_premiere = '$date_matiere_premiere'
						WHERE idt_matieres_premieres = $id";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour de la matiere premiere en base de données... '})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour de la matiere premiere en base de données, car les dates sont invalides... '})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour de la matiere premiere en base de données car certaines valeurs sont nulles '})";
		}
	}
}
else
{
	@header("Location: ../index.php");
}
?>