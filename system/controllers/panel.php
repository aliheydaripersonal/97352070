<?php
    if(!$this->user->check_login()){
        $this->redirect("authentication");
    }
    $D->tab =   !$this->param("tab")?"main":$this->param("tab");
	$D->page = intval($this->param("page"))==0?1:intval($this->param("page"));
    switch($D->tab){
        case "main":
            $D->result = $this->core->get_list_post("paging",null,20,$D->page,"`renewal_date` DESC",null,$this->user->id,null,null,[0,1],null,null);
        break;
        case "favorites":
            $results_per_page = 20;
            $page_first_result = ($D->page-1) * $results_per_page;  
            $_all_count = $this->db->fetch_field("SELECT count(`id`) FROM `posts` INNER JOIN `favorites` ON `posts`.`id`=`favorites`.`post_id` WHERE `posts`.`status` IN (0,1) AND `favorites`.`user_id`=".$this->user->id);
            $D->result = (object)[
                "current_page"=>$D->page,
                "result"=>[],
                "all_count"=>$_all_count,
                "page_count"=>ceil($_all_count/$results_per_page),
            ];
            $_result = $this->db->fetch_all("SELECT `id` FROM `posts` INNER JOIN `favorites` ON `posts`.`id`=`favorites`.`post_id` WHERE  `posts`.`status` IN (0,1) AND `favorites`.`user_id`=".$this->user->id." ORDER BY `posts`.`renewal_date` DESC LIMIT $page_first_result,$results_per_page");

            foreach($_result as $post){
                $D->result->result[] = $this->core->get_post_by_id($post->id);
            }
        break;
        defalut:
            $this->redirect("/");
    }
    $D->title = "panelTitle";
    $D->description = "panelDescription";
	$this->load_template("panel.php");
?>