<?php
    if($this->user->check_login()){
        $this->redirect("panel");
    }
    $D->tab = !$this->param("tab")?"start":$this->param("tab");
    switch($D->tab){
        case "start":
            $D->api = new api();
            $_fields = [
                (object) ["name"=>"mail","type"=>"mail","required"=>true],
            ];
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    if($this->core->get_user_by_mail($D->inputs->fields->mail)){
                        $this->redirect($C->SITE_URL."authentication/tab:login/mail:".$D->inputs->fields->mail.'/');
                    }else{
                        $this->redirect($C->SITE_URL."authentication/tab:register/mail:".$D->inputs->fields->mail.'/');
                    }
                }
            }
        break;
        case "register":
            $D->api = new api();
            $D->mail = !$this->param("mail")?"":$this->param("mail");
            $_fields = [
                (object) ["name"=>"mail","type"=>"mail","value"=>$D->mail,"required"=>true],
                (object) ["name"=>"firstname","type"=>"text","required"=>true],
                (object) ["name"=>"lastname","type"=>"text","required"=>true],
                (object) ["name"=>"password","type"=>"password","required"=>true]
            ];
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    $_user = $this->core->get_user_by_mail($D->inputs->fields->mail,true);
                    if(!$_user){
                        $_user_id = $this->core->add_user($D->inputs->fields->mail,null,$D->inputs->fields->firstname,$D->inputs->fields->lastname,password($D->inputs->fields->password),0,0);  
                        
                        $_SESSION["token"] = $this->user->get_token($_user_id);
                        $this->redirect("panel");
                    }else{
                        $this->redirect("authentication");
                    }
                }
            }
        break;
        case "verify":
            if(isset($_GET["secret"])){
                $_secret = urldecode(trim($_GET["secret"]));
                $_verification = $this->core->get_verification_by_code($_secret);
                if($_verification->status==0){
                    $this->db->query("update `users` SET `status`=1 WHERE ".data_array_mysql(" AND ",["id"=>$_verification->user_id]));
                    $this->db->query("update `verifications` SET `status`=1 WHERE ".data_array_mysql(" AND ",["user_id"=>$_verification->user_id]));
                    $this->core->get_verification_by_code($_secret,true);
                    $this->core->get_user_by_id($_verification->user_id,true);
                    $_SESSION["token"] = $this->user->get_token($_verification->user_id);
                    $D->SUCCESSFUL = true;
                    $D->SUCCESSFUL_MESSAGE = "done";
                }else{
                    $D->ERROR = true;
                    $D->ERROR_MESSAGE = "invalid";
                }
            }else{
                $D->ERROR = true;
                $D->ERROR_MESSAGE = "invalid";
            }
        break;    
        case "login":
            $D->api = new api();
            $D->mail = !$this->param("mail")?"":$this->param("mail");
            $_fields = [
                (object) ["name"=>"mail","type"=>"mail","value"=>$D->mail,"required"=>true],
                (object) ["name"=>"password","type"=>"password","required"=>true]
            ];
            $D->inputs = $D->api->setInputs($_fields);
            if(isset($_POST["submit"]))
            {
                $D->inputs = $D->api->inputs(false,true);
                if($D->inputs->status==200){
                    $_user = $this->core->get_user_by_mail($D->inputs->fields->mail);
					// echo (password($D->inputs->fields->password).'-'.$_user->password);
                    if($_user->password==password($D->inputs->fields->password)){
                        $D->SUCCESSFUL = true;
                        $D->SUCCESSFUL_MESSAGE = "done";
                        $_SESSION["token"] = $this->user->get_token($_user->id);
                        $this->redirect("panel");
                    }else{
                        $D->ERROR = true;
                        $D->ERROR_MESSAGE = "Invalid password";
                    }
                }
            }
        break;
        case "recover":
        break;
        default:
            $this->redirect("authentication");
    }
    $D->title = "authenticationPageTitle";
    $D->description = "authenticationPageDescription";
    $this->load_template("authentication.php");