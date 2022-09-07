<?php
	class core extends baseCore{
        public function get_user_by_id($id,$refresh=false,$available_columns=null){
			GLOBAL $C;
			$cache_unique = "get_user_by_id13452_".$id.($available_columns!=null?implode(',',$available_columns):"");
			$_user = $this->cache->get($cache_unique);
			if(!$_user || $refresh){
				$_user = parent::get_user_by_id($id,$refresh,$available_columns);
				//$_user->informations = $this->db->fetch_all("SELECT * FROM `informations` WHERE `user_id`=".$_user->id);
				//$_user->notifications = $this->db->fetch_field("SELECT count(*) FROM `notifications` WHERE `seen`=0 AND `user_id`=".$_user->id);
			}
			if($available_columns!=null)
				unset($_user->informations);
			
			return $_user;
		}
        public function add_verification($user_id,$email,$phone,$code,$status){
			// echo "SELECT count(*) FROM phones_confirms WHERE `date`>".(time()-86400)." AND ".data_array_mysql(" OR ",["ip"=>ip2long(IP()),"phone"=>$phone]);
			$_send = false;
			if(!empty($email)){
				$_mail = new mail;
				$_mail->setTo($email,$email);
				$_mail->setMessage($this->page->lang("verificationMailBody",["#secret#"=>$code]));
				$_send = $_mail->send();
			}
			if($_send && intval($this->db->fetch_field("SELECT count(*) FROM `verifications` WHERE `date`>".(time()-86400)." AND (".data_array_mysql(" OR ",["ip"=>ip2long(IP()),"email"=>$email]).")"))<10){
				parent::add_verification($user_id,$email,$phone,$code,$status);
				return true;
			}else{
				return false;
			}
		}
		public function get_media_by_id($id,$refresh=false,$available_columns=null){
			GLOBAL $C;
			$_media = parent::get_media_by_id($id,$refresh,$available_columns);
			$_media->url = $C->SITE_URL.$_media->path;
			$_media->thumbnail_url = $C->SITE_URL.$_media->thumbnail;
			return $_media;
		}
		public function delete_media_by_id($id){
			$__media = $this->get_media_by_id($id);
			if(unlink($__media->path)&&unlink($__media->thumbnail))
			{
				return parent::delete_media_by_id($id);
			}
			return false;
		}
		public function get_city_by_id($id,$refresh=false,$available_columns=null){
			GLOBAL $C;
			$_city = parent::get_city_by_id($id,$refresh,$available_columns);
			$_city->url = $C->SITE_URL.$_city->slug."/";
			return $_city;
		}
		public function get_province_by_id($id,$refresh=false,$available_columns=null){
			GLOBAL $C;
			$_province = parent::get_province_by_id($id,$refresh,$available_columns);
			$_province->url = $C->SITE_URL.'province/'.$_province->slug."/";
			return $_province;
		}
		public function get_country_by_id($id,$refresh=false,$available_columns=null){
			GLOBAL $C;
			$_country = parent::get_country_by_id($id,$refresh,$available_columns);
			$_country->url = $C->SITE_URL.'country/'.$_country->slug."/";
			return $_country;
		}
		public function get_category_by_id($id,$refresh=false,$available_columns=null){
			GLOBAL $C;
			$cache_unique = "get_category_by_id1352_".$id.($available_columns!=null?implode(',',$available_columns):"");
			$_category = $this->cache->get($cache_unique);
			
			if(!$_category || $refresh){
				$_category = parent::get_category_by_id($id,$refresh,$available_columns);
				if(!$_category)return false;
				$_category->parent_ids = [];
				$_category->uri = "";
				$_c_t =	$_category->parent_id;
				while($_c_t!=0){
					$__cat = parent::get_category_by_id($_c_t);
					$_category->uri = $__cat->slug.'/';
					$_c_t = $__cat->parent_id;
					if($_c_t!=null)
					$_category->parent_ids[] = $_c_t;
				}
				$_category->uri .= $_category->slug.'/';
				
				$this->cache->set($cache_unique,$_category,$C->CACHE_EXPIRE_DATE);
			}
			if($available_columns!=null)
				unset($_category->informations);
				
			return $_category;
		}
		public function get_post_by_id($id,$refresh=false,$available_columns=null){
			GLOBAL $C;
			$cache_unique = "get_post_by_id13452_".$id.($available_columns!=null?implode(',',$available_columns):"");
			$_post = $this->cache->get($cache_unique);
			
			if(!$_post || $refresh){
				$_post = parent::get_post_by_id($id,$refresh,$available_columns);
				//$_user->informations = $this->db->fetch_all("SELECT * FROM `informations` WHERE `user_id`=".$_user->id);
				//$_user->notifications = $this->db->fetch_field("SELECT count(*) FROM `notifications` WHERE `seen`=0 AND `user_id`=".$_user->id);
				/*media */
				$_post->media	=	[];
				$_media = $this->db->fetch_all("SELECT id FROM `media` WHERE `post_id`=".$_post->id);
				if(count($_media)==0){
					$_post->media[]	=(object)[
						"url"=>$C->SITE_URL."no-image.png",
						"thumbnail_url"=>$C->SITE_URL."no-image.png",
					];
				}else{
					foreach($_media as $__media)
						$_post->media[]	=	$this->get_media_by_id($__media->id);
				}
				/*values */
				$_post->values = [];
				$_values = $this->db->fetch_all("SELECT `field_id`,`value` FROM `posts_values` WHERE `post_id`=".$_post->id);
				foreach($_values as $_value){
					$_post->values[$_value->field_id] = $_value->value;
				}
				/*categories */
				$_post->categories = [];
				$_categories = $this->db->fetch_all("SELECT `category_id` FROM `posts_categories` WHERE `post_id`=".$_post->id);
				$_parent_id = 0;
				while(count($_categories)>0){
					foreach($_categories as $_key=>$_item){
						$_category = $this->get_category_by_id($_item->category_id);
						if($_category->parent_id==$_parent_id){
							$_post->categories[] = $_category->id;
							$_parent_id = $_category->id;
							unset($_categories[$_key]);
						}
					}
				}
				//$_post->categories = array_reverse($_post->categories);
				/* end categories */
				$_post->url = $C->SITE_URL."p/".encode($_post->id)."/";
				$this->cache->set($cache_unique,$_post,$C->CACHE_EXPIRE_DATE);
			}
			if($available_columns!=null)
				unset($_post->informations);
			
			return $_post;
		}
		public function get_list_category_fields($categories_ids,$required=null,$searchable=null,$refresh=false){
			GLOBAL $C;
			if(!is_array($categories_ids))
				$categories_ids=[$categories_ids];
			$cache_unique = "get_cat_fields_by_id135_".implode(",",$categories_ids);
			$_fields = $this->cache->get($cache_unique);
			if(!$_fields || $refresh){
				$_fields = [];
				$required_q = "";
				if($required)
					$required_q = " AND `required`=1";
				$searchable_q	="";
				if($searchable)
					$searchable_q = " AND `search_type` IS NOT NULL";
				$_result = $this->db->fetch_all("SELECT `id` FROM `fields` WHERE `category_id` in (".implode(",",$categories_ids).")".$required_q.$searchable_q);
				foreach($_result as $item){
					$_fields[] = $item->id;
				}
				$this->cache->set($cache_unique,$_fields,$C->CACHE_EXPIRE_DATE);
			}
			$output = [];
			foreach($_fields as $field_id){
				$output[] = $this->get_field_by_id($field_id);
			}
			return $output;
		}
	}