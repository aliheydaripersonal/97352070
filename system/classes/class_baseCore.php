<?php
	class baseCore{
		public function __construct()
		{
			$this->id	= FALSE;
			$this->C	= new stdClass;
			$this->info	= new stdClass;
			$this->cache	= & $GLOBALS['cache'];
			$this->network	= & $GLOBALS['network'];
			$this->db		= & $GLOBALS['db'];
			$this->page		= & $GLOBALS['page'];
		}
		//main funcs
		public function merchant_generator(){
			return random_string(10).time().':'.random_string(16);
		}
		public function token_generator(){
			return random_string(10).time().random_string(20).rand(100000,999999).random_string(10);
		}
		public function add($table,$data){
			return $this->db->insert($table,$data);
		}
		public function get($table,$data,$refresh=false,$select="*",$available_columns=null){
			global $C;
			$cache_unique = "get".$table.make_unique_cache($data).$select;
			$result = $this->cache->get($cache_unique);
			if(!$result || $refresh){
				// if($table=="categories"){
				// 	var_dump($data);
				// 	echo "SELECT ".$select." FROM `".$table."` WHERE ".data_array_mysql(" AND ",$data);
				// }
				$result = $this->db->fetch("SELECT ".$select." FROM `".$table."` WHERE ".data_array_mysql(" AND ",$data));
				
				if(!$result)
					return false;
				$this->cache->set($cache_unique,$result,$C->CACHE_EXPIRE_DATE);
			}
			if($available_columns==null){
				$available_columns = array_keys((array) $result);
			}
			$tmp = (object) [];
			foreach($available_columns as $column){
				if($column=="price"||$column=="amount"||substr($column,strlen($column)-4,4)=="_fee"||substr($column,strlen($column)-7,7)=="balance"){
					$tmp->$column = floatval($result->$column);
				}else{
					$tmp->$column = $result->$column;
				}
			}
			$result = $tmp;
			
			return $result;
		}
		public function get_list($type="loadMore",$table,$data,$limit,$from,$order="`id` DESC"){
			$information = new stdClass;
            $WHERE = "";
            if(count($data)>0)
                $WHERE = "WHERE ".data_array_mysql(" AND ",$data);
			if($type=="loadMore"){
				$data[] = (object) ["type"=>"direct","query"=>"`id`<".$from];
				$information->result = $this->db->fetch_all("SELECT `id` FROM `".$table."` $WHERE ORDER BY ".$order." LIMIT ".$from.",".$limit);
			}elseif($type=="paging"){
				$start = ($from-1) * $limit;
				$information->result = $this->db->fetch_all("SELECT `id` FROM `".$table."` $WHERE ORDER BY ".$order." LIMIT ".$start.",".$limit);
				$information->all_count = intval($this->db->fetch_field("SELECT count(`id`) FROM `".$table."` $WHERE"));
				$information->page_count = ceil($information->all_count/$limit);
				$information->current_page = intval($from);
			}elseif($type=="all"){
				$information->result = $this->db->fetch_all("SELECT `id` FROM `".$table."` $WHERE ORDER BY ".$order.($limit!=null?" LIMIT ".$limit:""));
				$information->all_count = count($information->result);
			}
			return $information;
		}
		public function update($table,$data,$where_data){
			$this->db->query("UPDATE `".$table."` SET ".data_array_mysql(",",$data)."  WHERE ".data_array_mysql(" AND ",$where_data));
			return true;
		}
		public function delete($table,$where_data){
			$this->db->query("DELETE FROM `".$table."`  WHERE ".data_array_mysql(" AND ",$where_data));
			return true;
		}
		public function exist($table,$data,$refresh=false){
			if(intval($this->db->fetch_field("SELECT 1 FROM `".$table."` WHERE ".data_array_mysql(",",$data)))==1)
				return true;
			return false;
		}


		//for this project{


			public function get_access_by_token($token,$refresh=false,$available_columns=null){
				$information = $this->get("accesses",["token"=>$token],$refresh,"id");
				if(!$information)
				return false;
				return $this->get_access_by_id($information->id,$refresh,$available_columns);
				}
				
				public function exist_access_by_token($token){
				return $this->exist("accesses",["token"=>$token]);
				}
				
				public function add_access($user_id,$active,$expire_date){
				$token = $this->token_generator();
				$i = 0;
				while($i==0){
				if(!$this->exist_access_by_token($token)){
				$i = 1;
				return $this->add("accesses",["user_id"=>$user_id,"token"=>$token,"ip"=>ip2long(IP()),"active"=>$active,"date"=>time(),"expire_date"=>$expire_date]);
				}else{
				$token = $this->token_generator();
				}
				}
				}
				
				public function update_access_by_id($id,$active=null,$expire_date=null){
				$inputs_set_data = ["active"=>$active,"expire_date"=>$expire_date];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("accesses",$set_data,["id"=>$id]);
				$this->get_access_by_id($id,true);
				return $data;
				}
				
				public function get_access_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("accesses",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_access_by_id($id){$this->delete("logs",["access_id"=>$id]);return $this->delete("accesses",["id"=>$id]);
				}
				
				public function exist_access_by_id($id){
				return $this->exist("accesses",["id"=>$id]);
				}
				
				public function get_list_access($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$user_id=null,$token=null){
				$data = ["id"=>$id,"user_id"=>$user_id,$token!==null?["type"=>"direct","query"=>"`token` LIKE '%{$token}%'"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"accesses",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_access_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function get_category_by_slug($slug,$refresh=false,$available_columns=null){
				$information = $this->get("categories",["slug"=>$slug],$refresh,"id");
				if(!$information)
				return false;
				return $this->get_category_by_id($information->id,$refresh,$available_columns);
				}
				
				public function exist_category_by_slug($slug){
				return $this->exist("categories",["slug"=>$slug]);
				}
				
				public function update_category_by_id($id,$name=null,$description=null,$content=null,$status=null){
				$inputs_set_data = ["name"=>$name,"description"=>$description,"content"=>$content,"status"=>$status];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("categories",$set_data,["id"=>$id]);
				$this->get_category_by_id($id,true);
				return $data;
				}
				
				public function get_category_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("categories",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_category_by_id($id){$this->delete("fields",["category_id"=>$id]);$this->delete("posts_categories",["category_id"=>$id]);return $this->delete("categories",["id"=>$id]);
				}
				
				public function exist_category_by_id($id){
				return $this->exist("categories",["id"=>$id]);
				}
				
				public function get_list_category($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$slug=null,$parent_id=null,$status=null){
				$data = ["id"=>$id,$slug!==null?["type"=>"direct","query"=>"`slug` LIKE '%{$slug}%'"]:null,"parent_id"=>$parent_id,"status"=>$status];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"categories",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_category_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_category($name,$slug,$description,$content,$parent_id,$status){
				return $this->add("categories",["name"=>$name,"slug"=>$slug,"description"=>$description,"content"=>$content,"parent_id"=>$parent_id,"status"=>$status]);
				}
				
				public function get_city_by_slug($slug,$refresh=false,$available_columns=null){
				$information = $this->get("cities",["slug"=>$slug],$refresh,"id");
				if(!$information)
				return false;
				return $this->get_city_by_id($information->id,$refresh,$available_columns);
				}
				
				public function exist_city_by_slug($slug){
				return $this->exist("cities",["slug"=>$slug]);
				}
				
				public function update_city_by_id($id,$name=null,$alternates=null,$timezone=null,$population=null,$latitude=null,$longitude=null){
				$inputs_set_data = ["name"=>$name,"alternates"=>$alternates,"timezone"=>$timezone,"population"=>$population,"latitude"=>$latitude,"longitude"=>$longitude];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("cities",$set_data,["id"=>$id]);
				$this->get_city_by_id($id,true);
				return $data;
				}
				
				public function get_city_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("cities",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_city_by_id($id){$this->delete("posts",["city_id"=>$id]);return $this->delete("cities",["id"=>$id]);
				}
				
				public function exist_city_by_id($id){
				return $this->exist("cities",["id"=>$id]);
				}
				
				public function get_list_city($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$country_id=null,$province_id=null,$slug=null){
				$data = ["id"=>$id,"country_id"=>$country_id,"province_id"=>$province_id,$slug!==null?["type"=>"direct","query"=>"`slug` LIKE '%{$slug}%'"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"cities",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_city_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_city($country_id,$province_id,$name,$alternates,$slug,$timezone,$population,$latitude,$longitude){
				return $this->add("cities",["country_id"=>$country_id,"province_id"=>$province_id,"name"=>$name,"alternates"=>$alternates,"slug"=>$slug,"timezone"=>$timezone,"population"=>$population,"latitude"=>$latitude,"longitude"=>$longitude]);
				}
				
				public function get_country_by_slug($slug,$refresh=false,$available_columns=null){
				$information = $this->get("countries",["slug"=>$slug],$refresh,"id");
				if(!$information)
				return false;
				return $this->get_country_by_id($information->id,$refresh,$available_columns);
				}
				
				public function exist_country_by_slug($slug){
				return $this->exist("countries",["slug"=>$slug]);
				}
				
				public function update_country_by_id($id,$name=null,$iso=null,$contient=null,$currency=null,$currency_iso=null){
				$inputs_set_data = ["name"=>$name,"iso"=>$iso,"contient"=>$contient,"currency"=>$currency,"currency_iso"=>$currency_iso];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("countries",$set_data,["id"=>$id]);
				$this->get_country_by_id($id,true);
				return $data;
				}
				
				public function get_country_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("countries",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_country_by_id($id){$this->delete("cities",["country_id"=>$id]);$this->delete("countries_languages",["country_id"=>$id]);$this->delete("posts",["country_id"=>$id]);$this->delete("provinces",["country_id"=>$id]);return $this->delete("countries",["id"=>$id]);
				}
				
				public function exist_country_by_id($id){
				return $this->exist("countries",["id"=>$id]);
				}
				
				public function get_list_country($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$slug=null){
				$data = ["id"=>$id,$slug!==null?["type"=>"direct","query"=>"`slug` LIKE '%{$slug}%'"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"countries",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_country_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_country($name,$iso,$contient,$currency,$currency_iso,$slug){
				return $this->add("countries",["name"=>$name,"iso"=>$iso,"contient"=>$contient,"currency"=>$currency,"currency_iso"=>$currency_iso,"slug"=>$slug]);
				}
				
				public function get_list_countries_language($load_type="loadMore",$available_columns=null,$limit,$from,$order,$country_id=null,$language_id=null){
				$data = ["country_id"=>$country_id,"language_id"=>$language_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"countries_languages",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_countries_language_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_countries_language($country_id,$language_id){
				return $this->add("countries_languages",["country_id"=>$country_id,"language_id"=>$language_id]);
				}
				
				public function get_list_favorite($load_type="loadMore",$available_columns=null,$limit,$from,$order,$user_id=null,$post_id=null){
				$data = ["user_id"=>$user_id,"post_id"=>$post_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"favorites",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_favorite_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_favorite($user_id,$post_id){
				return $this->add("favorites",["user_id"=>$user_id,"post_id"=>$post_id,"date"=>time()]);
				}
				
				public function update_field_by_id($id,$type=null,$name=null,$required=null,$search_type=null){
				$inputs_set_data = ["type"=>$type,"name"=>$name,"required"=>$required,"search_type"=>$search_type];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("fields",$set_data,["id"=>$id]);
				$this->get_field_by_id($id,true);
				return $data;
				}
				
				public function get_field_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("fields",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_field_by_id($id){$this->delete("fields_options",["field_id"=>$id]);$this->delete("posts_values",["field_id"=>$id]);return $this->delete("fields",["id"=>$id]);
				}
				
				public function exist_field_by_id($id){
				return $this->exist("fields",["id"=>$id]);
				}
				
				public function get_list_field($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$category_id=null,$type=null){
				$data = ["id"=>$id,"category_id"=>$category_id,"type"=>$type];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"fields",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_field_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_field($category_id,$type,$name,$required,$search_type){
				return $this->add("fields",["category_id"=>$category_id,"type"=>$type,"name"=>$name,"required"=>$required,"search_type"=>$search_type]);
				}
				
				public function update_fields_option_by_id($id,$label=null){
				$inputs_set_data = ["label"=>$label];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("fields_options",$set_data,["id"=>$id]);
				$this->get_fields_option_by_id($id,true);
				return $data;
				}
				
				public function get_fields_option_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("fields_options",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_fields_option_by_id($id){return $this->delete("fields_options",["id"=>$id]);
				}
				
				public function exist_fields_option_by_id($id){
				return $this->exist("fields_options",["id"=>$id]);
				}
				
				public function get_list_fields_option($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$field_id=null){
				$data = ["id"=>$id,"field_id"=>$field_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"fields_options",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_fields_option_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_fields_option($field_id,$label){
				return $this->add("fields_options",["field_id"=>$field_id,"label"=>$label]);
				}
				
				public function update_language_by_id($id,$name=null,$english_name=null,$iso=null){
				$inputs_set_data = ["name"=>$name,"english_name"=>$english_name,"iso"=>$iso];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("languages",$set_data,["id"=>$id]);
				$this->get_language_by_id($id,true);
				return $data;
				}
				
				public function get_language_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("languages",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_language_by_id($id){$this->delete("countries_languages",["language_id"=>$id]);return $this->delete("languages",["id"=>$id]);
				}
				
				public function exist_language_by_id($id){
				return $this->exist("languages",["id"=>$id]);
				}
				
				public function get_list_language($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$iso=null){
				$data = ["id"=>$id,"iso"=>$iso];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"languages",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_language_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_language($name,$english_name,$iso){
				return $this->add("languages",["name"=>$name,"english_name"=>$english_name,"iso"=>$iso]);
				}
				
				public function update_log_by_id($id,$type=null,$user_agent=null){
				$inputs_set_data = ["type"=>$type,"user_agent"=>$user_agent,"last_update"=>time()];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("logs",$set_data,["id"=>$id]);
				$this->get_log_by_id($id,true);
				return $data;
				}
				
				public function get_log_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("logs",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_log_by_id($id){return $this->delete("logs",["id"=>$id]);
				}
				
				public function exist_log_by_id($id){
				return $this->exist("logs",["id"=>$id]);
				}
				
				public function get_list_log($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$user_id=null,$access_id=null,$ip=null,$type=null,$start_last_update=null,$end_last_update=null){
				$data = ["id"=>$id,"user_id"=>$user_id,"access_id"=>$access_id,"ip"=>$ip,"type"=>$type,$start_last_update!==null?["type"=>"direct","query"=>"`last_update`>{$start_last_update}"]:null,$end_last_update!==null?["type"=>"direct","query"=>"`last_update`<{$end_last_update}"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"logs",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_log_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_log($user_id,$access_id,$type,$user_agent){
				return $this->add("logs",["user_id"=>$user_id,"access_id"=>$access_id,"ip"=>ip2long(IP()),"type"=>$type,"user_agent"=>$user_agent,"date"=>time(),"last_update"=>time()]);
				}
				
				public function update_media_by_id($id,$type=null,$path=null,$thumbnail=null,$width=null,$height=null){
				$inputs_set_data = ["type"=>$type,"path"=>$path,"thumbnail"=>$thumbnail,"width"=>$width,"height"=>$height];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("media",$set_data,["id"=>$id]);
				$this->get_media_by_id($id,true);
				return $data;
				}
				
				public function get_media_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("media",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_media_by_id($id){return $this->delete("media",["id"=>$id]);
				}
				
				public function exist_media_by_id($id){
				return $this->exist("media",["id"=>$id]);
				}
				
				public function get_list_media($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$post_id=null){
				$data = ["id"=>$id,"post_id"=>$post_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"media",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_media_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_media($post_id,$type,$path,$thumbnail,$width,$height){
				return $this->add("media",["post_id"=>$post_id,"type"=>$type,"path"=>$path,"thumbnail"=>$thumbnail,"width"=>$width,"height"=>$height]);
				}
				
				public function update_post_by_id($id,$title=null,$content=null,$mail=null,$phone=null,$media_count=null,$status=null,$renewal_date=null){
				$inputs_set_data = ["title"=>$title,"content"=>$content,"mail"=>$mail,"phone"=>$phone,"media_count"=>$media_count,"status"=>$status,"last_update"=>time(),"renewal_date"=>$renewal_date];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("posts",$set_data,["id"=>$id]);
				$this->get_post_by_id($id,true);
				return $data;
				}
				
				public function get_post_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("posts",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_post_by_id($id){$this->delete("favorites",["post_id"=>$id]);$this->delete("media",["post_id"=>$id]);$this->delete("posts_categories",["post_id"=>$id]);$this->delete("posts_stats",["post_id"=>$id]);$this->delete("posts_values",["post_id"=>$id]);$this->delete("reports",["post_id"=>$id]);return $this->delete("posts",["id"=>$id]);
				}
				
				public function exist_post_by_id($id){
				return $this->exist("posts",["id"=>$id]);
				}
				
				public function get_list_post($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$user_id=null,$title=null,$media_count=null,$status=null,$start_renewal_date=null,$end_renewal_date=null){
				$data = ["id"=>$id,"user_id"=>$user_id,$title!==null?["type"=>"direct","query"=>"`title` LIKE '%{$title}%'"]:null,"media_count"=>$media_count,"status"=>$status,$start_renewal_date!==null?["type"=>"direct","query"=>"`renewal_date`>{$start_renewal_date}"]:null,$end_renewal_date!==null?["type"=>"direct","query"=>"`renewal_date`<{$end_renewal_date}"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"posts",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_post_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_post($country_id,$province_id,$city_id,$user_id,$title,$content,$mail,$phone,$media_count,$status,$renewal_date){
				return $this->add("posts",["country_id"=>$country_id,"province_id"=>$province_id,"city_id"=>$city_id,"user_id"=>$user_id,"title"=>$title,"content"=>$content,"mail"=>$mail,"phone"=>$phone,"media_count"=>$media_count,"status"=>$status,"date"=>time(),"last_update"=>time(),"renewal_date"=>$renewal_date]);
				}
				
				public function get_list_posts_category($load_type="loadMore",$available_columns=null,$limit,$from,$order,$post_id=null,$category_id=null){
				$data = ["post_id"=>$post_id,"category_id"=>$category_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"posts_categories",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_posts_category_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_posts_category($post_id,$category_id){
				return $this->add("posts_categories",["post_id"=>$post_id,"category_id"=>$category_id]);
				}
				
				public function get_list_posts_stat($load_type="loadMore",$available_columns=null,$limit,$from,$order,$post_id=null){
				$data = ["post_id"=>$post_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"posts_stats",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_posts_stat_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_posts_stat($post_id,$views,$sended_mails,$calls){
				return $this->add("posts_stats",["post_id"=>$post_id,"views"=>$views,"sended_mails"=>$sended_mails,"calls"=>$calls,"date"=>time()]);
				}
				
				public function get_list_posts_value($load_type="loadMore",$available_columns=null,$limit,$from,$order,$post_id=null,$field_id=null){
				$data = ["post_id"=>$post_id,"field_id"=>$field_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"posts_values",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_posts_value_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_posts_value($post_id,$field_id,$value){
				return $this->add("posts_values",["post_id"=>$post_id,"field_id"=>$field_id,"value"=>$value]);
				}
				
				public function get_province_by_slug($slug,$refresh=false,$available_columns=null){
				$information = $this->get("provinces",["slug"=>$slug],$refresh,"id");
				if(!$information)
				return false;
				return $this->get_province_by_id($information->id,$refresh,$available_columns);
				}
				
				public function exist_province_by_slug($slug){
				return $this->exist("provinces",["slug"=>$slug]);
				}
				
				public function update_province_by_id($id,$name=null){
				$inputs_set_data = ["name"=>$name];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("provinces",$set_data,["id"=>$id]);
				$this->get_province_by_id($id,true);
				return $data;
				}
				
				public function get_province_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("provinces",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_province_by_id($id){$this->delete("cities",["province_id"=>$id]);$this->delete("posts",["province_id"=>$id]);return $this->delete("provinces",["id"=>$id]);
				}
				
				public function exist_province_by_id($id){
				return $this->exist("provinces",["id"=>$id]);
				}
				
				public function get_list_province($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$country_id=null,$slug=null){
				$data = ["id"=>$id,"country_id"=>$country_id,$slug!==null?["type"=>"direct","query"=>"`slug` LIKE '%{$slug}%'"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"provinces",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_province_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_province($country_id,$name,$slug){
				return $this->add("provinces",["country_id"=>$country_id,"name"=>$name,"slug"=>$slug]);
				}
				
				public function update_report_by_id($id,$type=null,$description=null,$status=null){
				$inputs_set_data = ["type"=>$type,"description"=>$description,"status"=>$status];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("reports",$set_data,["id"=>$id]);
				$this->get_report_by_id($id,true);
				return $data;
				}
				
				public function get_report_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("reports",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_report_by_id($id){return $this->delete("reports",["id"=>$id]);
				}
				
				public function exist_report_by_id($id){
				return $this->exist("reports",["id"=>$id]);
				}
				
				public function get_list_report($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$user_id=null,$post_id=null){
				$data = ["id"=>$id,"user_id"=>$user_id,"post_id"=>$post_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"reports",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_report_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_report($type,$user_id,$post_id,$description,$status){
				return $this->add("reports",["type"=>$type,"user_id"=>$user_id,"post_id"=>$post_id,"description"=>$description,"status"=>$status]);
				}
				
				public function get_list_searche($load_type="loadMore",$available_columns=null,$limit,$from,$order,$user_id=null){
				$data = ["user_id"=>$user_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"searches",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_searche_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_searche($user_id,$query,$count){
				return $this->add("searches",["user_id"=>$user_id,"query"=>$query,"count"=>$count,"date"=>time()]);
				}
				
				public function add_setting($name,$value){
				return $this->add("settings",["name"=>$name,"value"=>$value]);
				}
				
				public function update_temporary_by_reference($reference,$type=null,$data=null,$expire_date=null){
				$inputs_set_data = ["type"=>$type,"data"=>$data,"expire_date"=>$expire_date];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("temporary",$set_data,["reference"=>$reference]);
				$this->get_temporary_by_reference($reference,true);
				return $data;
				}
				
				public function get_temporary_by_reference($reference,$refresh=false,$available_columns=null){
				return $this->get("temporary",["reference"=>$reference],$refresh,"*",$available_columns);
				}
				
				public function delete_temporary_by_reference($reference){return $this->delete("temporary",["reference"=>$reference]);
				}
				
				public function exist_temporary_by_reference($reference){
				return $this->exist("temporary",["reference"=>$reference]);
				}
				
				public function get_list_temporary($load_type="loadMore",$available_columns=null,$limit,$from,$order,$user_id=null){
				$data = ["user_id"=>$user_id];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"temporary",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_temporary_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_temporary($type,$user_id,$data,$expire_date){
				return $this->add("temporary",["reference"=>$reference,"type"=>$type,"user_id"=>$user_id,"data"=>$data,"date"=>time(),"expire_date"=>$expire_date]);
				}
				
				public function get_user_by_mail($mail,$refresh=false,$available_columns=null){
				$information = $this->get("users",["mail"=>$mail],$refresh,"id");
				if(!$information)
				return false;
				return $this->get_user_by_id($information->id,$refresh,$available_columns);
				}
				
				public function exist_user_by_mail($mail){
				return $this->exist("users",["mail"=>$mail]);
				}
				
				public function update_user_by_id($id,$phone=null,$firstname=null,$lastname=null,$password=null,$status=null){
				$inputs_set_data = ["phone"=>$phone,"firstname"=>$firstname,"lastname"=>$lastname,"password"=>$password,"status"=>$status];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("users",$set_data,["id"=>$id]);
				$this->get_user_by_id($id,true);
				return $data;
				}
				
				public function get_user_by_id($id,$refresh=false,$available_columns=null){
				return $this->get("users",["id"=>$id],$refresh,"*",$available_columns);
				}
				
				public function delete_user_by_id($id){$this->delete("accesses",["user_id"=>$id]);$this->delete("favorites",["user_id"=>$id]);$this->delete("logs",["user_id"=>$id]);$this->delete("posts",["user_id"=>$id]);$this->delete("reports",["user_id"=>$id]);$this->delete("searches",["user_id"=>$id]);$this->delete("temporary",["user_id"=>$id]);$this->delete("verifications",["user_id"=>$id]);return $this->delete("users",["id"=>$id]);
				}
				
				public function exist_user_by_id($id){
				return $this->exist("users",["id"=>$id]);
				}
				
				public function get_list_user($load_type="loadMore",$available_columns=null,$limit,$from,$order="`id` DESC",$id=null,$mail=null,$phone=null,$start_date=null,$end_date=null){
				$data = ["id"=>$id,$mail!==null?["type"=>"direct","query"=>"`mail` LIKE '%{$mail}%'"]:null,$phone!==null?["type"=>"direct","query"=>"`phone` LIKE '%{$phone}%'"]:null,$start_date!==null?["type"=>"direct","query"=>"`date`>{$start_date}"]:null,$end_date!==null?["type"=>"direct","query"=>"`date`<{$end_date}"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"users",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_user_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_user($mail,$phone,$firstname,$lastname,$password,$status){
				return $this->add("users",["mail"=>$mail,"phone"=>$phone,"firstname"=>$firstname,"lastname"=>$lastname,"password"=>$password,"ip"=>ip2long(IP()),"date"=>time(),"status"=>$status]);
				}
				
				public function update_verification_by_code($code,$email=null,$phone=null,$status=null){
				$inputs_set_data = ["email"=>$email,"phone"=>$phone,"status"=>$status];
				$set_data = [];
				foreach($inputs_set_data as $key=>$input){
				if($input!==null)
				$set_data[$key] = $input;
				}
				$data = $this->update("verifications",$set_data,["code"=>$code]);
				$this->get_verification_by_code($code,true);
				return $data;
				}
				
				public function get_verification_by_code($code,$refresh=false,$available_columns=null){
				return $this->get("verifications",["code"=>$code],$refresh,"*",$available_columns);
				}
				
				public function delete_verification_by_code($code){return $this->delete("verifications",["code"=>$code]);
				}
				
				public function exist_verification_by_code($code){
				return $this->exist("verifications",["code"=>$code]);
				}
				
				public function get_list_verification($load_type="loadMore",$available_columns=null,$limit,$from,$order,$user_id=null,$email=null,$phone=null){
				$data = ["user_id"=>$user_id,$email!==null?["type"=>"direct","query"=>"`email` LIKE '%{$email}%'"]:null,$phone!==null?["type"=>"direct","query"=>"`phone` LIKE '%{$phone}%'"]:null];
				foreach($data as $key=>$value){
				if($data[$key]===null){
				unset($data[$key]);
				}
				}
				
				$data = $this->get_list($load_type,"verifications",$data,$limit,$from,$order);
				foreach($data->result as $key=>$row){
				$data->result[$key] = $this->get_verification_by_id($row->id,false,$available_columns);
				}
				return $data;
				}
				
				public function add_verification($user_id,$email,$phone,$code,$status){
				return $this->add("verifications",["user_id"=>$user_id,"email"=>$email,"phone"=>$phone,"code"=>$code,"ip"=>ip2long(IP()),"status"=>$status,"date"=>time()]);
				}
	}