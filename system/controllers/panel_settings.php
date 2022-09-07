<?php
    if(!$this->user->check_login()){
        $this->redirect("authentication");
    }
    $_fields = [
        (object) ["name"=>"firstname","type"=>"text","value"=>$this->user->info->firstname,"required"=>true],
        (object) ["name"=>"lastname","type"=>"text","value"=>$this->user->info->lastname,"required"=>true],
        (object) ["description"=>"if you want change password fill this.","label"=>"new password","name"=>"new_password","type"=>"password","required"=>false],
        (object) ["label"=>"current password","name"=>"current_password","type"=>"password","required"=>true]
    ];

    $D->api = new api();
    $D->inputs = $D->api->setInputs($_fields);
    if(isset($_POST["submit"]))
    {
        $D->inputs = $D->api->inputs(false,true);
        if($D->inputs->status==200){
            if(password($D->inputs->fields->current_password)==$this->user->info->password){
                $this->core->update_user_by_id($this->user->id,null,$D->inputs->fields->firstname,$D->inputs->fields->lastname,!empty($D->inputs->fields->new_password)?password($D->inputs->fields->new_password):null);
            }else{
                $D->ERROR = true;
                $D->ERROR_MESSAGE = "invalid current password";
            }
        }
    }
    $D->title = "settingsPageTitle";
    $D->description = "settingsPageDescription";
	$this->load_template("panel_settings.php");