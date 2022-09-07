<?php
    if(!$this->user->check_admin()){
        $this->redirect("/");
    }
    $D->tab = !$this->param("tab")?"list":$this->param("tab");
    switch($D->tab){
        case "list":
		
            $D->parent_id = !$this->param("parent_id")?0:intval($this->param("parent_id"));
            $_fields = [
                (object) ["name"=>"name","type"=>"text","required"=>true],
                (object) ["label"=>"uri","name"=>"slug","type"=>"text","required"=>true]
            ];
            $D->api = new api();
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    $this->core->add_category($D->inputs->fields->name,make_slug($D->inputs->fields->slug),null,null,$D->parent_id,1);
                }
            }
            $D->result = $this->core->get_list_category("all",null,null,null,"`id` DESC",null,null,$D->parent_id,null);
        break;
        case "fields":
            $D->id = !$this->param("id")?0:intval($this->param("id"));
            $_fields = [
                (object) ["name"=>"name","type"=>"text","required"=>true],
                (object) ["name"=>"type","type"=>"text","required"=>true],
                (object) ["name"=>"required","type"=>"radio","default"=>0,"options"=>[(object)["value"=>"0","label"=>"no"],(object)["value"=>"1","label"=>"yes"]],"required"=>true],
                (object) ["name"=>"search_type","type"=>"text","required"=>true],
                (object) ["name"=>"options","type"=>"textarea","required"=>false]
            ];
            $D->api = new api();
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    $field_id = $this->core->add_field($D->id,$D->inputs->fields->type,$D->inputs->fields->name,$D->inputs->fields->required,$D->inputs->fields->search_type);
                    $_options = !empty($D->inputs->fields->options)?array_unique(explode("\r\n",$D->inputs->fields->options)):[];
                    var_export($_options);
                    foreach($_options as $_option){
                        $_option = trim($_option);
                        if(empty($_option))continue;
                        if($this->db->fetch_field("SELECT 1 FROM `fields_options` WHERE `label`='".$this->db->e($_option)."'")!="1")
                            $this->core->add_fields_option($field_id,trim($_option));
                    }
                }
            }

            $D->result = $this->core->get_list_field("all",null,null,null,"`id` DESC",null,$D->id,null);
        break;
        case "field":
            $D->id = !$this->param("id")?0:intval($this->param("id"));//field_id
            $D->field = $this->core->get_field_by_id($D->id);
            $_fields = [
                (object) ["name"=>"name","type"=>"text","default"=>$D->field->name,"required"=>true],
                (object) ["name"=>"type","type"=>"text","default"=>$D->field->type,"required"=>true],
                (object) ["name"=>"required","type"=>"radio","default"=>$D->field->required,"options"=>[(object)["value"=>"0","label"=>"no"],(object)["value"=>"1","label"=>"yes"]],"required"=>true],
                (object) ["name"=>"search_type","type"=>"text","default"=>$D->field->search_type,"required"=>true],
                (object) ["name"=>"options","type"=>"textarea","required"=>false]
            ];
            $D->api = new api();
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    $this->core->update_field_by_id($D->id,$D->inputs->fields->type,$D->inputs->fields->name,$D->inputs->fields->required,$D->inputs->fields->search_type);
                    $_options = !empty($D->inputs->fields->options)?array_unique(explode("\r\n",$D->inputs->fields->options)):[];
                    foreach($_options as $_option){
                        $_option = trim($_option);
                        if(empty($_option))continue;
                        if($this->db->fetch_field("SELECT 1 FROM `fields_options` WHERE `field_id`='".$D->id."' AND `label`='".$this->db->e($_option)."'")!="1")
                            $this->core->add_fields_option($D->id,trim($_option));
                    }
                }
            }
            $D->result = $this->core->get_list_fields_option("all",null,null,null,"`id` DESC",null,$D->id);
        break;
        default:
            exit("invalid");
    }


    $D->title = "categories";
    $D->description = "categories";
    $this->load_template("admin_categories.php");
?>