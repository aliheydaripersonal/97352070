<?php
    if(!$this->user->check_login()){
        $this->redirect("authentication");
    }
    $_parent_id = intval($this->param("id"));
    $_result = $this->core->get_list_category("all",["id","name","parent_id","slug"],null,null,"`name` ASC",null,null,$_parent_id,null);
    $_output = (object) [
        "result"=>$_result->result,
        "back_category_id"=>$_parent_id==0?0:$this->core->get_category_by_id($_parent_id)->parent_id
    ];
    echo json_encode($_output);