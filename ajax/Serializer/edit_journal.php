<?php
/* File: edit_journal.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier un journal.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

if(isset($_SESSION["id_journal"])) unset( $_SESSION["id_journal"] );

isset( $_POST ["id_journal"] ) ? $id = $_POST ["id_journal"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["commentaire"] ) ? $commentaire = addslashes(htmlspecialchars($_POST ["commentaire"])) : $commentaire = "";
    $id_user = $_SESSION["infoUser"]["idt_users"];
	//Mode création (post:insert)
	if( $id == 0 )
	{
        $ok = true;
        $okOperation = true;
        $id_user = $_SESSION["infoUser"]["idt_users"];
            // check unicity of the journal per day
//			$infoAllJournal = $db->getAllJournal();
//            $date_now = setLocalTime();
//			foreach ( $infoAllJournal as $info )
//			{
//				if( $info["date_journal"] == $date_now )
//				{
//					$ok &= false;
//				}
//			}

            // get the number of products of this bill
			$nombre_operation = $db->getNbOperationsJournal();

			if( $ok )
			{
                // get all products of this bill
				$infoAllOperationsJournal = $db->getAllOperationsJournal();
				$date_journal = setLocalTime();

				$sql = "INSERT INTO t_journal
							(date_journal,
							 commentaire,
							 id_user,
							 id_inventaire)
				VALUES ('$date_journal',
						'$commentaire',
						'$id_user',
						0)";

				if( $db->Execute ( $sql ) )
				{
					$id_journal = $db->lastInsertId();

					foreach ($infoAllOperationsJournal as $info)
					{
						$id_produit = $info["id_produit"];
						$quantite_vendue = $info["quantite_vendue"];
						$numero_operation = $info["numero_operation"];

						$sql1 = "INSERT INTO t_operations
									(numero_operation,
									 id_produit,
									 quantite_vendue,
							 		id_journal)
						VALUES ('$numero_operation',
						        '$id_produit',
								'$quantite_vendue',
								'$id_journal')";
						
						if($db->Execute($sql1))
						{
							$okOperation &= true;
						}
						else
						{
                            $okOperation &= false;
						}
					}

					if($okOperation)
					{
						$sql = "DELETE FROM t_produits_operations";

						if($db->Execute($sql))
						{
							$db->commit ();
							echo "({'result': 'SUCCESS'})";
						}
						else
						{
							$db->rollBack();
							echo "({'result': 'Une erreur est survenue lors de l \'insertion du journal en base de données.'})";
						}
					}
					else
					{
						$db->rollBack();
						echo "({'result': 'Une erreur est survenue lors de l \'insertion des operations du journal en base de données.'})";
					}
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion de la création du journal en base de données.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue. Impossible de réaliser plusieurs journaux pendant un même jour.'})";
			}
		
	}
	//Mode mise à jour (post:update)
	else
	{
        $ok = true;
        $okJournal = true;
        $date_journal = setLocalTime();
        $infoAllProduitsJournal = $db->getAllOperationsJournal();

			if( $ok )
			{
                $sql = "UPDATE t_journal
						SET date_journal = '$date_journal',
							commentaire = '$commentaire',
							id_user = '$id_user'
						WHERE idt_journal = '$id'";

				if( $db->Execute ( $sql ) )
				{
					$sql = "DELETE FROM t_operations WHERE id_journal = '$id' ";
					if( $db->Execute ( $sql ) )
					{
						foreach ($infoAllProduitsJournal as $info)
						{
							$id_produit = $info["id_produit"];
							$quantite_vendue = $info["quantite_vendue"];
							$numero_operation = $info["numero_operation"];

							$sql = "INSERT INTO t_operations
										(numero_operation,
										 id_produit,
										 quantite_vendue,
								 		 id_journal)
							VALUES ('$numero_operation',
							        '$id_produit',
									'$quantite_vendue',
									'$id')";

							if($db->Execute($sql))
							{
                                $okJournal &= true;
							}
							else
							{
                                $okJournal &= false;
							}
						}

						if( $okJournal )
						{
							$sql = "DELETE FROM t_produits_operations";

							if($db->Execute($sql))
							{
								$db->commit ();
								echo "({'result': 'SUCCESS'})";
							}
							else
							{
								$db->rollBack();
								echo "({'result': 'Une erreur est survenue lors de l \'insertion du journal en base de données.'})";
							}
						}
						else
						{
							$db->rollBack();
							echo "({'result': 'Une erreur est survenue lors de l \'insertion du journal en base de données.'})";
						}
					}
					else
					{
						$db->rollBack();
						echo "({'result': 'Une erreur est survenue lors de la mise à jour du journal en base de données.'})";
					}
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour du journal en base de données.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour du journal en base de données, car certaines valeurs de la facture sont invalides.'})";
			}
	}
}
else
{
	@header("Location: ../index.php");
}
?>