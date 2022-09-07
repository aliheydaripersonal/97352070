<?php
    $_fields = [
        (object) ["name"=>"city","type"=>"city","required"=>true,"force_redirect"=>true,"placeholder"=>$this->lang("Type you'r City name")]
    ];
    $_city_api = new api();
    $_city_api->setInputs($_fields);
?><form>
    <?=$_city_api->html()?>
</form>