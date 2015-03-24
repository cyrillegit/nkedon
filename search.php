<?php
@require_once ("config/config.php");
// PDO connect *********
function connect() {
    return new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM t_produits WHERE nom_produit LIKE (:keyword) ORDER BY idt_produits ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
    // put in bold the written text
    $nom_produit = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['nom_produit']);
    // add new option
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['nom_produit']).'\')">'.$nom_produit.'</li>';
}
?>