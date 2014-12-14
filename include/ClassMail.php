<?php
	/**********************************************************************
	*
	* Date de cr�ation : 05/01/2010
	* Date de modification : 16/08/2011
	*
	***********************************************************************
	* Classe permettant de g�rer l'envoi des mails. Le script automatis�
	* par un cron utilisera cette classe pour r�aliser les envois 
	* diff�r�s.
	*
	* Lorsqu'un mail est envoy�, il sera imm�diatement stock� dans une
	* table de la base de donn�es pour �viter tous litiges.
	* Cette table devra �tre vid�e de temps en temps pour gagner de 
	* l'espace disque.
	*
	* Version : 1.1
	*		- Possibilit� d'envoyer les mails vers une adresse d�finie.
	*
	**********************************************************************/
	//require_once ("./config/config.php");
	
	ini_set ("SMTP", "smtp.googlemail.com");
	ini_set ("smtp_port", 465);
	
	class Mail
	{
		// Ent�te HTML et autres.
		protected $headers;
		// Corps du message.
		protected $body;
		// Sujet du message.
		protected $subject;
		
		/**
		 * Constructeur par d&eacute;faut.
		 *
		 */
		public function __construct()
		{
			$this->headers = 'MIME-Version: 1.0' . "\r\n";
     		$this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     		
     		$this->subject = "";
     		$this->body = "";
     		
     		$this->AddRecipients(array ("Nkedon" => "cyrille.moffo@gmail.com"), "From");
		}
		
		/**
		 * Fonction AddRecipients
		 * ----------------------
		 * Ajout de destinataires aux mails envoy&eacute;s.
		 *
		 * @param Array $to ($identite => $email) / string.
		 * @param string $mode (To, From, Cc, Bcc)
		 */
		public function AddRecipients ($to, $mode)
		{
			$values = "";
			
			if (is_array ($to))
			{
				foreach ($to as $identite => $email)
				{
					if ($values != "") $values .= ",";
					$values .= utf8_encode ($identite)." <$email>"; 
				}
			}
			else
			{
				$values = $to;
			}
			$this->headers .= $mode.": ".$values . "\r\n";
		}
		
		/**
		 * Fonction AddSubject
		 * -------------------
		 * Ajout du sujet au mail.
		 *
		 * @param string $sujet
		 */
		public function AddSubject ($sujet)
		{
			$this->subject = $sujet;
		}
		
		/**
		 * Fonction AddBody
		 * ----------------
		 * Ajout du corps de texte au format HTML uniquement.
		 *
		 * @param string $body
		 */
		public function AddBody ($body)
		{
			// Ci-dessous, les variables communes au site qui peuvent �tre omises en amont !
			$body = str_replace ("{WEBSITEACCESS}", Configuration::getValue ("http_home"), $body);
			$this->body = $body;
		}
		
		/**
		 * Fonction AddCondition
		 * ---------------------
		 * Ajoute une condition dans le mail.
		 * Si value est �gal � True, on accepte la condition, et elle sera affich�e, sinon, non.
		 *
		 * @param string $conditionName
		 * @param boolean $okResult
		 */
		public function AddCondition ($cdtName, $okResult)
		{
			// On v�rifie si une condition existe bien dans le BODY. Il aura d�j� d� �tre initialis� en amont.
			$body = $this->body;
			$pos_debut = strpos ($body, "{COND=$cdtName}");
			$pos_end = strpos ($body, "{/COND=$cdtName}");
			if (($pos_debut !== FALSE) && ($pos_end !== FALSE))
			{
				// On les a trouv�.
				if ($okResult)
				{
					// On affiche le milieu.
					$body = str_replace ("{COND=$cdtName}", "", $body);
					$body = str_replace ("{/COND=$cdtName}", "", $body);
					$this->body = $body;
				}
				else
				{
					// On supprime tout le bloc.
					$body_tmp = substr ($body, 0, $pos_debut);
					$body_tmp .= substr ($body, $pos_end + strlen ("{/COND=$cdtName}"));
					$this->body = $body_tmp;
				}
			}
		}
		
		/**
		 * Fonction SetBodyFromFile
		 * ------------------------
		 * Ajout du corps de texte au format HTML uniquement.
		 *
		 * @param string $filename
		 * @param Array $variables
		 */
		public function SetBodyFromFile ($filepath, $variables)
		{
			$contents = file_get_contents ($filepath);
			foreach ($variables as $varName => $varValue)
			{
				// On encapsule les variables avec les bornes {}.
				$contents = str_replace ("{".$varName."}", $varValue, $contents);
			}
			// Parfait, on utilise l'objet lui m�me pour se mettre � jour tout seul !
			$this->AddBody ($contents);
		}
		
		/**
		 * Fonction fixEncoding
		 * --------------------
		 * Cette fonction r�soud l'encodage UTF-8 en ISO pour g�rer correctement les accents.
		 *
		 * @param string $in_str
		 * @return string
		 */
		public function fixEncoding ($in_str)
		{
			$cur_encoding = mb_detect_encoding ($in_str) ;
			
			$buffer = mb_convert_encoding($in_str, 'ISO-8859-1',
						  mb_detect_encoding($in_str, 'UTF-8, ISO-8859-1', true)); 
						  
			// En m�me temps, �a gagne un temps pr�cieux.
			$buffer = utf8_encode ($buffer);
			return $buffer;
		}
		
		/**
		 * Fonction fixEncodingArray
		 * -------------------------
		 * Cette fonction r�soud l'encodage UTF-8 en ISO pour g�rer correctement les accents.
		 * Elle est r�cursive, attention.
		 *
		 * @param Array $array
		 * @return void
		 */
		public function fixEncodingArray($array )
		{
			if (($array !== NULL) && (is_array ($array)))
			{
				foreach ($array as &$a)
				{
					if (is_array ($a))
					{
						$this->fixEncodingArray ($a);
					}
					else
					{
						$a = $this->fixEncoding($a);
					}
				}
			}
		}
		
		/**
		 * Fonction GenerateRandomSID
		 * --------------------------
		 * Cr�e une cha�ne al�atoire de nbCaracteres.
		 *
		 * @param int $nbCaracteres
		 * @return string
		 */
		public function GenerateRandomSID ($nbCaracteres)
		{
			$alphabet_alphanumeric = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			
			$max_alphabet_alphanumeric = strlen ($alphabet_alphanumeric);
		
			$output = "";
			for ($i = 0;$i < $nbCaracteres;$i++)
			{
				$output .= $alphabet_alphanumeric [mt_rand (0, $max_alphabet_alphanumeric - 1)];
			}
			return $output;
		}
		
		/**
		 * Fonction sendMail
		 * -----------------
		 * C'est la fonction qui se charge de faire l'envoi du mail aux bonnes personnes.
		 * Uniquement si la configuration a activ� l'envoi des mails.
		 *
		 * Retourne un bool�ean
		 */
		public function sendMail ()
		{
			$this->AddRecipients(array ("Admin" => "cyrille.moffo@gmail.com"), "To");
			$this->headers .= "X-From-ID-UNIK: Nkedon";
			$this->headers .= "\r\nX-SessionID: " . session_id ();
			$this->headers .= "\r\nX-DateGeneration: " . date ("Y-m-d H:i:s");
			$this->headers .= "\r\nX-NkedonID:" . Configuration::getValue ("SIGNATURE");
			$this->headers .= "\r\nX-UniqueName: " . sha1 ($this->GenerateRandomSID (128));
			
			// Travail � effectuer sur les accents
			$this->body = $this->fixEncoding($this->body);
			$this->body = utf8_decode ($this->body);
			
			// Les mails sont d�sactiv�s sur la version LOCALE (d�port�e).
			if (!Configuration::getValue ("IsLocal"))
			{
				return mail ("", $this->subject, $this->body, $this->headers);
			}
			else
			{
				return true;
			}
		}
		
		/**
		 * Fonction printOutput
		 * --------------------
		 * On �crit � l'�cran le message tel qu'il sera envoy� � la personne ad�quat.
		 *
		 * @param boolean return
		 */
		public function printOutput ($return = false)
		{
			if ($return)
				return $this->body;
			else
				echo $this->body;
		}
	}
?>