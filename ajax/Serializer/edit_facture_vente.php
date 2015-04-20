<?php
/* File: edit_produit.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier une facture.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

if(isset($_SESSION["id_facture"])) unset( $_SESSION["id_facture"] );

isset( $_POST ["id_facture"] ) ? $id = $_POST ["id_facture"] : $id = NULL;

if( $id != NULL )
{
    isset( $_POST ["commentaire"] ) ? $commentaire = addslashes(htmlspecialchars($_POST ["commentaire"])) : $commentaire = "";
    isset( $_POST ["nom_client"] ) ? $nom_client = addslashes(htmlspecialchars($_POST ["nom_client"])) : $nom_client = "";
    $id_user = $_SESSION["infoUser"]["idt_users"];
	//Mode création (post:insert)
	if( $id == 0 )
	{
		$ok = true;
        $okFacture = true;
        $date_facture = setLocalTime();
        isset( $_COOKIE["ventes"] ) ? $numero_facture = $_COOKIE["ventes"]: $numero_facture = 1;
        setcookie("ventes", $numero_facture + 1 );

			if( $ok )
			{
                // get all products of this bill
				$infoAllProduitsVendus = $db->getAllProduitsVendus();

				$sql = "INSERT INTO t_factures_ventes
							(numero_facture,
							 date_facture,
							 commentaire,
							 id_inventaire,
							 id_user,
							 nom_client)
				VALUES ('$numero_facture',
						'$date_facture',
						'$commentaire',
						0,
						'$id_user',
						'$nom_client')";

				if( $db->Execute ( $sql ) )
				{
					$id_facture_vente = $db->lastInsertId();

					foreach ($infoAllProduitsVendus as $info)
					{
						$id_produit = $info["id_produit"];
						$quantite_vendue = $info["quantite_vendue"];

						$sql = "INSERT INTO t_ventes
									(id_produit,
									 id_facture_vente,
									 quantite_vendue)
						VALUES ('$id_produit',
								'$id_facture_vente',
								'$quantite_vendue')";
						
						if($db->Execute($sql))
						{
							$okFacture &= true;
						}
						else
						{
							$okFacture &= false;
						}
					}

					if($okFacture)
					{
						$sql = "DELETE FROM t_produits_ventes";

						if($db->Execute($sql))
						{
							$db->commit ();
							echo "({'result': 'SUCCESS'})";
						}
						else
						{
							$db->rollBack();
							echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
						}
					}
					else
					{
						$db->rollBack();
						echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
					}
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car la date est invalide ou il existe déja une facture avec le même numéro et le même fournisseur.'})";
			}
		
	}
	//Mode mise à jour (post:update)
	else
	{
        $ok = true;
        $okFacture = true;
        $date_facture = setLocalTime();
        $numero_facture = "0";
        $infoAllProduitsVendus = $db->getAllProduitsVendus();

			if( $ok )
			{
				$sql = "UPDATE t_factures_ventes
						SET numero_facture = '$numero_facture',
							date_facture = '$date_facture',
							commentaire = '$commentaire',
							id_user = '$id_user',
							nom_client = '$nom_client'
						WHERE idt_factures_ventes = '$id'";

					if( $db->Execute ( $sql ) )
					{
                        $sql = "DELETE FROM t_ventes WHERE id_facture_vente = '$id'";
                        if( $db->Execute ( $sql ) )
                        {
                            foreach ($infoAllProduitsVendus as $info)
                            {
                                $id_produit = $info["id_produit"];
                                $quantite_vendue = $info["quantite_vendue"];

                                $sql = "INSERT INTO t_ventes
										(id_produit,
										 id_facture_vente,
										 quantite_vendue)
                                    VALUES ('$id_produit',
                                            '$id',
                                            '$quantite_vendue')";

                                if($db->Execute($sql))
                                {
                                    $okFacture &= true;
                                }
                                else
                                {
                                    $okFacture &= false;
                                }
                            }

                            if( $okFacture )
                            {
                                $sql = "DELETE FROM t_produits_ventes";

                                if($db->Execute($sql))
                                {
                                    $db->commit ();
                                    echo "({'result': 'SUCCESS'})";
                                }
                                else
                                {
                                    $db->rollBack();
                                    echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
                                }
                            }
                            else
                            {
                                $db->rollBack();
                                echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
                            }
                        }
                        else
                        {
                            $db->rollBack();
                            echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données.'})";
                        }
					}
					else
					{
						$db->rollBack();
						echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données.'})";
					}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données, car certaines valeurs de la facture sont invalides.'})";
			}
	}
}
else
{
	@header("Location: ../index.php");
}
?>