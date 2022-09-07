<?php

	class mysql
	{
		private $connection	= FALSE;
		private $dbhost;
		private $dbuser;
		private $dbpass;
		private $dbname;
		private $last_result	= FALSE;
		public $fatal_error	= FALSE;
		private $debug_mode	= FALSE;
		private $debug_info	= FALSE;
		private $ext;
		public $disconnect_on_descruct;
		public $last_query;

		public function __construct($host, $user, $pass, $db, $ext)
		{
			$this->dbhost	= $host;
			$this->dbuser	= $user;
			$this->dbpass	= $pass;
			$this->dbname	= $db;
			$this->ext	= $ext;
			$this->debug_mode = $GLOBALS['C']->DEBUG_MODE;
			if( ! isset($GLOBALS['MYSQL_DEBUG_INFO']) ) {
				$GLOBALS['MYSQL_DEBUG_INFO']	= (object) array('queries'=>array(), 'time'=>0);
			}
			$this->debug_info	= & $GLOBALS['MYSQL_DEBUG_INFO'];
			$this->disconnect_on_descruct	= TRUE;
		}

		public function connect()
		{
			$time	= microtime(TRUE);
			$this->connection	= $this->ext=='mysqli' ? mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass) : mysql_connect($this->dbhost, $this->dbuser, $this->dbpass);
			if(FALSE == $this->connection) {
				return $this->fatal_error('Connect');
			}
			$db	= $this->ext=='mysqli' ? mysqli_select_db($this->connection, $this->dbname) : mysql_select_db($this->dbname, $this->connection);
			if(FALSE == $db) {
				return $this->fatal_error('Select DB');
			}
			$this->ext=='mysqli' ? mysqli_query($this->connection, 'SET NAMES utf8mb4') : mysql_query('SET NAMES utf8mb4', $this->connection);
			if($this->debug_mode) {
				$time	= microtime(TRUE) - $time;
				$this->debug_info->queries[]	= (object) array (
					'query'	=> 'CONNECT '.$this->dbhost,
					'time'	=> number_format($time, 5, '.', ''),
				);
				$this->debug_info->time		+= $time;
			}
			//set Time Zone{
			$now = new DateTime();
			$mins = $now->getOffset() / 60;
			$sgn = ($mins < 0 ? -1 : 1);
			$mins = abs($mins);
			$hrs = floor($mins / 60);
			$mins -= $hrs * 60;
			$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
			$this->query("SET time_zone='$offset';");
			//end set Time Zone}
			return $this->connection;
		}

		public function query($query, $remember_result=TRUE)
		{
                        $this->last_query =$query;
			if(FALSE == $this->connection) {
				$this->connect();
			}
			$time	= microtime(TRUE);
			$result	= $this->ext=='mysqli' ? mysqli_query($this->connection, $query) : mysql_query($query, $this->connection);
			if($this->debug_mode) {
				$time	= microtime(TRUE) - $time;
				$this->debug_info->queries[]	= (object) array (
					'query'	=> $query,
					'time'	=> number_format($time, 5, '.', ''),
				);
				$this->debug_info->time	+= $time;
			}
			if(FALSE == $result) {
				return $this->fatal_error($query);
			}
			if($remember_result) {
				$this->last_result	= $result;
			}
			return $result;
		}

		public function fetch_object($res=FALSE) {
			$res	= FALSE!==$res ? $res : $this->last_result;
			if(FALSE == $res) {
				return FALSE;
			}
			return $this->ext=='mysqli' ? mysqli_fetch_object($res) : mysql_fetch_object($res);
		}

		public function select($type,$table,$where=false,$start_page = false,$page_count = false,$join_table = false,$select_q="*",$orders=false,$limit = false,$groups = false,$show_query=false) {
                    $result = (object) array();
                    $result->have_page = false;

                    if(isset($where['forselect'])){
                        $select_q = $where['forselect'];
                        unset($where['forselect']);
                    }
                    if(isset($where['jointable'])){
                        $join_table = $where['jointable'];
                        if($select_q=="id")
                            $select_q = $table.".id";
                        unset($where['jointable']);
                    }

                    if(is_array($join_table)){
						$join_table_q_array = array();
						foreach($join_table as $key=>$value){
							$join_table_q_array[] = $value->table.' ON '.$value->on;
						}
                        $join_table = implode(" INNER JOIN ",$join_table_q_array);
                    }
                    if($start_page!==false&&$page_count!==false)
                        $start = ($start_page - 1) * $page_count;
                    $order_q = "";
                    if(isset($where['orderby'])){
                        $orders = $where['orderby'];
                        unset($where['orderby']);
                    }

                    if($orders!==false){
                        if(is_array($orders))
                            $order_q = " ORDER BY ".implode(",",$orders);
                        else
                            $order_q = " ORDER BY ".$orders;
                    }

                    $group_q = "";
                    if(isset($where['groupby'])){
                        $groups = $where['groupby'];
                        unset($where['groupby']);
                    }
                    if($groups!==false){
                        if(is_array($groups))
                            $group_q = " GROUP BY ".implode(",",$groups);
                        else
                            $group_q = " GROUP BY ".$groups;
                    }

                    $limit_q = "";
                    if(isset($where['limitrows'])){
                        $limit = $where['limitrows'];
                        unset($where['limitrows']);
                    }
                    if($limit!==false){
                        $limit_q = " LIMIT ".$limit;
                    }

                    $where_q = "";
                    if($where!==false && count($where)>0){
                        $where_q = " WHERE ".data_array_mysql(' AND ',$where);
                    }
                    $result->rows = array();
                    if($type=="loadmore"){

                    }elseif($type == "paging"){
                        if(!$join_table){
                            $result->total = $this->fetch_field("SELECT count(*) FROM `".$this->escape($table)."` ".$where_q.$group_q);
                            $r = $this->query("SELECT ".$select_q." FROM `".$this->escape($table)."` ".$where_q.$group_q.$order_q." LIMIT ".$start.",".$page_count);
                        }else{
                            $result->total = $this->fetch_field("SELECT count(*) FROM `".$this->escape($table)."` INNER JOIN ".$join_table." ".$where_q.$group_q);
                            $r = $this->query("SELECT ".$select_q." FROM `".$this->escape($table)."` INNER JOIN ".$join_table." ".$where_q.$group_q.$order_q." LIMIT ".$start.",".$page_count);
                        }

                        while($object = $this->fetch_object($r)){
                            $result->rows[] = $object;
                        }
                        if(($result->total - $page_count) > 0){
                            $result->have_page  = true;
                            $result->total_page  = ceil($result->total / $page_count);
                            $result->last_page  = $result->total_page;
                            $result->middle_page  = $start_page +4;
                            $result->start_page  = $start_page -4;
                        }
                    }else{
                        if(!$join_table){
                            $result->total = $limit;
                            if($limit!==false)
                                $result->total = $this->fetch_field("SELECT count(*) FROM `".$this->escape($table)."` ".$where_q.$group_q);
                            $r = $this->query("SELECT ".$select_q." FROM `".$this->escape($table)."` ".$where_q.$group_q.$order_q.$limit_q);
                        }else{
                            $result->total = $limit;
                            if($limit!==false)
                                $result->total = $this->fetch_field("SELECT count(*) FROM `".$this->escape($table)."` INNER JOIN ".$join_table." ".$where_q.$group_q);
                            $r = $this->query("SELECT ".$select_q." FROM `".$this->escape($table)."` INNER JOIN ".$join_table." ".$where_q.$group_q.$order_q.$limit_q);
                        }
                            if($show_query)
                                echo $this->last_query;
                        while($object = $this->fetch_object($r)){
                            $result->rows[] = $object;
                        }
                    }
                    return $result;
		}


		public function fetch($query) {
			$res	= $this->query($query, FALSE);
			if(FALSE == $res) {
				return FALSE;
			}
			return $this->fetch_object($res);
		}

		public function fetch_all($query) {
			$res	= $this->query($query, FALSE);
			if(FALSE == $res) {
				return FALSE;
			}
			$data	= array();
			while( $obj = $this->fetch_object($res) ) {
				$data[]	= $obj;
			}
			$this->free_result($res);
			return $data;
		}

		public function fetch_field($query) {
			$res	= $this->query($query, FALSE);
			if(FALSE == $res) {
				return FALSE;
			}
			if( ! $row = ( $this->ext=='mysqli' ? mysqli_fetch_row($res) : mysql_fetch_row($res) ) ) {
				return FALSE;
			}
			$this->free_result($res);
			return $row[0];
		}

		public function num_rows($res=FALSE) {
			$res    = FALSE!==$res ? $res : $this->last_result;
			if(FALSE == $res) {
				return FALSE;
			}
			return $this->ext=='mysqli' ? mysqli_num_rows($res) : mysql_num_rows($res);
		}

		public function insert_id() {
			if(FALSE == $this->connection) {
                            $this->connect();
			}
                        $id = intval( $this->ext=='mysqli' ? mysqli_insert_id($this->connection) : mysql_insert_id($this->connection) );
			return $id;
		}

		public function insert($table,$data) {
			if(FALSE == $this->connection) {
                $this->connect();
			}
            $this->query("INSERT INTO `".$this->e($table)."` SET ".data_array_mysql(",",$data));
			$id = $this->insert_id();
			return $id;
		}
		public function affected_rows() {
			if(FALSE == $this->connection) {
				$this->connect();
			}
			return $this->ext=='mysqli' ? mysqli_affected_rows($this->connection) : mysql_affected_rows($this->connection);
		}

		public function data_seek($row=0, $res=FALSE) {
			$res    = FALSE!==$res ? $res : $this->last_result;
			if(FALSE == $res) {
				return FALSE;
			}
			return $this->ext=='mysqli' ? mysqli_data_seek($res, $row) : mysql_data_seek($res, $row);
		}

		public function free_result($res=FALSE) {
			$res    = FALSE!==$res ? $res : $this->last_result;
			if(FALSE == $res) {
				return FALSE;
			}
			return $this->ext=='mysqli' ? mysqli_free_result($res) : mysql_free_result($res);
		}

		public function escape($string) {
			if(FALSE == $this->connection) {
				$this->connect();
			}
			return $this->ext=='mysqli' ? mysqli_real_escape_string($this->connection, $string) : mysql_real_escape_string($string, $this->connection);
		}

		public function e($str) {
			return $this->escape($str);
		}

		private function fatal_error($query) {
			$this->fatal_error	= TRUE;
			$error	= $this->ext=='mysqli' ? mysqli_error($this->connection) : mysql_error($this->connection);
			if($this->debug_mode) {
				echo 'MySQL Query: '.$query.'<br />';
				echo 'MySQL Error: '.$error.'<br />';
				exit;
			}
			exit;
			//return FALSE;
		}

		public function get_debug_info()
		{
			$debug_info	= clone($this->debug_info);
			$debug_info->time	= number_format($debug_info->time, 4, '.', '');
			$debug_info->queries	= array_reverse($debug_info->queries);
			return $debug_info;
		}

		public function delete_debug_info()
		{
			$this->debug_info->queries	= array();
		}

		public function __destruct()
		{
			if( $this->disconnect_on_descruct ) {
				if( $this->connection ) {
					$this->ext=='mysqli' ? @mysqli_close($this->connection) : @mysql_close($this->connection);
					$this->connection	= FALSE;
				}
			}
		}
	}

?>