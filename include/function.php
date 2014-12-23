<?php
/*
	if (!defined("ROOT_FOLDER"))
	{
		define ("ROOT_FOLDER", Configuration::getValue ('path_root'));
	}
	
	/**
	 * Fonction throw_error
	 * --------------------
	 * Erreur catchée
	 *
	 * @param Array $str
	 */
	
	function throw_error($message,$errno=null,$critical=true) {
		$err = new Error($message,debug_backtrace());
		$err->sendMail();
		if($message != '** NO CRITICAL MESSAGE **'){
			if($critical === true) 
				$err->displayError();
		}
	}
	
	/**
	 * Fonction MakeFrenchDate
	 * -----------------------
	 * Cette fonction remplacera les jours anglais en jours français.
	 */
	
	function MakeFrenchDate ($date)
	{
		$new_date = $date;
		$new_date = str_replace ("Monday", "Lundi", $new_date);
		$new_date = str_replace ("Tuesday", "Mardi", $new_date);
		$new_date = str_replace ("Wednesday", "Mercredi", $new_date);
		$new_date = str_replace ("Thursday", "Jeudi", $new_date);
		$new_date = str_replace ("Friday", "Vendredi", $new_date);
		$new_date = str_replace ("Saturday", "Samedi", $new_date);
		$new_date = str_replace ("Sunday", "Dimanche", $new_date);
		return $new_date;
	}
	
	/**
	 * Fonction FixHtmlAccents
	 * -----------------------
	 * Cette fonction remplacera les accents en accents HTML pour le tableau donné en paramètre.
	 */
	
	function FixHtmlAccents (&$arr)
	{
		foreach ($arr as &$obj)
		{
			$buffer = utf8_decode ($obj);
			
			$buffer = str_replace ("î", "&icirc;", $buffer);
			$buffer = str_replace ("é", "&eacute;", $buffer);
			$buffer = str_replace ("è", "&egrave;", $buffer);
			$buffer = str_replace ("à", "&agrave;", $buffer);
			$buffer = str_replace ("ô", "&ocirc;", $buffer);
			
			$obj = $buffer;
		}
	}
	
	/**
	 * Fonction FixHtmlAccentsString
	 * -----------------------------
	 * Cette fonction remplacera les accents en accents HTML pour la chîne de caractère donnée en paramètre.
	 */

	function FixHtmlAccentsString (&$buffer)
	{
		$buffer = utf8_decode ($buffer);
		
		$buffer = str_replace ("î", "&icirc;", $buffer);
		$buffer = str_replace ("é", "&eacute;", $buffer);
		$buffer = str_replace ("è", "&egrave;", $buffer);
		$buffer = str_replace ("à", "&agrave;", $buffer);
		$buffer = str_replace ("ô", "&ocirc;", $buffer);
	}
	
	/**
	 * Fonction GetElapsedTime
	 * -----------------------
	 * Récupère un temps écoulé entre 2 dates.
	 *
	 * Ajout de la gestion du pluriel.
	 */
	function GetElapsedTime ($heureDebut, $heureFin)
	{
		if( $heureDebut != NULL && $heureDebut != "0000-00-00 00:00:00" )
		{
			$heure_debut = mktime (date ("H", strtotime ($heureDebut)), date ("i", strtotime ($heureDebut)), date ("s", strtotime ($heureDebut)));
			$heure_fin = mktime (date ("H", strtotime ($heureFin)), date ("i", strtotime ($heureFin)), date ("s", strtotime ($heureFin)));
			$dateDiff    = $heure_fin - $heure_debut;
			$fullDays    = floor($dateDiff/(60*60*24));
			$fullHours   = floor(($dateDiff-($fullDays*60*60*24))/(60*60));
			$fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);
			if ($fullHours > 0)
			{
				if ($fullMinutes>0)
				{
					$pluriel = ($fullHours > 1 ? "s" : "");
					return "$fullHours hr$pluriel $fullMinutes min.";
				}
				else
				{
					$pluriel = ($fullHours > 1 ? "s" : "");
					return "$fullHours hr$pluriel.";
				}
			}
			else
				return "$fullMinutes min.";
		}
		else
			return "";
	}

	function getElaspedDateTime ( $timeStart, $timeEnd )
	{
		if( $timeStart != NULL && $timeStart != "0000-00-00 00:00:00" )
		{
		    $time = strtotime( $timeEnd ) - strtotime( $timeStart ); // to get the time since that moment

		    $tokens = array (
		        31536000 => 'an',
		        2592000 => 'mois',
		        604800 => 'semaine',
		        86400 => 'jour',
		        3600 => 'heure',
		        60 => 'minute',
		        1 => 'seconde'
		    );

		    foreach ($tokens as $unit => $text) 
		    {
		        if ($time < $unit) continue;
		        $numberOfUnits = floor($time / $unit);
		        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		    }
		}
		else
			return "";

	}
	
	function get_date_diff($start, $end="NOW")
	{
		$sdate = strtotime($start);
		$edate = strtotime($end);

		$time = $edate - $sdate;
		if($time>=0 && $time<=59) {
				// Seconds
				$timeshift = $time.' secondes ';

		} elseif($time>=60 && $time<=3599) {
				// Minutes + Seconds
				$pmin = ($edate - $sdate) / 60;
				$premin = explode('.', $pmin);
			   
				$presec = $pmin-$premin[0];
				$sec = $presec*60;
			   
				$timeshift = $premin[0].' min '.round($sec,0).' sec ';

		} elseif($time>=3600 && $time<=86399) {
				// Hours + Minutes
				$phour = ($edate - $sdate) / 3600;
				$prehour = explode('.',$phour);
			   
				$premin = $phour-$prehour[0];
				$min = explode('.',$premin*60);
			   
				$presec = '0.'.$min[1];
				$sec = $presec*60;

				$timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

		} elseif($time>=86400) {
				// Days + Hours + Minutes
				$pday = ($edate - $sdate) / 86400;
				$preday = explode('.',$pday);

				$phour = $pday-$preday[0];
				$prehour = explode('.',$phour*24);

				$premin = ($phour*24)-$prehour[0];
				$min = explode('.',$premin*60);
			   
				$presec = '0.'.$min[1];
				$sec = $presec*60;
			   
				$timeshift = $preday[0].' jours '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

		}
		return $timeshift;
	}
	
	/**
	 * Fonction var_dump_pre
	 * ---------------------
	 * Dump d'un tableau ou d'une structure.
	 *
	 * @param Array $str
	 */
	function var_dump_pre($str)
	{
		echo "<pre class=\"debug\">";
		var_dump($str);
		echo "</pre>";
	}
	
	/**
	 * Fonction expiredSession
	 * -----------------------
	 * Fonction de v&eacute;rification que la session ne soit pas expir&eacute;e.
	 * Si la session est expir&eacute;e on affiche un message d'erreur.
	 *
	 * @param template $tpl
	 */
	function expiredSession($tpl)
	{
		if ($tpl->GetWidgetName () == "")
			$tpl->display('common/expired.tpl');
		else
		{
			/**
				Pour sortir correctement du site, suite à une session expirée, on doit impérativement
				réinitialiser le pointeur template uniquement si un nom de widget a été utilisé.
			*/
			$template = new Templates ();
			$template->display('common/expired.tpl');
		}
	}

	
	/**
	 * Fonction IsHoliday
	 * ------------------
	 * Retourne 1 si le jour est férié, 0 sinon.
	 */
	function IsHoliday($timestamp)
	{
		$jour = date("d", $timestamp);
		$mois = date("m", $timestamp);
		$annee = date("Y", $timestamp);
		
		$EstFerie = 0;
		// dates fériées fixes
		if($jour == 1 && $mois == 1) $EstFerie = 1; // 1er janvier
		if($jour == 1 && $mois == 5) $EstFerie = 1; // 1er mai
		if($jour == 8 && $mois == 5) $EstFerie = 1; // 8 mai
		if($jour == 14 && $mois == 7) $EstFerie = 1; // 14 juillet
		if($jour == 15 && $mois == 8) $EstFerie = 1; // 15 aout
		if($jour == 1 && $mois == 11) $EstFerie = 1; // 1 novembre
		if($jour == 11 && $mois == 11) $EstFerie = 1; // 11 novembre
		if($jour == 25 && $mois == 12) $EstFerie = 1; // 25 décembre
		// fetes religieuses mobiles
		$pak = easter_date($annee);
		$jp = date("d", $pak);
		$mp = date("m", $pak);
		if($jp == $jour && $mp == $mois){ $EstFerie = 1;} // Pâques
		$lpk = mktime(date("H", $pak), date("i", $pak), date("s", $pak), date("m", $pak)
		, date("d", $pak) +1, date("Y", $pak) );
		$jp = date("d", $lpk);
		$mp = date("m", $lpk);
		if($jp == $jour && $mp == $mois){ $EstFerie = 1; }// Lundi de Pâques
		$asc = mktime(date("H", $pak), date("i", $pak), date("s", $pak), date("m", $pak)
		, date("d", $pak) + 39, date("Y", $pak) );
		$jp = date("d", $asc);
		$mp = date("m", $asc);
		if($jp == $jour && $mp == $mois){ $EstFerie = 1;}//ascension
		$pe = mktime(date("H", $pak), date("i", $pak), date("s", $pak), date("m", $pak),
		 date("d", $pak) + 49, date("Y", $pak) );
		$jp = date("d", $pe);
		$mp = date("m", $pe);
		if($jp == $jour && $mp == $mois) {$EstFerie = 1;}// Pentecôte
		$lp = mktime(date("H", $asc), date("i", $pak), date("s", $pak), date("m", $pak),
		 date("d", $pak) + 50, date("Y", $pak) );
		$jp = date("d", $lp);
		$mp = date("m", $lp);
		if($jp == $jour && $mp == $mois) {$EstFerie = 1;}// lundi Pentecôte
		// Samedis et dimanches
		/*$jour_sem = jddayofweek(unixtojd($timestamp));
		if ($jour_sem == 0) 
		{
			$EstFerie = 1;
		}*/
		// ces deux lignes au dessus sont à retirer si vous ne désirez pas faire
		// apparaitre les
		// samedis et dimanches comme fériés.
		return $EstFerie;
	}
	
	
	/**
	 * Fonction FrenchDateToSQLDate
	 * ----------------------------
	 * Transforme la date 15/11/2010 en 2010-11-15
	 */
	function FrenchDateToSQLDate ($date)
	{
		if( $date != "")
		{
			$arr = explode ("/", $date);
			$new_date = $arr [2]."-".$arr [1]."-".$arr [0];
		}
		else
		{
			$new_date = "";
		}
		return $new_date;
	}

	/**
	 * Fonction SQLDateToFrenchDate
	 * ----------------------------
	 * Transforme la date 2010-11-15 en 15/11/2010
	 */
	function SQLDateToFrenchDate ($date)
	{
		$date_split = explode(" ", $date);

		if($date_split[0] != "0000-00-00")
		{
			$arr = explode ("-", $date_split[0]);
			$new_date = $arr [2]."/".$arr [1]."/".$arr [0];
		}
		else
		{
			$new_date = "";
		}
		return $new_date;
	}

	/**
	 * Fonction SQLDateToFrenchDate
	 * ----------------------------
	 * Transforme la date 2010-11-15 12:25:58 en 15/11/2010 12:25:58
	 */
	function SQLDateTimeToFrenchDateTime ($date)
	{
		$date_split = explode(" ", $date);

		if($date_split[0] != "0000-00-00")
		{
			$arr = explode ("-", $date_split[0]);
			$new_date = $arr [2]."/".$arr [1]."/".$arr [0]." ".$date_split[1];
		}
		else
		{
			$new_date = "";
		}
		return $new_date;
	}	
	//*/
	/**
	 * Encodes HTML safely for UTF-8. Use instead of htmlentities.
	 * Permet de coder correctement les caractères accentués.
	 *
	 * @param string $var
	 * @return string
	 */

	function html_encode($var)
	{
		return htmlentities($var, ENT_QUOTES, 'UTF-8') ;
	}
	
	/**
	 * Encodes HTML safely for UTF-8. Use instead of htmlentities.
	 * Permet de coder correctement les caractères accentués.
	 *
	 * @param string $fileName
	 * @param array $variables
	 * @return string
	 */
	function GetHtmlContent ($fileName, $variables)
	{
		$contents = file_get_contents ($fileName);
		foreach ($variables as $varName => $varValue)
		{
			FixHtmlAccentsString ($varValue);
			$contents = str_replace ("\${".$varName."}", $varValue, $contents);
		}
		return $contents;
	}
	
	/**
		Fonction de calcul des nombres de semaines depuis une date selon
		le mois et l'année passés en paramètre.
	*/
	//*
	function getNbWeeks($year, $month)
	{
		$nday = date('t', mktime(0, 0, 0, $month + 1, 0, $year));
		$n = ($nday % 7 != 0 ? floor($nday/7) +1 : floor($nday/7));
		return ((date('N', mktime(0,0,0, $month, 1, $year))) == 7 ? $n + 1 : $n);
	}
	
	/**
		Fonction de calcul du nombre de jours ouvrés entre 2 dates.
	*/
	//*
	function GetNbOpenedDays ($date1, $date2)
	{
		$fromDateTS = strtotime($date1);
		$toDateTS = strtotime($date2);
		
		$nbDays = 0;
		for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) 
		{
			// use date() and $currentDateTS to format the dates in between
			$currentDateStr = date("Y-m-d",$currentDateTS);
			
			if (!IsHoliday ($currentDateTS))
			{
				// 6 = samedi, 7 = dimanche.
				if ( (date("N", $currentDateTS) != 6) && (date("N", $currentDateTS) != 7) )
				{
					$nbDays++;
				}
			}
		}
		return $nbDays;
	}
	
	/**
		Fonction de calcul du tout dernier jour d'un mois.
	*/
	//*
	function getlastdayofmonth($month, $year) 
	{
		for ($day = 28; $day <= 32; $day++) 
		{
			if (!checkdate($month, $day, $year)) return $day-1;
		}
	}
	
	/**
		Fonction de calcul de la liste des jours du mois. On renvoie sous le format suivant :
		- date : date au format Y-m-d
		- day : numéro du jour (1, 2, 3, 4...)
	*/
	//*
	function get_month_year_days ($month, $year)
	{
		$values = array ();
		$fromDateTS = strtotime($year . "-" . $month . "-01");
		$toDateTS = strtotime($year . "-" . $month . "-" . getlastdayofmonth ($month, $year));
		
		$day = 1;
		for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) 
		{
			$currentDateStr = date("Y-m-d",$currentDateTS);
			
			$values [] = array (
				"date"		=> $currentDateStr,
				"day"		=> $day
			);
			$day++;
		}
		return $values;
	}
	
	/**
		Fonction de tri des différentes alertes.
	*/
	//*
	function ArrayDataCompare($a, $b)
	{
		if ($a["timestamp"] == $b["timestamp"]) {
			return 0;
		}
		return ($a["timestamp"] >= $b["timestamp"]) ? -1 : 1;
	}
	
	function GetHeure ($heure)
	{ 
		$val = explode (":", $heure);
		
		return $val [0];
	}
	
	function GetMinute ($heure)
	{
		$val = explode (":", $heure);
		
		return $val [1];
	}
	
	function Time2NbHeures ($time)
	{
		if ($time == "") return "";
		else
		{
			$arr = explode (":", strftime ("%H:%M", strtotime ($time)));
			
			$heures = $arr [0];
			$minutes = $arr [1];
			$nb = 0;
			
			$nb += $heures * 60;
			$nb += $minutes;
			
			$nb /= 60;
			return round ($nb, 2);
			//return number_format ($nb, "2");
		}
	}
	
	function NbHeures2Time ($string)
	{
		$nbHeures = intval($string);
		$nbMinutes = intval (($string - intval($string)) * 60);
		
		return ($nbHeures > 9 ? "0" . $nbHeures : $nbHeures) . ":" . ($nbMinutes > 9 ? "0" . $nbMinutes : $nbMinutes);
	}
	
	/**
	 * Encodes HTML safely for UTF-8. Use instead of htmlentities.
	 * Permet de coder correctement les caractères accentués.
	 *
	 * @param string $var
	 * @return string
	 */
	//*
	function swap (&$ary,$element1,$element2)
	{
		$temp = $ary[$element1];
		$ary[$element1] = $ary[$element2];
		$ary[$element2] = $temp;
	}
	
	
	/**
	 * Encodes HTML safely for UTF-8. Use instead of htmlentities.
	 * Permet de coder correctement les caractères accentués.
	 *
	 * @param string $var
	 * @return string
	 */
	//*
	function Ellipsize ($text, $max = 70)
	{
		if (strlen ($text) >= $max)
		{
			return substr($text, 0, $max - 3) . "...";
		}
		else
		{
			return $text;
		}
	}
	
	function getFrenchDayName($date) {
 
		$jour_semaine = array(1=>"Lundi", 2=>"Mardi", 3=>"Mercredi", 4=>"Jeudi", 5=>"Vendredi", 6=>"Samedi", 7=>"Dimanche");
		 
		list($annee, $mois, $jour) = explode ("-", $date);
		 
		$timestamp = mktime(0,0,0, date($mois), date($jour), date($annee));
		$njour = date("N",$timestamp);
		 
		return $jour_semaine[$njour];
	 
	}
	/**
	* Retourne la date et l'heure presente de Douala
	*/
	//*
	function setLocalTime(){
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('UTC'));
		$date->setTimezone(new DateTimeZone('Africa/Douala'));
		return $date->format('Y-m-d H:i:s');
	}
	
	/**
	* retourne la date time reellement inserée en DB
	*/
	//*
	function getInsertedDateTime($date)
	{
		$dateTime = new DateTime($date);
		$convertedDateTime = $dateTime->format('d/m/Y H:i:s');
		if( $convertedDateTime == "01/01/1970 00:00:00"){
			return "";
		}else{
			return $convertedDateTime;
		}
	}

	/**
	* retourne la date reellement inserée en DB
	*/
	//*
	function getInsertedDate($date){
		$dateTime = new DateTime($date);
		$convertedDate = $dateTime->format('d/m/Y');
		if( $convertedDate == "01/01/1970 00:00:00"){
			return "";
		}else{
			return $convertedDate;
		}
	}
	
	/**
	* retourne la date par defaut
	*/
	//*	
	function setDefaultDate()
	{
		return "1970-01-01";
	}

	/**
	* retourne true si le string est sous forme de format date time 
	*/
	//*
	function validateDateTime($dateTime)
	{
		$dateTime = htmlspecialchars($dateTime);
		$dateRegex = "/^(([0-9]|[12]\d|3[0-1])\/)?([1-9]|1[0-2])\/(19|20)\d{2}$/";
		if(preg_match($dateRegex, $dateTime)){
			return true;
		}else{
			return false;
		}
	}

	/**
	* retourne true si le string est sous forme de format date
	*/
	//*
	function validateDate($date)
	{
		$date = htmlspecialchars($date);
		$dateRegex = "/^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/";
		if(preg_match($dateRegex, $date))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	*	retourne une data time complétée
	*/
	//*
	function changeDateTimeFormat($dateTime)
	{
		$partDateRegex = "/^(0[1-9]|1[0-2])\/(19|20)\d{2}$/";
		if(preg_match($partDateRegex, $dateTime))
		{
			$dateTime = "01/".$dateTime;
		}
		return date("Y-m-d H:i:s", strtotime(str_replace('/','-',$dateTime)));
	}

	function frenchToSQLDate($date)
	{
		return date("Y-m-d", strtotime(str_replace('/','-',$date)));
	}
	
	/**
	*	retoune true si c'est un nombre
	*/
	//*
	function isNumber($number)
	{
		return is_numeric($number);
	}
	
	/**
	*	retourne true si c'est un string
	*/
	//*	
	function isString($string)
	{
		if(strlen($string) > 1){
			return true;
		}else {
			return false;
		}
	}

	/**
	* retourne true si le numero de telephone est du format : 00.00.00.00 ou 00 00 00 00 ou 00-00-00-00 ou 00000000
	*/
	//*
	function validateNumeroTelephone($numeroTelephone)
	{
		$telephone_regex = "/^[0-9]{2}[-. ]?[0-9]{2}[-. ]?[0-9]{2}[-. ]?[0-9]{2}[-. ]?$/";
		if( preg_match($telephone_regex, $numeroTelephone) ) {
			return true;
		}else {
			return false;
		}
	}

	function setNumeroTelephone($numeroTelephone)
	{
		$numeroTelephone = str_replace(".", "", $numeroTelephone);
		$numeroTelephone = str_replace("-", "", $numeroTelephone);
		$numeroTelephone = str_replace(" ", "", $numeroTelephone);

		$n1 = $numeroTelephone[0].$numeroTelephone[1];
		$n2 = $numeroTelephone[2].$numeroTelephone[3];
		$n3 = $numeroTelephone[4].$numeroTelephone[5];
		$n4 = $numeroTelephone[6].$numeroTelephone[7];

		return $n1." ".$n2." ".$n3." ".$n4;
	}

	function isEmail($email)
	{
		$regex = "/^[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}$/";
		if( preg_match($regex, $email) ) {
			return true;
		}else {
			return false;
		}
	}

	/**
	 * Fonction getLitterateMonthYear
	 * ----------------------------
	 * Transforme la date 2010-11-15 en Novembre 2010
	 */
	//*
	function getLitterateMonthYear ( $date )
	{
		$arr = explode ("-", $date);
		if( $arr != NULL && $arr != "" )
		{
			switch ( trim( $arr["1"] ) ) 
			{
				case '01':
					$new_date = "Janvier ".$arr["0"];
					break;
				case '02':
					$new_date = "Février ".$arr["0"];
					break;
				case '03':
					$new_date = "Mars ".$arr["0"];
					break;
				case '04':
					$new_date = "Avril ".$arr["0"];
					break;
				case '05':
					$new_date = "Mai ".$arr["0"];
					break;
				case '06':
					$new_date = "Juin ".$arr["0"];
					break;
				case '07':
					$new_date = "Juillet ".$arr["0"];
					break;
				case '08':
					$new_date = "Août ".$arr["0"];
					break;
				case '09':
					$new_date = "Septembre ".$arr["0"];
					break;
				case '10':
					$new_date = "Octobre ".$arr["0"];
					break;
				case '11':
					$new_date = "Novembre ".$arr["0"];
					break;
				case '12':
					$new_date = "Décembre".$arr["0"];
					break;												
				default:
					$new_date = "Mois inconnu ".$arr["0"];
					break;
			}
		}
		else
		{
			$new_date = "Moi inconnu Année inconnue";
		}
		return $new_date;
	}

	/**
	 * Fonction SQLDateToFrenchDate
	 * ----------------------------
	 * Transforme la date 2010-11-15 12:25:58 en 15/11/2010 12:25:58
	 */
	//*
	function getDateFromDatetime ($date)
	{
		$date_split = explode(" ", $date);

		if($date_split[0] != "0000-00-00")
		{
			$arr = explode ("-", $date_split[0]);
			$new_date = $arr [2]."/".$arr [1]."/".$arr [0];
		}
		else
		{
			$new_date = "";
		}
		return $new_date;
	}

	function output_file($file, $name, $mime_type='')
	{
     /*
     This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
     */
     
     //Check the file premission
     if(!is_readable($file)) die('File not found or inaccessible!');
     
     $content = "";
     $size = filesize($file);
     $name = rawurldecode($name);
     
     /* Figure out the MIME type | Check in array */
     $known_mime_types=array(
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html" => "text/html",
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg"=> "image/jpg",
        "jpg" =>  "image/jpg",
        "php" => "text/plain"
     );
     
     if( $mime_type=='' )
     {
         $file_extension = strtolower(substr(strrchr($file,"."),1));
         if(array_key_exists($file_extension, $known_mime_types))
         {
            $mime_type=$known_mime_types[$file_extension];
         } 
         else 
         {
            $mime_type="application/force-download";
         };
     };
     
     //turn off output buffering to decrease cpu usage
     @ob_end_clean(); 
     
    if( isset($_SERVER['HTTP_RANGE'] ))
    {
        list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
        list($range) = explode(",",$range,2);
        list($range, $range_end) = explode("-", $range);
        $range = intval( $range );
        if( !$range_end ) 
        {
            $range_end = $size-1;
        } 
        else 
        {
            $range_end = intval( $range_end );
        }
        /*
        ------------------------------------------------------------------------------------------------------
        //This application is developed by www.webinfopedia.com
        //visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
        ------------------------------------------------------------------------------------------------------
        */
        //*
        $new_length = $range_end-$range+1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
    } 
    else 
    {
        $new_length=$size;
        header("Content-Length: ".$size);
    }
     /* Will output the file itself */
     $chunksize = 1*(1024*1024); //you may want to change this
     $bytes_send = 0;
     if ( $file = fopen($file, 'r') )
     {
        if(isset($_SERVER['HTTP_RANGE']))
            fseek($file, $range);
     
        while( !feof($file) && (!connection_aborted()) && ($bytes_send < $new_length) )
        {
            $buffer = fgets ( $file );
            $content .= $buffer;
            $bytes_send += strlen($buffer);
        }
        fclose($file);
     } 
     else
     //If no permissiion
     die('Error - can not open file.');
    return $content;
}
?>