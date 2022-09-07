<?php
function encrypt($string){
	$default = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	$custom  = "RQPdcDCBAzZuTlFEXWVkjihgfqYLKU65JISbtsr32O1yxwNMmHGpon4eva9870+/";
	$encoded = strtr(base64_encode($string), $default, $custom);
	return $encoded;
}
function decrypt($encoded){
	$default = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	$custom  = "RQPdcDCBAzZuTlFEXWVkjihgfqYLKU65JISbtsr32O1yxwNMmHGpon4eva9870+/";
	$decoded = base64_decode(strtr($encoded, $custom, $default));
	return $decoded;
}
function add_nofollow($html, $skip = null) {
    return preg_replace_callback(
        "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
            return (
                !($skip && strpos($mach[1], $skip) !== false) &&
                strpos($mach[1], 'rel=') === false
            ) ? $mach[1] . ' rel="nofollow" target="_blank">' : $mach[0];
        },
        $html
    );
}
function to_latin_number($string) {
  //arrays of persian and latin numbers
  $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
  $latin_num = range(0, 9);

  $string = str_replace($persian_num, $latin_num, $string);

  return $string;
}
function encode_account_number($user_id){
	$account_number = "34";
	$account_number .= (100000000+$user_id);
	$_key = substr($account_number,10,1);
	$account_number = substr($account_number,0,10).(substr($_key+1,0,1)).(substr($_key+5,0,1)).substr($account_number,10,1);
	return $account_number;
}
function decode_account_number($account_number){
	$account_number = substr($account_number,2,strlen($account_number)-5).substr($account_number,strlen($account_number)-1,1);
	$user_id = $account_number-100000000;
	return $user_id;
}
function data_array_mysql($implode,$array_data){
	$db		= & $GLOBALS['db'];
	$base = array();
	foreach($array_data as $key=>$value){
		if($value===null)
			continue;
                if(is_array($value)){
                    if(isset($value["type"]) && $value["type"]=="direct")
                        $base[] = $value["query"];
                    else{
                        $base[] = '`'.$key.'` IN ('.implode(",",$value).')';
                    }
                }else{
                    if(strpos($key, ".")!==false){
                        $key = str_replace(array("."),"`.`", $key);
                    }
                    if(substr($value,0,1)=="("||substr($value,0,6)=="POINT("||(substr($value,0,1)=="`" && substr($value,-1,1)=="`")){
                            $base[] = '`'.$key.'`='.$value;
                    }else{
						if($value===null){
                            $base[] = '`'.$key.'`=null';
						}else{
                            $base[] = '`'.$key.'`="'.$db->escape($value).'"';
						}
                    }
                }
	}
	$sql = implode($implode,$base);
	return $sql;
}
function in_uri($string){
	GLOBAL $_SERVER;
	if(!!strpos($_SERVER["REQUEST_URI"],$string))
		return true;
	return false;
}
function plus_get_input($array_data){
	GLOBAL $_GET,$C;
        $final = "";
        $q = array();
        foreach($_GET as $key=>$value){
            $q[$key] = $value;
        }
        foreach($array_data as $key=>$value){
            $q[urlencode($key)] = urlencode($value);
        }
        $final = http_build_query($q);
        return $C->FULL_URL_WITHOUT_GET.'?'.$final;
}
function make_unique_cache($data){
	$unique = '';
	$data = (array) $data;
        ksort($data);
	if(count($data)==1){
		$array = array('single'=>'select');
		$data = array_merge($data,$array);
	}
	foreach($data as $key=>$value){
		$unique = $unique.'_'.$key.'_'. str_replace(array("\"","{","}"),"",json_encode($value));
	}
	return $unique;
}
function make_slug($str, $options = array()) {

    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

    $defaults = array(
        'delimiter'     => '-',
        'limit'         => 50,
        'lowercase'     => true,
        'replacements'  => array(),
        'transliterate' => false,
    );

    // Merge options
    $options = array_merge($defaults, $options);

    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );

    // Make custom replacements
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }

    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}
function make_string($word_space,$words_array,$first_word_space=false,$last_word_space=false){
	if($first_word_space)
		return $word_space.implode($word_space,$words_array);
	elseif($last_word_space)
		return implode($word_space,$words_array).$word_space;
	else
		return implode($word_space,$words_array);
}
function output_api($data){
	echo json_encode($data);
}
function random_string($length = 10,$characters=false) {
    $characters = !$characters?'0123456789abcdefghijklmnopqtuvwxyzABCDEFGHIJKLMNOPQTUVWXYZ':$characters;
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function file_extension ($filename)
{
   $filename = strtolower($filename) ;
   $exts = explode(".", $filename) ;
   $n = count($exts)-1;
   $exts = $exts[$n];
   return $exts;
}
function path_encode ($path)
{
	$array_one = array(1,2,3,4,5,6,7,8,9,0);
	$array_two = array("Q6F","2er","TG","VR","Tb","Hy7","Um","It4","zk5","Ah0");
	$path = strtolower($path) ;
	return str_replace($array_one,$array_two, $path);
}
function getOS() {

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }

    return $os_platform;

}
function password($password){
	$default = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	$custom  = "ZYLKU65JIHGpon4edcbtsr32vuTSRQPO1FEXWVDCBAzyxwNMmlkjihgfqa9870+/";
	$encoded = strtr(base64_encode($password), $default, $custom);
	return $encoded;
}
function decode_password($encoded){
	$default = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	$custom  = "ZYLKU65JIHGpon4edcbtsr32vuTSRQPO1FEXWVDCBAzyxwNMmlkjihgfqa9870+/";
	$decoded = base64_decode(strtr($encoded, $custom, $default));
	return $decoded;
}
function alert($title,$message)
{
	return '<div class="alert">'.($title!==null?'<span class="title">'.$title.'</span>':"").'<span class="message">'.$message.'</span></div>';
}
function error_box($title,$message)
{
	return '<div class="error"><span class="title">'.$title.'</span><span class="message">'.$message.'</span></div>';
}
function ok_box($title,$message)
{
	return '<div class="ok"><span class="title">'.$title.'</span><span class="message">'.$message.'</span></div>';
}
function IP() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = "127.0.0.1";
    if($ipaddress=="::1")
        return "127.0.0.1";
    return $ipaddress;
}
function is_rtl( $string ) {
	$rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
	return preg_match($rtl_chars_pattern, $string);
}
function render_inputs($received_inputs)
{
    $C = $GLOBALS['C'];
    if($C->debug_mode){
        echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">";
        foreach($received_inputs as $input){
            $input = (object) $input;
            echo "<br />{$input->name}:<br />";
            if(isset($input->datatype) && $input->datatype=="file"){
                echo "<input type=\"file\" name=\"{$input->name}\" />";
            }else{
                echo "<input name=\"{$input->name}\" />";
            }
        }
        echo "<br /><input name=\"submit\" type=\"submit\"></form>";
    }

    $inputs = array();
    if(isset($_POST['submit'])){
        foreach($received_inputs as $key=>$value){
            if(isset($_POST[$value['name']])){
                if(!isset($value['datatype']) || $value['datatype']!=='file')
                    $variable_content = $_POST[$value['name']];
                elseif(isset($value['datatype']) && $value['datatype']=='file')
                    $variable_content = $_FILES[$value['name']];

                if(isset($value['trim']) && $value['trim'] && (!isset($value['datatype']) || $value['datatype']!=='file')){
                        $variable_content = trim($_POST[$value['name']]);
                }
                if($value['required'] && empty($variable_content)){
                    if($value['datatype']!=='boolean'){
                        $array_result = array(
                            'result' => '400',
                            'description' => 'Bad Request. Please Send "'.$value['name'].'"'
                        );
                        output_api($array_result);
                        exit;
                    }
                }
                if(!empty($value['datatype'])){
                    if($value['datatype']=='file'){
                        $uploadfile = $C->path_tmp.rand(10000,99999).time().rand(10000,99999).'.'.extension($_FILES[$value['name']]['name']);
                        if (move_uploaded_file($_FILES[$value['name']]['tmp_name'], $uploadfile)) {
                          $uploaded_file_data = array('path'=>$uploadfile);
                        }
                    }else{
                        if($value['datatype']=='boolean'){
                            if(!in_array($variable_content, array(true,false,"true","false",0,1))){
                                $array_result = array(
                                    'result' => '400',
                                    'description' => 'Bad Request. Wrong DataType "'.$value['name'].'"'
                                );
                                output_api($array_result);
                                exit;
                            }else{
                                if(in_array($variable_content, array(true,"true",1))){
                                    $variable_content = true;
                                }elseif(in_array($variable_content, array(false,"false",0,""))){
                                    $variable_content = false;
                                }
                            }
                        }elseif($value['datatype']!==gettype($variable_content) && $value['datatype']!=='numeric'){
                            $array_result = array(
                                'result' => '400',
                                'description' => 'Bad Request. Wrong DataType "'.$value['name'].'"'
                            );
                            output_api($array_result);
                            exit;
                        }elseif($value['datatype']=='numeric' && !is_numeric($variable_content)){
                            $array_result = array(
                                'result' => '400',
                                'description' => 'Bad Request. Wrong DataType "'.$value['name'].$variable_content.'"'
                            );
                            output_api($array_result);
                            exit;
                        }
                    }
                }
                if(!empty($value['maxlength']) && strlen($variable_content)>$value['maxlength']){
                    $array_result = array(
                        'result' => '400',
                        'description' => 'Bad Request. Wrong in "'.$value['name'].'"'
                    );
                    output_api($array_result);
                    exit;
                }
                if(!empty($value['minlength']) && strlen($variable_content)<$value['minlength']){
                    $array_result = array(
                        'result' => '400',
                        'description' => 'Bad Request. Wrong in "'.$value['name'].'"'
                    );
                    output_api($array_result);
                    exit;
                }
                if(isset($value['set_phone_prefix']) && $value['set_phone_prefix']){
                    $phone = new phone;
                    $inputs['phone_prefix'] = $phone->phone_prefix_by_country_code($variable_content);
                }

                if(!isset($value['datatype']) || $value['datatype']!=='file') {
                    $inputs[$value['name']] = $variable_content;
                }
                elseif($value['datatype']=='file')
                    $inputs[$value['name']] = $uploaded_file_data;
            }
        }
    }
    return $inputs;
}
function get_between($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}
function time_diff_elapsed($end,$start){
    $diff = $end-$start;
    $result = new stdClass();
    $result->years = floor($diff / (365*60*60*24));
    $result->months = floor(($diff - $result->years * 365*60*60*24) / (30*60*60*24));
    $result->days = floor(($diff - $result->years * 365*60*60*24 - $result->months*30*60*60*24)/ (60*60*24));
    $result->hours = floor(($diff - $result->years * 365*60*60*24 - $result->months*30*60*60*24 - $result->days*60*60*24)/ (60*60));
    $result->minutes = floor(($diff - $result->years * 365*60*60*24 - $result->months*30*60*60*24 - $result->days*60*60*24 - $result->hours*60*60)/ (60));
    foreach($result as $key=>$value){
        $result->$key = intval($value);
    }
    return $result;
}
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function make_pagination_url($paging_url,$page){
    if(strpos($paging_url,"{page_counter}")!=false){
		$paging_url = str_replace("{page_counter}","page:".$page,$paging_url);
    }else{
		if(substr($paging_url,strlen($paging_url)-1,1)=="/"){
			$paging_url = $paging_url."page:".$page.'/';
		}else{
			$paging_url = $paging_url."/page:".$page.'/';
		}
    }
	if($page==1)
		$paging_url = str_replace("/page:1","",$paging_url);
	if(substr($paging_url,strlen($paging_url)-1,1)!=="/")
		$paging_url .="/";
    return $paging_url;
}
function convert_to_english_number($string) {
    if(is_array($string))return $string;
  $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩','۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
  $latin_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
  $string = str_replace( $persian_num,$latin_num, $string);
  return $string;
}
function add_prefix_array($array,$prefix){
    var_dump($array);
    foreach($array as $key=>$value){
        $array[$key] = $prefix;
    }
    return $array;
}
function array_filter_recursive($input, $callback = null) 
{ 
    foreach ($input as &$value) 
    { 
      if (is_array($value)) 
      { 
        $value = array_filter_recursive($value, $callback); 
      } 
    } 

    return array_map($callback,$input); 
}
function encode($text){
    $key = "rg4th5yj6uj6h5gg45h6TY";
    $encrypted = bin2hex(openssl_encrypt($text,'AES-128-CBC', $key));
    return $encrypted;
}
function decode($encrypted){
    $key = "rg4th5yj6uj6h5gg45h6TY";
    $decrypted=openssl_decrypt(hex2bin($encrypted),'AES-128-CBC',$key);
    return $decrypted;
}
?>