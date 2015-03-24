<?php
/**
	Fichier de sérialisation
	------------------------
	Ce fichier permet d'enregistrer des informations dans la base de données.
	
	Auteur : Cyrille MOFFO
	Copyright : Nemand Softwares. 2013-2014.
	Tous droits réservés.
*/
//@require_once ("../config/config.php");
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
			else if ($_POST ["target"] == "factures")
			{
				include ("Serializer/edit_facture.php");
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
			else if ($_POST ["target"] == "recapitulatif_inventaire")
			{
				include ("Serializer/recapitulatif_inventaire.php");
			}
			else if ($_POST ["target"] == "produits_facture")
			{
				include ("Serializer/produits_facture.php");
			}
            else if ($_POST ["target"] == "operations_journal")
            {
//                include ("Serializer/operations_journal.php");

                isset( $_POST ["id_operation"] ) ? $id = $_POST ["id_operation"] : $id = NULL;
                if( $id != NULL )
                {
                    isset( $_POST ["nom_produit_search"] ) ? $nom_produit = strtoupper(addslashes(htmlspecialchars($_POST ["nom_produit_search"]))) : $nom_produit = "";
                    isset( $_POST ["quantite_vendue"] ) ? $quantite_vendue = $_POST ["quantite_vendue"] : $quantite_vendue = "";

                    //Mode création (post:insert)
                    if( $id == 0 )
                    {
                        if( $nom_produit != NULL && $quantite_vendue != NULL )
                        {
                            $ok = true;
                            $produit = $db->getInfoProduitByNom( $nom_produit );
                            $id_produit = $produit["idt_produits"];

                            if($id_produit != NULL)
                            {
                                $ok &= true;
                            }
                            $ok &= isNumber($quantite_vendue);

                            $numero_operation = getDateWithUnderscrore(setLocalTime());

                            $sql = "INSERT INTO t_produits_operations
                                                (id_produit,
                                                 quantite_vendue,
                                                 numero_operation)
                                    VALUES ('$id_produit',
                                            '$quantite_vendue',
                                            '$numero_operation')";

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
                                    echo "({'result': 'Une erreur est survenue lors de l \'insertion du produit en base de données...'})";
                                }
                            }
                            else
                            {
                                $db->rollBack();
                                echo "({'result': 'Une erreur est survenue lors de l \'insertion du produit en base de données...'})";
                            }
                        }
                        else
                        {
                            $db->rollBack();
                            echo "({'result': 'Une erreur est survenue car certaines values du produit sont nulles... '})";
                        }

                    }
                    //Mode mise à jour (post:update)
                    else
                    {
                        if( $nom_produit != NULL && $quantite_vendue != NULL )
                        {

                            $ok = true;
                            $produit = $db->getInfoProduitByNom( $nom_produit );
                            $numero_operation = "";

                            $ok &= isNumber($quantite_vendue);

                            $id_produit = $produit["idt_produits"];

                            $sql = "UPDATE t_produits_operations
                                    SET id_produit = '$id_produit',
                                        quantite_vendue = '$quantite_vendue',
                                        numero_operation = '$numero_operation'
                                    WHERE idt_produits_factures = $id";

                            if($ok){
                                if( $db->Execute ( $sql ) )
                                {
                                    $db->commit ();
                                    echo "({'result': 'SUCCESS'})";
                                }
                                else
                                {
                                    $db->rollBack();
                                    echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données... '})";
                                }
                            }else{
                                $db->rollBack();
                                echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données... '})";
                            }
                        }
                        else
                        {
                            $db->rollBack();
                            echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données car certaines valeurs sont nulles '})";
                        }
                    }
                }
                else
                {
                    @header("Location: ../index.php");
                }
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