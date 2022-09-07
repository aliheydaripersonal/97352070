<?php
    if(!$this->user->check_login()){
        $this->redirect("authentication");
    }
    $_id = intval($this->param("id"));//post id
    $_type = $this->param("type");
    switch($_type){
        case "toggle_favorite":
            $_output = (object)[];
            if($this->network->is_favorite_post($this->user->id,$_id)){
                $this->db->query("DELETE FROM `favorites` WHERE ".data_array_mysql(" AND ",["user_id"=>$this->user->id,"post_id"=>$_id]));
                $_output->message = "unfavorited";
            }else{
                $this->core->add_favorite($this->user->id,$_id);
                $_output->message = "favorited";
            }
            $this->network->is_favorite_post($this->user->id,$_id,true);
        break;
        default:
            exit("err");
    }
    echo json_encode($_output);