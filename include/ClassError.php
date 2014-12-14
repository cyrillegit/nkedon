<?php
require_once("ClassTemplate.php");

class Error extends Exception
{
	/**
	*Php variable which contains all necessary infos to display error msg.
	*@var array
	*/
	private $backtrace;
	
	/**
	*Constructor
	*@param string $msg The error msg
	*@param array $backtrace The full php error array
	*@access public
	*@return nothing
	*/
	public function __construct($msg,$backtrace) {
        parent::__construct($msg);
		$this->backtrace = $backtrace;
    }
	/**
	*Function to parse the backtrace data and display it in a human readable format
	*@param nothing
	*@access private
	*@return string $output a well formed error string.
	*/
	public function __toString()
	{
		$output = '<div>';
		$output .= $this->getMessage();
		$output .= '</div>';
		$i = count($this->backtrace);
		$output.= '<div><pre>';
		foreach ($this->backtrace as $frame)
		{
			$output .= "\n#".$i--." in <b>".(isset($frame['file'])?$frame['file']:'')."</b> on line <b>".(isset($frame['line'])?$frame['line']:'')."</b> , in call to ".(isset($frame['class'])?$frame['class']."::":'').$frame['function']."()";
		}
		$output .= '</pre></div>';
		return $output;
	}
	
	/**
	*Function to display the error to the user.
	*@param nothing
	*@access public
	*@return nothing
	*/
	public function displayError()
	{
		if (session_id () != "")
		{
			// Evite ainsi l'erreur Fatale de suppression d'une session non initialisée.
			session_destroy();
		}
		$error_html = new Templates();
		$error_html->display("error.tpl");
		exit;
	}
	/**
	*Function to get the current time.
	*@param nothing
	*@access private
	*@return a well formed date timestamp
	*/
	private function getTime() {
        return date('Y-m-d H:i:s');
    }
	
	/**
	*Function to send an email to the administrator to alert him that an error occured.
	*@param nothing
	*@access public
	*@return nothing
	*/
	public function sendMail(){
		$adresse = Configuration::getValue('admin_mail');
		$sujet   = "[Dev]Erreur sur le site";
		$mime_boundary = "----NEMAND SOFT----".md5(time());
		$entete = "From: NEMAND SOFT Interface Runtime <support@nemand_soft.com>\n";
		$entete .= "MIME-Version: 1.0\n";
		$entete .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
		$corps = "--$mime_boundary\n";
		$corps .= "Content-Type: text/html; charset=UTF-8\n";
		$corps .= "Content-Transfer-Encoding: 8bit\n\n";
		
		$corps .= "<h3 align=center>Erreur: ".$this->getMessage()."</h3>";
		$corps .= "<h5 align=right>Date: ".$this->getTime()."</h5>";
		$corps .= "<hr />Backtrace:";
		$corps .= $this->__toString();
		$corps .= "<hr />Infos Serveur:";
		$corps .= "<pre>".print_r($_SERVER,true)."</pre>";
		$corps .= "<hr />Infos Max:";
		$corps .= "<pre>".print_r($this->backtrace,true)."</pre>";
		// le @ évite ainsi les erreurs.
		@mail($adresse, $sujet, $corps, $entete);
	}
}
?>
