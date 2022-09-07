<?php

	class network
	{

		public function __construct()
		{
			$this->id	= FALSE;
			$this->C	= new stdClass;
			$this->info	= new stdClass;
			$this->cache	= & $GLOBALS['cache'];
			$this->db		= & $GLOBALS['db'];
			$this->core		= & $GLOBALS['core'];
			$this->page		= & $GLOBALS['page'];
		}

		public function LOAD()
		{
			if( $this->id ) {
				return FALSE;
			}
			$this->load_network_settings();
			$this->info	= (object) array(
				'id'	=> 1,
			);
			$this->id	= $this->info->id;
			return $this->id;
		}

		public function load_network_settings()
		{
			global $C;
			
			$db	= &$this->db;
			
			$cache_unique = "main_system_settings23";
			$sttings = $this->cache->get($cache_unique);
			if(!$sttings){
				$sttings	= $db->fetch_all('SELECT * FROM settings');
				$this->cache->set($cache_unique, $sttings, $C->CACHE_EXPIRE_DATE);
			}
			foreach($sttings as $obj){
				$this->C->{$obj->name}	= stripslashes($obj->value);
			}
			
			foreach($this->C as $k=>$v) {
				$C->$k	= & $this->C->$k;
			}


			$current_language	= new stdClass;
			include($C->path_languages.$C->LANGUAGE.'/language.php');
			setlocale(LC_ALL, $current_language->php_locale);

			if( ! isset($C->DEF_TIMEZONE) ) {
				$C->DEF_TIMEZONE	= $current_language->php_timezone;
			}
			date_default_timezone_set($C->DEF_TIMEZONE);
			$C->OUTSIDE_SITE_TITLE	= $C->SITE_TITLE;
		}
		public function get_permalink($permalink)
		{
			$db	= &$this->db;
			$r	= $db->query('SELECT target,type FROM permalinks WHERE permalink="'.$permalink.'" LIMIT 1', FALSE);
			$obj = $db->fetch_object($r);
			return $obj;
		}
		public function get_user($where,$specific_data=false)
		{
			if(!isset($where))
				return false;

			if($specific_data==false)
				$specific_data = '*';

			$data_for_implode = 'WHERE '.data_array_mysql(" AND ",$where);

			if(count(explode(',',$specific_data))>1){
				$r	= $this->db->query('SELECT '.$specific_data.' FROM users '.$data_for_implode.' LIMIT 1', FALSE);
				$obj = $this->db->fetch_object($r);
			}else{
				$obj = $this->db->fetch_field('SELECT '.$specific_data.' FROM users '.$data_for_implode.' LIMIT 1', FALSE);
			}
			return $obj;
		}
		public function exist_user($where)
		{
			if(!isset($where))
				return false;
			$data_for_implode = 'WHERE '.data_array_mysql(" AND ",$where);
			if($this->db->fetch_field('SELECT count(id) FROM users '.$data_for_implode.' LIMIT 1')==1){
				return true;
			}
			return false;
		}

		public function temporary_exist($reference)
		{
			$reference = $this->db->escape($reference);
			if($this->db->fetch_field('SELECT 1 FROM `temporary` WHERE `reference`="'.$reference.'" LIMIT 1')){
				return true;
			}else{
				return false;
			}
		}
		public function temporary_add($expire_date,$type,$data,$access_key = false)
		{
			if(empty($type) || empty($data) || empty($expire_date)){
				return false;
			}
			$reference = '';
			$reference = random_string(5).rand(102400000,902400000).random_string(15).time().rand(10240,90990).random_string(2).rand(10240,90990);
			while($this->db->fetch_field('SELECT 1 FROM `temporary` WHERE `reference`="'.$reference.'" LIMIT 1')==1){
				$reference = random_string(5).rand(102400000,902400000).random_string(15).time().rand(10240,90990).random_string(2).rand(10240,90990);
			}
			$array_data = array('date'=>time(),'expire_date'=>$expire_date,'type'=>$type,'data'=>$data,'reference'=>$reference);
			$this->db->query('INSERT INTO temporary SET '.data_array_mysql(',',$array_data));
			return $reference;
		}
		public function temporary_remove($reference)
		{
			$array_data = array('reference'=>$reference);
			$r = $this->db->query('SELECT * FROM temporary WHERE '.data_array_mysql(' AND ',$array_data));

			$object = $this->db->fetch_object($r);

			$data = json_decode($object->data);

			switch($object->type){
				case 'file':
					unlink($data->path);
				break;
				case 'data':

				break;
			}
			$this->db->query('DELETE FROM temporary WHERE '.data_array_mysql(' AND ',$array_data));
			return true;
		}
		public function temporary_get($reference)
		{
                    if(empty($reference)){
                        return false;
                    }
                    $array_data = array('reference'=>$reference);
                    $data =	$this->db->fetch_field('SELECT `data` FROM temporary WHERE '.data_array_mysql(' AND ',$array_data));
                    if(!empty($data)){
                        return json_decode($data);
                    }
                    return false;
		}
		public function cronjob_temporary_remove()
		{
			$r = $this->db->query('SELECT * FROM temporary WHERE `expire_date`<'.time());
			while($object = $this->db->fetch_object($r)){
				$data = json_decode($object->data);
				switch($object->type){
					case 'file':
						unlink($data['path']);
						if(isset($data['video_path'])){
                                                    unlink($data['video_path']);
                                                }
						$this->db->query('DELETE FROM temporary WHERE `reference`="'.$object->reference.'"');
					break;
					case 'data':
						$this->db->query('DELETE FROM temporary WHERE `reference`="'.$object->reference.'"');
					break;
				}
			}
			return true;
		}
		public function is_favorite_post($user_id,$post_id,$refresh=false){
			GLOBAL $C;
			$cache_unique = "get_favorite_by_13452_".$user_id.'-'.$post_id;
			$_favorite = $this->cache->get($cache_unique);
			if(!$_favorite || $refresh){
				$_favorite = [$this->db->fetch_field("SELECT 1 FROM `favorites` WHERE ".data_array_mysql(" AND ",["user_id"=>$user_id,"post_id"=>$post_id]))=="1"];
				$this->cache->set($cache_unique,$_favorite,$C->CACHE_EXPIRE_DATE);
			}
			return $_favorite[0];
		}
	}
?>