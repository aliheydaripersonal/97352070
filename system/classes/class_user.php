<?php
	class user{
		public function __construct()
		{
			global $C;
			$this->network	= & $GLOBALS['network'];
			$this->cache	= & $GLOBALS['cache'];
			$this->db		= & $GLOBALS['db'];
			$this->api	= & $GLOBALS['api'];
			$this->phone	= & $GLOBALS['phone'];
			$this->core	= & $GLOBALS['core'];
			$this->request	= array();
			$this->params	= new stdClass;
			$this->params->user	= FALSE;
			$this->params->group	= FALSE;
			$this->title	= NULL;
			$this->html		= NULL;
			$this->info		= NULL;
			$this->controllers	= 	$C->path_controllers;
			$this->lang_data		= array();
			$this->tpl_name	 	= $C->name_template;
		}
		public function check_login(){
			$token = null;
			$headers = apache_request_headers();
			if(isset($headers['Authorization'])||isset($headers['authorization'])){
				$token = isset($headers['authorization'])?$headers['authorization']:$headers['Authorization'];
			}
			if(isset($_SESSION["token"])){
				$token = $_SESSION["token"];
			}
			if($token==null)
				return false;

			$access = $this->core->get_access_by_token($token);
			if(!$access)
				return false;

			$this->id = $access->user_id;
			$this->is_logged = true;
			$this->info = $this->core->get_user_by_id($this->id);
			if(!$this->info)
				return false;
			
			$this->update_log($access->id);
			return true;
		}
		public function check_admin(){
			if(!$this->check_login())
				return false;
			if($this->info->is_admin!=1)
				return false;
			return true;
		}
		private function update_log($access_id,$type=0){
			GLOBAL $C;
			$cache_unique = "lastLogId".$access_id.$type.IP();
			$last_log_id = $this->cache->get($cache_unique);
			if(!$last_log_id){
				$last_log_id = $this->db->fetch_field("SELECT `id` FROM `logs` WHERE `access_id`='".$access_id."' AND `ip`='".ip2long(IP())."' AND `type`='".$type."' AND `last_update`>".(time()-86400));
				if(!$last_log_id){
					$last_log_id = $this->core->add_log($this->id,$access_id,$type,json_encode($_SERVER['HTTP_USER_AGENT']));
				}
				$this->cache->set($cache_unique,$last_log_id,$C->CACHE_EXPIRE_DATE);
			}
			$log = $this->core->get_log_by_id($last_log_id);
			if(time() > $log->last_update+1200)
				$this->core->update_log_by_id($last_log_id,$type,json_encode($_SERVER['HTTP_USER_AGENT']));
			return true;
		}
		public function force_login(){
			if ($this->check_login()){
				$this->is_logged = true;
			}else
				$this->api->output((object) ["status"=>400,"message"=>"loginRequired","information"=>null]);
		}
		public function force_admin(){
			if ($this->check_login() && $this->info->is_admin==1)
				$this->is_logged = true;
			else
				$this->api->output((object) ["status"=>400,"message"=>"login Or having admin permit!","information"=>null]);
		}
		public function force_confirm(){
			if(intval($this->info->confirm)==1)
				return true;
			return false;
		}
		public function get_token($user_id){
			$access_id = $this->core->add_access($user_id,1,time()+(30*86400));
			$access = $this->core->get_access_by_id($access_id);
			return $access->token;
		}
		private function check_token($token){

		}
		public function registeration_steps($user_id=false){
			if(!$user_id)
				$user_id = $this->id;
			$_u = $this->core->get_user_by_id($user_id);
            //steps
            $docuemnt_status = true;
            $_documents_types = $this->db->fetch_all("SELECT * FROM `documents_types` WHERE `nationality`=".($_u->nationality=="IR"?"1":"2")." AND `type`=".$_u->type);
            $_documents = $this->db->fetch_all("SELECT `document_type_id`,`status` FROM `documents` WHERE `user_id`=".$_u->id." AND `status`!=2 GROUP BY `document_type_id`");
            // echo "1";
			// var_dump($_u->id);
			if(count($_documents)==0)
                $docuemnt_status = false;
            else{
                $all_uploaded_types = [];
                foreach($_documents as $key=>$document)$all_uploaded_types[] = $document->document_type_id;
                foreach($_documents_types as $type)
                {
                    if(intval($type->required)==1 && !in_array($type->id,$all_uploaded_types))
                        $docuemnt_status = false;
                }
            }
			$output = new stdclass;
            $output->steps = [
                (object) [
                    "name"=>"documentsAdd",
                    "url"=>count($_documents)==0?"documents/add":"documents",
                    "status"=>$docuemnt_status?"complete":"future"
                ],
                (object) [
                    "name"=>"addBankAccount",
                    "url"=>"bankAccounts/add",
                    "status"=>intval($this->db->fetch_field("SELECT 1 FROM `bank_accounts` WHERE `status`!=2 AND `user_id`=".$_u->id." LIMIT 1"))==1?"complete":"future"
                ],
                (object) [
                    "name"=>"addBusiness",
                    "url"=>"businesses/add",
                    "status"=>intval($this->db->fetch_field("SELECT 1 FROM `businesses` WHERE `user_id`=".$_u->id." LIMIT 1"))==1?"complete":"future"
                ],
                // (object) [
                    // "name"=>"waitingForShaparak",
                    // "status"=>intval($this->db->fetch_field("SELECT 1 FROM `gateways` WHERE `user_id`=".$_u->id." AND `data` IS NOT NULL LIMIT 1"))==1?"complete":"future"
                // ],
                (object) [
                        "name"=>"getMerchantAndStart",
                        "url"=>"businesses",
                        "status"=>"future"
                ]
            ];
			$output->start = false;
            $output->end = false;
			$output->step_number = 1;
			$output->now_step_number = null;
			$output->now_step = null;
            foreach($output->steps as $key=>$step){
				$output->steps[$key]->step_number = $output->step_number;
                if($step->status=="future"&&!$output->start){$step->status="now";$output->now_step=$step;$output->now_step_number=$output->step_number;$output->start = true;}
                if($step->status!="complete")$output->end=true;
				
				$output->step_number++;
            }
			return $output;
		}
	}
?>