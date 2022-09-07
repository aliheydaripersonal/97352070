<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$D->title = "contactTitle";
$D->description = "contactDescription";
// $D->custom_inside_head = schema_markup_maker("WebSite",["url"=>$C->FULL_URL,"title"=>$this->lang($D->title),"description"=>$this->lang($D->description)]);
$D->departments	=	[
	0=>(object)["label"=>"technical","mail"=>""],
	1=>(object)["label"=>"financial","mail"=>""],
	2=>(object)["label"=>"managment","mail"=>""]
];
$D->data = new stdClass;
$D->data->mail = "";
$D->data->phone = "";
$D->data->subject = "";
$D->data->message = "";
if(isset($_POST["submit"])){
	
	$D->data->department = intval($_POST["department"]);
	$D->data->mail = htmlspecialchars($_POST["mail"]);
	$D->data->phone = htmlspecialchars($_POST["phone"]);
	$D->data->subject = htmlspecialchars($_POST["subject"]);
	$D->data->message = htmlspecialchars($_POST["message"]);
	
	$_recaptcha = new \ReCaptcha\ReCaptcha($C->RECAPTCHA->SECRET_KEY);
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
		$resp = $_recaptcha->verify($_POST['g-recaptcha-response'], IP());
	if (empty($_POST['g-recaptcha-response']) || !$resp->isSuccess()) {
		$D->ERROR = true;
		$D->ERROR_MESSAGE = "captchaError";
	}elseif(!isset($_POST["department"])){
		$D->ERROR = true;
		$D->ERROR_MESSAGE = "selectDepartment";
	}elseif(!isset($_POST["subject"]) || empty($_POST["subject"])){
		$D->ERROR = true;
		$D->ERROR_MESSAGE = "fillSubject";
	}elseif(!isset($_POST["mail"]) || empty($_POST["mail"])){
		$D->ERROR = true;
		$D->ERROR_MESSAGE = "fillMail";
	}elseif(!isset($_POST["message"]) || empty($_POST["message"])){
		$D->ERROR = true;
		$D->ERROR_MESSAGE = "fillMessage";
	}elseif(isset($D->departments[$D->data->department])){
		
		$content = "";
		$content .= "department : ".$this->lang($D->departments[$D->data->department]->label)."\r\n";
		$content .= "IP : ".IP()."\r\n";
		$content .= "subject : ".$D->data->subject."\r\n";
		$content .= "mail : ".$D->data->mail."\r\n";
		$content .= "phone : ".$D->data->phone."\r\n";
		$content .= "message : ".$D->data->message."\r\n";
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
		$headers .= 'From: <'.$D->data->mail.'>' . "\r\n";
		
		mail($D->departments[$D->data->department]->mail,"Sepordeh Support Message",$content,$headers);
		
		//reset form{
		$D->data->mail = "";
		$D->data->phone = "";
		$D->data->subject = "";
		$D->data->message = "";	
		//}
		
		$D->SUCCESSFUL = true;
		$D->SUCCESSFUL_MESSAGE = "sended";
	}
}
$this->load_template("contact.php");
?>