<?php if(1==2){?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="fileToUpload" />
    <input type="submit" value="Upload Image" name="submit" />
</form>
<?php }
$this->user->force_login();
$bad_formats = array('php','dll','htaccess');
$photo_formats = array('jpg','jpeg','png','gif');
$allowd_formats = ['jpg','jpeg','png','gif','mp4'];
$video_formats = array('mp4');
if(isset($_FILES["file"])) {
	set_time_limit(0);
	$file_name = urldecode(basename($_FILES["file"]["name"]));
	$format = file_extension ($file_name);
	if(in_array($format,$bad_formats)){
		exit('this file format is illegal');
	}
	$newfile = time().rand(324343,999999999).'.'.$format;
	$target_file = $C->path_tmp . $newfile;
	while(file_exists($target_file)){
		$newfile = time().rand(324343,999999999).'.'.$format;
		$target_file = $C->path_tmp . $newfile;
	}
	if(isset($_FILES["file"]["tmp_name"]) && move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
		/*image check*/
		$is_photo = false;
		$data = array("type"=>"file","file_name"=>$newfile);
		if(in_array($format,$allowd_formats)) {
			$data["path"]   =   $target_file;
            $data["format"] =   $format;
        }else{
            exit("NO:invalid format");
        }

		$reference = $this->network->temporary_add(time()+6400,'file',json_encode($data),true);

		/*can't use cookie!
		//set cookie
		if(isset($_POST["section"]) && substr($_POST["section"],0,7)=="upload_"){
		$cookie_name = $_POST["section"];
		if(isset($_COOKIE[$cookie_name])){
		$cookie_content = json_decode($_COOKIE[$cookie_name]);
		$cookie_content[] = $access_key;
		}else{
		$cookie_content = array();
		$cookie_content[] = $access_key;
		}
		setcookie($cookie_name,json_encode($cookie_content),time()+3600,"/");
		}
		 */
		$output = (object)[
			"status"=>200,
			"message"=>"uploadSuccessfull",
			"information"=>(object)[]
		];
		$output->information->reference = $reference;
		if(isset($_POST["blogPost"])){
			$tmp = $this->network->temporary_get($reference);
			$file_path = $C->path_photos_blog."c_".rand(1111111,9999999)."_".time().".jpg";
			$image = new image();
			$image->fromFile($tmp->path)->autoOrient()->resize(450)->toFile($file_path, 'image/jpeg');
			$output->location = $C->SITE_URL.$file_path;
		}
		$this->api->output($output);
	}else{
		$output = (object)[
			"status"=>400,
			"message"=>"errorOnUpload",
			"information"=>null
		];
		$this->api->output($output);
	}
}
$output = (object)[
	"status"=>400,
	"message"=>"invalidData",
	"information"=>null
];
$this->api->output($output);
?>