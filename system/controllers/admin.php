<?php
    if(!$this->user->check_admin()){
        $this->redirect("/");
    }
    $start_yesterday = mktime(0,0,0);
    $end_yesterday = $start_yesterday+86400;
    $start_today = mktime(0,0,0);
    $end_today = $start_today+86400;
    $D->stats = (object) [
        "users"=>$this->db->fetch_field("SELECT count(`id`) FROM `users`"),
        "today_users"=>$this->db->fetch_field("SELECT count(`id`) FROM `users` where `date`>{$start_today} AND `date`<{$end_today} "),
        "yesterday_users"=>$this->db->fetch_field("SELECT count(`id`) FROM `users` where `date`>{$start_yesterday} AND `date`<{$end_yesterday} "),
        
        "categories"=>$this->db->fetch_field("SELECT count(`id`) FROM `categories`"), 
        "posts"=>$this->db->fetch_field("SELECT count(`id`) FROM `posts`"),
        "pending_posts"=>$this->db->fetch_field("SELECT count(`id`) FROM `posts` WHERE `status`=0"),
        "today_posts"=>$this->db->fetch_field("SELECT count(`id`) FROM `posts` where `date`>{$start_today} AND `date`<{$end_today} "),
        "yesterday_posts"=>$this->db->fetch_field("SELECT count(`id`) FROM `posts` where `date`>{$start_yesterday} AND `date`<{$end_yesterday} "),
    ];
    $D->title = "admin";
    $D->description = "admin";
    $this->load_template("admin.php");
?>