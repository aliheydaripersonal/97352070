<?php
    
    //$this->params->category
    $D->breadcrumb = [];
    $D->categories = [];
    $D->category_fields = [];
    if(!!$this->param('page')||strpos($C->FULL_URL_WITHOUT_GET,"page:")!==false)
        $D->noindex = true;
    $D->page = !$this->param('page')?1:$this->param('page');
    $joins = [];
    $where = [];
    $where[] = "`posts`.`status`=1";
    if(isset($this->params->city_id)){
        $D->city = $this->core->get_city_by_id($this->params->city_id);
        $where[] = "`posts`.`city_id`=".$this->params->city_id."";
        $D->breadcrumb[] = (object)[
            "url"=>$D->city->url,
            "label"=>$this->lang($D->city->name)
        ];
    }
    if(isset($this->params->province_id)){
        $where[] = "`posts`.`province_id`=".$this->params->province_id."";
    }
    if(isset($this->params->has_media) && $this->params->has_media){
        $where[] = "`posts`.`media_count`>0";
    }
    if(isset($this->params->end_category_id)){
        $joins[] = "INNER JOIN `posts_categories` ON `posts`.`id`=`posts_categories`.`post_id`";
        $where[] = "`posts_categories`.`category_id`=".$this->params->end_category_id."";

        $_c_t = $this->params->end_category_id;
        $_categories_ids = [];
        $_tmp_breadcrumb = [];
        while($_c_t!==0){
            $_cat = $this->core->get_category_by_id($_c_t);
            $_tmp_breadcrumb[] = (object)[
                "url"=>$D->city->url.$_cat->uri,
                "label"=>$this->lang($_cat->name)
            ];
            $D->categories[] = $_cat;
            $_categories_ids[] = $_cat->id;
            $_c_t = $_cat->parent_id;
            if($_cat->parent_id==0)
                break;
        }
        $D->breadcrumb = array_merge($D->breadcrumb,array_reverse($_tmp_breadcrumb));
        $D->category_fields = $this->core->get_list_category_fields(implode(",", $_categories_ids),null,true,true);
    }
    $_fields = [
        (object) ["label"=>"search","name"=>"q","type"=>"text","required"=>false],
        (object) ["label"=>"having photo","name"=>"media_count","type"=>"checkbox","options"=>[(object)["label"=>"","value"=>"1"]],"required"=>false],
    ];
    foreach($D->category_fields as $_field){
       // var_export($_field);
        $_field_obj = (object) ["label"=>$_field->name,"name"=>'field_'.$_field->id,"type"=>$_field->search_type,"required"=>false];
        if($_field_obj->type=="radio"||$_field_obj->type=="select")
        {
            $_field_obj->options = $this->core->get_list_fields_option("all",null,null,null,"`label` ASC",null,$_field->id)->result;
        }
        $_fields[] = $_field_obj;
    }
    $D->api = new api();
    $D->inputs = $D->api->setInputs($_fields);
    if(isset($_GET["submit"]))
    {
        $D->inputs = $D->api->inputs(false,true);
        if($D->inputs->status==200){
            if(isset($D->inputs->fields->q))
            {
                $_string = urldecode($D->inputs->fields->q);
                $where[] = "`posts`.`title` LIKE '%".$this->db->e($_string)."%'";
            }
            $field_search = false;
            foreach($D->category_fields as $_field){
                $_input_name = "field_".$_field->id;
                if(empty($D->inputs->fields->$_input_name))
                        continue;
                $field_search = true;
                switch($_field->search_type){
                    case "range":
                        if(!is_array($D->inputs->fields->$_input_name))
                            continue 2;
                        $D->inputs->fields->$_input_name[0] = intval($D->inputs->fields->$_input_name[0]);
                        if($D->inputs->fields->$_input_name[0]>0){
                            $where[] = "`posts_values`.`value`>".$this->db->e($D->inputs->fields->$_input_name[0]);
                        }
                        $D->inputs->fields->$_input_name[1] = intval($D->inputs->fields->$_input_name[1]);
                        if($D->inputs->fields->$_input_name[1]>0){
                            $where[] = "`posts_values`.`value`<".$this->db->e($D->inputs->fields->$_input_name[1]);
                        }
                        if($D->inputs->fields->$_input_name[0]>0 || $D->inputs->fields->$_input_name[1]>0)
                            $where[] = "`posts_values`.`field_id`=\"".$_field->id."\"";
                    break;
                    case "text":
                        $where[] = "`posts_values`.`field_id`=\"".$_field->id."\" AND `posts_values`.`value` LIKE \"".$this->db->e($D->inputs->fields->$_input_name)."\"";
                    break;
                }
            }
            if($field_search)
                $joins[] = "INNER JOIN `posts_values` ON `posts`.`id`=`posts_values`.`post_id`";
        }
    }
    $joins = implode(" ",$joins);
    $where = implode(" AND ",$where);
    if(!empty($where))
    $where = " WHERE ".$where;
    $results_per_page = 20;
    $page_first_result = ($D->page-1) * $results_per_page;
    $_all_count = $this->db->fetch_field("SELECT count(DISTINCT `id`) FROM `posts` $joins $where");
    $D->result = (object)[
        "current_page"=>$D->page,
        "result"=>[],
        "all_count"=>$_all_count,
        "page_count"=>ceil($_all_count/$results_per_page),
    ];
    $_result = $this->db->fetch_all("SELECT DISTINCT `id` FROM `posts` $joins $where ORDER BY `posts`.`renewal_date` DESC LIMIT $page_first_result,$results_per_page");

    foreach($_result as $post){
        $D->result->result[] = $this->core->get_post_by_id($post->id);
    }
    $D->display_categories = $this->core->get_list_category("all",null,null,null,"`name` ASC",null,null,isset($this->params->end_category_id)?$this->params->end_category_id:0,null)->result;
    $D->title = "search";
    $D->description = "search";
    $this->load_template("search.php");
?>