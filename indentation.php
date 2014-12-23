<?php
$d1 = "2013-01-01 08:00:20";
$d2 = "2013-02-01 18:30:00";
$dc1 = new DateTime($d1);
$dc2 = new DateTime($d2);
$diff = $dc1->diff($dc2);
$nb_jours = $diff->format('%a');
$nb_heures = $diff->format('%H');
$nb_minutes = $diff->format('%I');
$nb_secondes = $diff->format('%S');
$date_diff = "";
if( $nb_jours != 0 )
	$date_diff .= $nb_jours . " jours<br/>";
if( $nb_heures != 0 )
	$date_diff .= $nb_heures . " heures<br/>";
if( $nb_minutes != 0 )
	$date_diff .= $nb_minutes . " minutes<br/>";
if( $nb_secondes != 0)
	$date_diff .= $nb_secondes . " secondes.";
echo $date_diff;
?>