<?php
/**
	Fichier GetTableauFactures.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des factures présentes en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$_SESSION["load"] = true;
$db = new Database ();

$factures = $db->getAllFactures();
if( COUNT($factures) > 0 )
{
    foreach ($factures as &$facture) 
    {
        $produitsFacture = $db->getAllProduitsAssocToFactures($facture["idt_factures"]);
        $facture["produits_associes"] = $produitsFacture;
    }
}
else
{

}

?>
<script language="javascript">

function RefreshProduitsByFacture(id_facture)
{
    var param = "id_facture="+id_facture;
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/administration_magasin/GetProduitsByFacture.php",
            async   : false,
            data    : param,
            success : function (msg){}
    }).responseText;
//    $("#tableau_histo_syntheses").empty ().html (responseText);

//    UpdateTSorter ();
}

$(document).ready (function ()
{
	$(".edit_facture").each (function ()
	{
		$(this).click (function ()
		{
            id_facture = $(this).attr ("id_facture");
            numero_facture = $(this).attr ("numero_facture");
            id_fournisseur = $(this).attr ("id_fournisseur");
            nom_fournisseur = $(this).attr ("nom_fournisseur");
            date_facture = $(this).attr ("date_facture");
            RefreshProduitsByFacture( id_facture );
            document.location.href="administration_magasin.php?sub=edit_facture&id_facture="+id_facture+"&numero_facture="+numero_facture+"&id_fournisseur="+id_fournisseur+"&nom_fournisseur="+nom_fournisseur+"&date_facture="+date_facture;
		});
	});

    $(".links").each (function ()
    {
        $(this).click (function ()
        {
        //    var filename = $(this).attr("filename");
        //    document.location.href="download.php?filename="+filename;
            alert("Bientot disponible");
        });
    });
});
</script>
<style type="text/css">
.floatAndMarginLeft{
    float: left;
    margin-left: 10px;
}
</style>

<br/>
<?php
    if( count( $factures ) > 0)
    {
        foreach( $factures as $obj ) 
        {
            $prix_total_facture = 0;
?>
            <div style="width: 100%;">
                <form name="form_popup" id="form_popup" method="post">

                <style type="text/css">
                    .blocInfoBis
                    {
                        background-image: url("css/images/bg_bloc_alertes.png");
                        background-repeat: repeat;
                        border: 1px solid #313131;
                        padding: 5px 5px 5px;
                    }
                    .maindiv{ 
                        width:690px; 
                        margin:0 auto; 
                        padding:20px; 
                        background:#CCC;
                    }
                    .innerbg{ 
                        padding:6px; 
                        background:#FFF;
                    }
                    .links{ 
                        font-weight:bold; 
                        color:#ff0000; 
                        text-decoration:none; 
                        font-size:12px;
                    }
                    .blocTitreId{
                        color: white;
                        font-weight: bold;
                        width: 17%;
                    }
                    .blocTitre{
                        color: black;
                        font-weight: bold;
                        width: 17%;
                        margin-left: 10px;
                    }
                    .blocValue{
                        color: white;
                        font-weight: bold;
                        width: 17%;
                    }
                    .floatAndMarginLeft{
                        float: left;
                        margin-left: 10px;
                    }
                </style>

                    <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                        <tr>
                            <td>
                                <tr class="blocInfoBis">
                                    <td class="blocTitreId">Numéro facture : <br/><strong><?php  echo $obj["numero_facture"]; ?></strong></td>
                                    <td class="blocTitreId">Nom fournisseur : <br/><strong><?php  echo $obj["nom_fournisseur"]; ?></strong></td>  
                                    <td class="blocTitreId">Date facture : <br/><strong><?php  echo SQLDateToFrenchDate( $obj["date_facture"] ); ?></strong></td>
                                    <td class="blocTitreId">Enregistrée le : <br/><strong><?php  echo SQLDateTimeToFrenchDateTime( $obj["date_insertion_facture"] ); ?></strong></td>
                                    <td class="blocTitreId">Enregistrée par : <br/><strong><?php echo $_SESSION ["infoUser"]["nom_user"]." ".$_SESSION ["infoUser"]["prenom_user"];?></strong></td>
                                    <td style="float:right;">
                                        <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 2){?>                   
                                            <img src="css/images/edit.png" title="modifier la facture" border="0" class="edit_facture" style="cursor: pointer; margin: 1px;" id_facture="<?=$obj["idt_factures"];?>" numero_facture="<?=$obj["numero_facture"];?>" id_fournisseur="<?=$obj["id_fournisseur"];?>" nom_fournisseur="<?=$obj["nom_fournisseur"];?>" date_facture="<?=SQLDateToFrenchDate($obj["date_facture"]);?>"/>
                                            <a class="delete_link" style="margin: 1px;" title="supprimer la facture" url="delete.php?target=facture&id=<?=$obj["idt_factures"]; ?>"><img src="css/images/delete.png" border="0" /></a>
                                        <?php }?>
                                    </td>                                       
                                </tr>
                                <tr height="5px;"></tr>
                                <tr class="blocInfoBis">
                                    <td class="blocTitre">Nom produit </td>
                                    <td class="blocTitre">Quantité achétée </td>
                                    <td class="blocTitre">Prix d'achat (FCFA)</td>
                                    <td class="blocTitre">Prix total (FCFA)</td>
                                    <td class="blocTitre">Date fabrication </td>  
                                    <td class="blocTitre">Date péremption </strong></td>
                                </tr>
                                <tr height="5px;"></tr>
                                <?php
                                foreach ( $obj["produits_associes"] as $value ) 
                                {
                                    $prix_total_facture += $value["quantite_achat"] * $value["prix_achat"];
                                ?>
                                <tr class="blocInfoBis">
                                    <td class="blocValue"><?php  echo $value["nom_produit"]; ?></td>
                                    <td class="blocValue"><?php  echo $value["quantite_achat"]; ?></td>
                                    <td class="blocValue"><?php  echo number_format($value["prix_achat"], 2, ',', ' '); ?></td>
                                    <td class="blocValue"><?php  echo number_format($value["prix_achat"] * $value["quantite_achat"], 2, ',', ' '); ?></td>
                                    <td class="blocValue"><?php  echo SQLDateToFrenchDate( $value["date_fabrication"] ); ?></td>  
                                    <td class="blocValue"><?php  echo SQLDateToFrenchDate( $value["date_peremption"] ); ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                <tr>    
                                    <td align="left" valign="middle"><a class="links" filename="filename"><img src="css/images/arrow_down.png" alt="" width="16" height="16" /> Téléchargez la facture</a></td>
                                    <td class="blocTitre"></td>
                                    <td class="blocTitre"></td>
                                    <td class="blocTitre"></td>
                                    <td class="blocTitre">Prix total de la facture : </td>
                                    <td class="blocTitre"><?php echo number_format($prix_total_facture, 2, ',', ' ');?> FCFA</td>               
                                </tr>                                                                                                                                  
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <br />    
<?php
        }
    }
?>