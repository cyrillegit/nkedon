 <?php
 if(!extension_loaded('sockets')) {
    exit("Function requires sockets.");
 }
 /*
 *@author Axel ETCHEVERRY
 *@link http://poppy31.free.fr
 *@link http://axel.2ate.net
 *@version 1.0
 *@date 2007/06/28 00:29
 */ 
 
 class SMS {
    
    protected $param;
    
    public function __construct() {
       $this->param = array();
    }
    
    /*
    *@return void
    *@desc info de connection au service
    */
    public function login($email, $pass) {
       $this->param['email']   = $email;
       $this->param['pass']   = $pass;
    }
    /*
    *@return void
    *@desc info pour le msg
    */
    public function msg($num, $msg, $diff = null) {
       $this->param['nemero']      = $this->is_nums($num);
       $this->param['message']      = $this->is_160($msg);
       
       if(!empty($diff)) {
          $this->param['diff']   = $diff;
       }
    }
    
    /*
    *@return string
    *@desc verifi si il y a plusieur destinatèr
    */
    public function is_nums($num) {
       if(is_array($num)){
          return implode("-", $num);
       }else{
          return $num;
       }
    }
    
    public function is_160($msg) {
       $count = strlen($msg);
       
       if($count > 160) {
          return $msg;
       }else{
          return $msg;
       }
    }
    /*
    *@return string
    *@desc envoie du sms
    */
    public function send($bool = true) {
       
       $request = http_build_query($this->param);
       
       $soc = @fsockopen("www.smsvialeweb.com/http.php?".$request, 80, $errno, $errstr);
       
       if($soc) {
          $result = ;
          
          while(!feof($soc)){ 
             $result .= fgets($soc);
          }
          
          fclose($soc);
          
          if($bool){
             return $this->rep_serveur(trim(strip_tags($result)));
          }else{
             return trim(strip_tags($result));
          }
       }else{
          if($bool){
             return $errstr;
          }else{
             return $errno;
          }
       }
    }
    
    /*
    *@return string
    *@desc retourn la reponce du serveur par son code
    */
    public function rep_serveur($code) {
       switch ($code) {
       case 80:
          return "Le message a été envoyé.";
          break;
       case 81:
          return "Le message est enregistré pour un envoi en différé.";
          break;
       case 82:
          return "Le login et/ou mot de passe n'est pas valide.";
          break;
       case 83:
          return "Vous devez créditer le compte.";
          break;
       case 84:
          return "Le numéro de gsm n'est pas valide.";
          break;
       case 85:
          return "Le format d'envoi en différé n'est pas valide.";
          break;
       case 86:
          return "Le groupe de contacts est vide.";
          break;
       case 87:
          return "La valeur email est vide.";
          break;
       case 88:
          return "La valeur pass est vide.";
          break;
       case 89:
          return "La valeur numero est vide";
          break;
       case 90:
          return "La valeur message est vide.";
          break;
       case 91:
          return "Le message a déjà été envoyé à ce numéro dans les 24 dernières heures.";
          break;
       
       }
 
    }
 }
 
 ?>