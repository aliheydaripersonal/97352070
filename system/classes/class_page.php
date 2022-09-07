<?php

	class page
	{
		public function __construct()
		{
			global $C;
			$this->network	= & $GLOBALS['network'];
			$this->user	= & $GLOBALS['user'];
			$this->cache	= & $GLOBALS['cache'];
			$this->db		= & $GLOBALS['db'];
			$this->api	= & $GLOBALS['api'];
			$this->phone	= & $GLOBALS['phone'];
			$this->core	= & $GLOBALS['core'];
			$this->system_date	=  & $GLOBALS['system_date'];
			$this->request	= array();
			$this->params	= new stdClass;
			$this->title	= NULL;
			$this->html		= NULL;
			$this->controllers	= 	$C->path_controllers;
			$this->lang_data		= array();
			$this->tpl_name	 	= $C->name_template;
		}

		public function LOAD()
		{
			$this->_parse_input();
			$this->_set_template();
			$this->_send_headers();
			$this->_load_controller();
		}

		private function _parse_input()
		{
			global $C;

			if(in_uri("page:1/")){
				$this->redirect(str_replace("page:1/","",$C->FULL_URL));
			}
			
			$_GET = array_filter_recursive($_GET,"convert_to_english_number");
			$_POST = array_filter_recursive($_POST,"convert_to_english_number");
			$_REQUEST = array_filter_recursive($_REQUEST,"convert_to_english_number");
			
			$this->params->user	= FALSE;
			$this->params->group	= FALSE;
			$request	= urldecode($_SERVER['REQUEST_URI']);
			$pos		= strpos($request, '?');
			if( FALSE !== $pos ) {
				$request	= substr($request, 0, $pos);
			}
			if(strpos($request,"image")===false&&strpos($request,"upload")===false&&strpos($request,"merchant")===false&&strpos($request,"app")===false&&strpos($_SERVER['REQUEST_URI'],"?")===false&&strpos($request,".")===false&&substr($request,strlen($request)-1,1)!="/"){
				$this->redirect($C->FULL_URL,301);
				// echo substr($request,strlen($request)-1,1);
				// exit;
			}
			if( FALSE !== strpos($request, '//') ) {
				$request	= preg_replace('/\/+/iu', '/', $request);
			}
			$tmp	= str_replace(array('http://','https://'), '', $C->SITE_URL);
			if( FALSE !== strpos($tmp, '//') ) {
				$tmp	= preg_replace('/\/+/iu', '/', $tmp);
			}
			$tmp	= substr($tmp, strpos($tmp, '/'));
			if( substr($request,0,strlen($tmp)) == $tmp ) {
				$request	= substr($request, strlen($tmp));
			}
			$request	= trim($request, '/');
			$request	= explode('/', $request);
			foreach($request as $i=>$one) {
				if( FALSE!==strpos($one,':') && preg_match('/^([آ-ی۰-۹a-z0-9\-_]+)\:(.*)$/iu',$one,$m) ) {
                                    $this->params->{$m[1]}	= $m[2];
                                    unset($request[$i]);
                                    continue;
				}
				if( ! preg_match('/^([آ-ی۰-۹a-z0-9\-\._]+)$/iu', $one) ) {
                                    unset($request[$i]);
                                    continue;
				}
			}

			$request	= array_values(array_filter($request));
			//$C->displayed_
			if( 0 == count($request) ) {
				$this->request[]	= 'home';
				return;
			}elseif( $request[0] == 'app') {
				$this->request[]	= 'app';
                $this->params->sections = array();
                foreach($request as $key=>$value){
                    if($key==0)
                        continue;
                    $this->params->sections[] = $value;
                }
			}elseif( $request[0] == 'p') {
				if(empty($request[0]) || ! $_post_id = decode($request[1]) )
				{
					$this->request[]	= '404';
					return;
				}else{
					$this->params->post_id = $_post_id;
					$this->request[]	= 'post';
				}
			}elseif( $request[0] == 'blog') {
				$this->request[]	= 'blog';
				$this->params->categories = array();
				$this->params->category_status = false;
				$this->params->single_post_page = false;
				$this->params->tag_id = false;
				if(isset($request[1])&&($request[1]=="post"||is_numeric($request[1]))){
					if($request[1]=="post")
						$this->redirect (str_replace(["/post"],[""],$C->FULL_URL));
					if(!isset($request[1])||!is_numeric($request[1])||count($request)>3)
						$this->redirect ("blog");
					$this->params->single_post_page = true;
					$this->params->post_id = $request[1];
					$this->params->slug = urldecode($request[2]);
				}elseif(isset($request[1])&&$request[1]=="category"){
					$this->params->category_status = true;
					foreach($request as $key=>$value){
						if($key==0||$key==1)
							continue;
						$this->params->categories[] = $value;
					}
				}elseif(isset($request[1])&&$request[1]=="tag"){
					if(empty($request[2])){
						$this->redirect();
					}
					$_tag = $this->core->get_blog_tag_by_slug($request[2]);
					// var_dump($this->params->tag_id);
					// exit("salam");
					if(!$_tag){
						$this->redirect();
					}
					$this->params->tag_id = $_tag->id;
				}elseif(isset($request[1]))
					$this->redirect ("blog");
			}elseif( $request[0] == 'sitemap') {
				header('Location: '.$C->SITE_URL.'sitemap.xml',true,301);
				exit;
			}elseif( $request[0] == 'sitemap.xml') {
				$this->request[]	= 'sitemap';
			}elseif(file_exists($this->controllers.implode('_',$request).'.php')){
				$first	= $request[0];
				if( file_exists($this->controllers.implode('_',$request).'.php') ) {
					foreach($request as $value){
					$this->request[]	= 	$value;
					}
				}else{
					$this->request[]	= '404';
					return;
				}
				
				unset($request[0]);
				foreach($request as $one) {
					$t	= $this->request;
					$t[]	= $one;
					if( file_exists( $this->controllers.implode('_', $t).'.php') ) {
						$this->request[]	= $one;
						continue;
					}
					break;
				}
			}elseif($request[0]=="province" && count($request)==2){
				$_province = $this->core->get_province_by_slug($request[1]);
				if(!$_province){
					$this->request[]	= '404';
					return;
				}
				$this->params->province_id = $_province->id;
				$this->request[]	= 'province';
				return;
			}elseif($request[0]=="country" && count($request)==2){
				$_country = $this->core->get_country_by_slug($request[1]);
				if(!$_country){
					$this->request[]	= '404';
					return;
				}
				$this->params->country_id = $_country->id;
				$this->request[]	= 'country';
				return;
			}elseif($_city = $this->core->get_city_by_slug($request[0])){
				$this->params->city_id = $_city->id;
				if(isset($request[1]) && !empty($request[1]))
					if($_category = $this->core->get_category_by_slug($request[1])){
						$this->params->first_category_id = $_category->id;
						if(isset($request[2]) && !empty($request[2]))
							if($__category = $this->core->get_category_by_slug($request[2])){
								$this->params->end_category_id = $__category->id;
							}else{
								$this->request[]	= '404';
								return;
							}
						else
							$this->params->end_category_id = $this->params->first_category_id;
					}else{
						$this->request[]	= '404';
						return;
					}
				$this->request[]	= 'search';
				return;
			}else{
				$this->request[]	= '404';
				return;
			}
			//security check{
				$black_list_words = array("union","#","select","where","--","/*","script");
				if($this->request[0]	!= '404')
					foreach($black_list_words as $key=>$word){
						if(strpos(strtolower($_SERVER["REQUEST_URI"]),$word)!=false){
							$this->request	= ['404'];
							break;
						}
					}
				if($this->request[0]	!= '404')
					foreach($_REQUEST as $key=>$value){
						if(!is_array($_REQUEST) && !is_object($_REQUEST))
						foreach($black_list_words as $key=>$word){
							if(strpos(strtolower($value),$word)!=false){
								$this->request	= ['404'];
								break;
							}
						}
					}
			//}
		}

		private function _send_headers()
		{
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: post-check=0, pre-check=0', FALSE);
			header('Pragma: no-cache');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s'). ' GMT');
			if( $this->request[0] == 'ajax' ) {
				if( $this->param('ajaxtp') == 'xml' ) {
					header('Content-type: application/xml; charset=utf-8');
				}
				else {
					header('Content-type: text/plain; charset=utf-8');
				}
			}
			else {
				header('Content-type: text/html; charset=utf-8');
			}
		}

		public function _set_template()
		{
			global $C;
			if( isset($C->name_template) && file_exists($C->path_templates.$C->name_template.'/theme.php') ) {
				$this->tpl_name		= $C->name_template;
			}
			$this->tpl_dir		= $C->path_templates.$this->tpl_name.'/';
		}

		private function _load_controller()
		{
			global $C, $D;
			$D	= new stdClass;
			$D->page_title	= $C->SITE_TITLE;

			$this->load_langfile("global.php");
			$C->HOME_SITE_TITLE = $this->lang("homeTitle");
			$C->HOME_SITE_DESCRIPTION = $this->lang("homeDescription");
			
			/*more/\me*/
			$D->ERROR = $D->SUCCESSFUL = false;
			$db		= & $this->db;
			$db		= & $db;
			$cache	= & $this->cache;
			$user		= & $this->user;
			$network	= & $this->network;
			require_once( $this->controllers.implode('_',$this->request).'.php' );
		}
		private function load_controller($filename)
		{
			global $C, $D;
			require_once( $this->controllers.$filename );
		}
		public function load_template($filename, $output_content=TRUE)
		{
			global $C, $D;

			$filename	= $this->tpl_dir.'html/'.$filename;
			$this->load_langfile("global.php");
			if( $output_content ) {
				require($filename);
				return TRUE;
			}
			else {
				ob_start();
				require($filename);
				$cnt	= ob_get_contents();
				ob_end_clean();
				return $cnt;
			}
		}

		public function send_verification_code($type=0,$receiver){
			GLOBAL $C;
			$this->load_langfile('global.php');

			$array_data = array('ip'=>ip2long(IP()));
			$verifications_with_this_ip = $this->db->fetch_field("SELECT count(*) FROM `verifications` WHERE ".data_array_mysql(' AND ',$array_data)." AND `date`>".(time()-3600));
			if($verifications_with_this_ip>$C->verification_per_ip)
				return false;

			$array_data = array('receiver'=>$receiver);
			$verifications = $this->db->fetch_all("SELECT * FROM `verifications` WHERE ".data_array_mysql(' AND ',$array_data)." ORDER BY `date` DESC");

			if(!$verifications || count($verifications)==0 || $verifications[0]->date+$C->verification_interval<time()){
				$array_data = array('type'=>$type,'ip'=>ip2long(IP()),'receiver'=>$receiver,'code'=>rand(1000,999999),'date'=>time());
				switch($type){
				case 0:
					if(!sms_validation("BalketVerify",$receiver,array("token"=>$array_data['code'])))
						return false;
					break;
				case 1:
					if(!mail($receiver,$this->lang("verificationMailSubject"),$this->lang("verificationMailContent",array("#code"=>$array_data['code']))))
						return false;
					break;
				}
				$this->db->query("INSERT INTO `verifications` SET ".data_array_mysql(',',$array_data));
				return true;
			}else
				return false;
		}
		public function check_verification_code($receiver,$code){
			GLOBAL $C;
			$array_data = array('receiver'=>$receiver,'code'=>$code);
			$check = $this->db->fetch("SELECT * FROM `verifications` WHERE ".data_array_mysql(' AND ',$array_data));
			if(isset($check->receiver) && $check->receiver == $receiver && $check->date+$C->verification_expire>time()){
				$this->db->query("DELETE FROM `verifications` WHERE ".data_array_mysql(' AND ',array('receiver'=>$receiver)));
				return true;
			}else
				return false;
		}
		public function load_langfile($filename)
		{
			if( ! isset($this->tmp_loaded_langfiles) ) {
				$this->tmp_loaded_langfiles	= array();
			}
			$this->tmp_loaded_langfiles[]	= $filename;
			global $C;
			$lang	= array();
			ob_start();
			require( $C->path_languages.$GLOBALS['C']->LANGUAGE.'/'.$filename );
			ob_end_clean();
			if( ! is_array($lang) ) {
				return FALSE;
			}
			foreach($lang as $k=>$v) {
				$this->lang_data[$k]	= $v;
			}
		}

		public function lang($key, $replace_strings=array(), $in_another_language=FALSE)
		{
			global $C;
                        $replace_strings["#site_url#"] = $C->SITE_URL;
			if( $in_another_language && $in_another_language!=$GLOBALS['C']->LANGUAGE && is_dir($GLOBALS['C']->INCPATH.'languages/'.$in_another_language) ) {
				return $this->lang_in_another_language($key, $replace_strings, $in_another_language);
			}
			if( empty($key) ) {
				return '';
			}
			if( ! isset($this->lang_data[$key]) ) {
                            // if(!in_array("\"{$key}\"=>\"\",", explode("\n", file_get_contents("extraWords.txt"))))
                                // file_put_contents("extraWords.txt", "\"{$key}\"=>\"\",\n",8);
                            return $key;
			}
			$txt	= $this->lang_data[$key];
			if( 0 == count($replace_strings) ) {
				return $txt;
			}
			return str_replace(array_keys($replace_strings), array_values($replace_strings), $txt);
		}

		public function lang_in_another_language($key, $replace_strings=array(), $in_language=FALSE)
		{
			if( empty($key) ) {
				return '';
			}
			if( ! isset($this->tmp_loaded_langfiles) ) {
				return '';
			}
			$lang_data	= array();
			foreach($this->lang_data as $k=>$v) {
				$lang_data[$k]	= $v;
			}
			if( $in_language && is_dir($GLOBALS['C']->INCPATH.'languages/'.$in_language) ) {
				foreach($this->tmp_loaded_langfiles as $f) {
					$lang	= array();
					ob_start();
					require( $GLOBALS['C']->INCPATH.'languages/'.$in_language.'/'.$f );
					ob_end_clean();
					if( is_array($lang) ) {
						foreach($lang as $k=>$v) {
							$lang_data[$k]	= $v;
						}
					}
				}
			}
			if( ! isset($lang_data[$key]) ) {
				return '';
			}
			$txt	= $lang_data[$key];
			if( 0 == count($replace_strings) ) {
				return $txt;
			}
			return str_replace(array_keys($replace_strings), array_values($replace_strings), $txt);
		}

		public function param($key)
		{
			if( FALSE == isset($this->params->$key) ) {
				return FALSE;
			}

			$value	= $this->params->$key;
			if( is_numeric($value) && substr($value,0,1)!="+") {
				return floatval($value);
			}
			if( $value=="true" || $value=="TRUE" ) {
				return TRUE;
			}
			if( $value=="false" || $value=="FALSE" ) {
				return FALSE;
			}
			return $value;
		}

		public function redirect($loc="/" ,$type=301, $abs=FALSE)
		{
			global $C;
			if( ! $abs && preg_match('/^http(s)?\:\/\//', $loc) ) {
				$abs	= TRUE;
			}
			if( ! $abs ) {
				if( $loc[0] != '/' ) {
					$loc	= $C->SITE_URL.$loc;
				}
			}
			if( ! headers_sent() ) {
				header('Location: '.$loc,true,$type);
			}
			echo '<meta http-equiv="refresh" content="0;url='.$loc.'" />';
			echo '<script type="text/javascript"> self.location = "'.$loc.'"; </script>';
			exit;
		}
		public function pay($array_data)
		{
                    $u = $this->user->get(array("id"=>$array_data['who']),true);
                    if(intval($u->withdrawal_amount)>=$array_data['amount']){

                        $array_data['status']=1;
                        $array_data['gate_way']=0;
                        $array_data['amount'] = $array_data['amount'];
                        $this->user->add_finance($array_data);
                        $this->user->get(array("id"=>$array_data['who']),true);
                        return true;
                    }else{
                        $array_data['status']=0;
                        $array_data['gate_way']=1;//mellat
                        $finance_id = $this->user->add_finance($array_data,true);
                        $this->redirect("payment/finance_id:".$finance_id);
                        return false;
                    }
		}
	}

?>