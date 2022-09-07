<?php
    if(!$this->user->check_login()){
        $this->redirect("authentication");
    }
    $D->sections = ["category","information","edit","remove"];
    $D->section = !$this->param("section")||!in_array($this->param("section"),$D->sections)?"category":$this->param("section");
    
    switch($D->section)
    {
        case "category":
            $_fields = [
                (object) ["name"=>"category","type"=>"category","required"=>true]
            ];
            $D->api = new api();
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    $this->redirect("panel/post/section:information/category:".$D->inputs->fields->category);
                }
            }
        break;
        case "information":
            $D->category = $this->param("category");
            if(!$D->category)
                $this->redirect("panel/post/section:category");
            $_fields = [
                (object) ["name"=>"city","type"=>"city","required"=>true],
                (object) ["name"=>"title","type"=>"text","required"=>true],
                (object) ["name"=>"content","type"=>"textarea","required"=>true],
                (object) ["name"=>"mail","type"=>"mail","required"=>true],
                (object) ["name"=>"phone","type"=>"phone","required"=>true],
                (object) ["name"=>"media","type"=>"media","required"=>false],
            ];

            $_categories = [];
            $ct_id = $D->category;//tmp
            while($ct_id!==0){
                $_category = $this->core->get_category_by_id($ct_id);
                $_categories[] = $_category->id;
                $ct_id = $_category->parent_id;
                if($ct_id==0)break;
            }

            $_category_fields = $this->db->fetch_all("SELECT * FROM `fields` WHERE `category_id` in (".implode(",",$_categories).")");
            foreach($_category_fields as $category_field){
                $_fields[] = (object) ["label"=>$category_field->name,"name"=>"fields_".$category_field->name,"type"=>$category_field->type,"required"=>$category_field->required];
            }

            $D->api = new api();
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    $_city = $this->core->get_city_by_id($D->inputs->fields->city);
                    $_province = $this->core->get_province_by_id($_city->province_id);
                    $_post_id = $this->core->add_post($_province->country_id,$_province->id,$_city->id,$this->user->id,$D->inputs->fields->title,str_replace(["\r\n","\n"],"_br_",$D->inputs->fields->content),$D->inputs->fields->mail,$D->inputs->fields->phone,isset($_POST["media"])&&is_array($_POST["media"])?count($_POST["media"]):0,0,time());
                    
                    foreach($_categories as $category_id){
                        $this->core->add_posts_category($_post_id,$category_id);
                    }

                    foreach($_category_fields as $category_field){
                        $this->core->add_posts_value($_post_id, $category_field->id, $D->inputs->fields->{ 'fields_'. $category_field->name } );
                    }

                    if(isset($_POST["media"]) && count($_POST["media"])>0)
                    {
                        $_POST["media"] = array_slice($_POST["media"],0,3);
                        foreach($_POST["media"] as $type=>$media){
                            $tmp = $this->network->temporary_get($media);
                            if(!(!isset($tmp->path)||!file_exists($tmp->path) || !getimagesize($tmp->path))){
                                //start
                                if(!is_dir($C->path_media))
                                    mkdir($C->path_media,0755,true);
                                if(!is_dir($C->path_thumbnail))
                                    mkdir($C->path_thumbnail,0755,true);

                                $file_name = rand(1111111,9999999).time().".webp";
                                $file_path = $C->path_media.$file_name;
                                while(file_exists($file_path)){
                                    $file_name = rand(1111111,9999999).time().".webp";
                                    $file_path = $C->path_media.$file_name;
                                }
                                $file_path_thumbnail = $C->path_thumbnail.$file_name;
                                $image = new image();
                                $image->fromFile($tmp->path)->autoOrient()->resize(500)->toFile($file_path, 'image/webp');
                                $image->fromFile($tmp->path)->autoOrient()->thumbnail(220,220,'center')->toFile($file_path_thumbnail, 'image/webp');
                                $final_image = (new image())->fromFile($file_path);
                                
                                $this->core->add_media($_post_id,0,$file_path, $file_path_thumbnail,$final_image->getWidth(),$final_image->getHeight());
                            }
                        }
                    }

                    $this->redirect("panel");
                }
            }
        break;
        case "remove":
            $D->id = $this->param("id");
            if($D->id && $D->post = $this->core->get_post_by_id($D->id)){
                if($D->post->user_id!=$this->user->id){
                    $this->redirect("panel");
                    exit;
                }
            }else{
                $this->redirect("panel");
            }
            $this->db->query("UPDATE `posts` SET `status`=3 WHERE `id`=".$D->post->id);
            $this->core->get_post_by_id($D->post->id,true);
            $this->redirect("panel");
        break;
        case "edit":
            $D->id = $this->param("id");
            if($D->id && $D->post = $this->core->get_post_by_id($D->id)){
                if($D->post->user_id!=$this->user->id){
                    $this->redirect("panel");
                    exit;
                }
                $_post_id = $D->id;
            }else{
                $this->redirect("panel");
            }
            $_fields = [
                (object) ["name"=>"title","type"=>"text","value"=>$D->post->title,"required"=>true],
                (object) ["name"=>"content","type"=>"textarea","value"=>str_replace("_br_","\r\n",$D->post->content),"required"=>true],
                (object) ["name"=>"mail","type"=>"mail","value"=>$D->post->mail,"required"=>true],
                (object) ["name"=>"phone","type"=>"phone","value"=>$D->post->phone,"required"=>true],
                (object) ["name"=>"media","type"=>"media","value"=>$D->post->media,"required"=>false],
            ];

            $_category_fields = $this->db->fetch_all("SELECT * FROM `fields` WHERE `category_id` in (".implode(",",$D->post->categories).")");
            foreach($_category_fields as $category_field){
                $_fields[] = (object) ["value"=>$D->post->values[$category_field->id],"label"=>$category_field->name,"name"=>"fields_".$category_field->name,"type"=>$category_field->type,"required"=>$category_field->required];
            }
            $D->api = new api();
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){

                    $this->db->query("DELETE FROM `posts_values` WHERE `post_id`=".$D->post->id);
                    foreach($_category_fields as $category_field){
                        $this->core->add_posts_value($_post_id, $category_field->id, $D->inputs->fields->{ 'fields_'. $category_field->name } );
                    }
                    $_media_count = $D->post->media_count; 
                    if(isset($_POST["delete_media"]) && count($_POST["delete_media"])>0)
                    {
                        foreach($_POST["delete_media"] as $media_id){
                            $__media = $this->core->get_media_by_id($media_id);
                            if($__media->post_id!=$_post_id)
                                continue;
                            if($this->core->delete_media_by_id($media_id))
                                $_media_count--;
                        }
                    }
                    if(isset($_POST["media"]) && count($_POST["media"])>0)
                    {
                        $_POST["media"] = array_slice($_POST["media"],0,3);
                        foreach($_POST["media"] as $type=>$media){
                            $tmp = $this->network->temporary_get($media);
                            if(!(!isset($tmp->path)||!file_exists($tmp->path) || !getimagesize($tmp->path))){
                                //start
                                if(!is_dir($C->path_media))
                                    mkdir($C->path_media,0755,true);
                                if(!is_dir($C->path_thumbnail))
                                    mkdir($C->path_thumbnail,0755,true);

                                $file_name = rand(1111111,9999999).time().".webp";
                                $file_path = $C->path_media.$file_name;
                                while(file_exists($file_path)){
                                    $file_name = rand(1111111,9999999).time().".webp";
                                    $file_path = $C->path_media.$file_name;
                                }
                                $file_path_thumbnail = $C->path_thumbnail.$file_name;
                                $image = new image();
                                $image->fromFile($tmp->path)->autoOrient()->resize(500)->toFile($file_path, 'image/webp');
                                $image->fromFile($tmp->path)->autoOrient()->thumbnail(220,220,'center')->toFile($file_path_thumbnail, 'image/webp');
                                $final_image = (new image())->fromFile($file_path);
                                $_media_count++;
                                $this->core->add_media($_post_id,0,$file_path, $file_path_thumbnail,$final_image->getWidth(),$final_image->getHeight());
                            }
                        }
                    }
                    $this->core->update_post_by_id($_post_id,$D->inputs->fields->title,str_replace(["\r\n","\n"],"_br_",$D->inputs->fields->content),$D->inputs->fields->mail,$D->inputs->fields->phone,$_media_count,0,null);

                    $this->redirect("panel");
                }
            }
        break;
    }
	
    $D->title = "postPageTitle";
    $D->description = "postPageDescription";
	$this->load_template("panel_post.php");
?>