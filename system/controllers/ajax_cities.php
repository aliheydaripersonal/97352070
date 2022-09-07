<?php
    $_output = [];
    if(isset($_GET["query"])){
        $q = urldecode($_GET["query"]);
        $_result = $this->db->fetch_all("SELECT `id` FROM `cities` WHERE `name` LIKE '%".$this->db->e($q)."%' OR `alternates` LIKE '%".$this->db->e($q)."%' ");
        
        foreach($_result as $item){
            $_city = $this->core->get_city_by_id($item->id);
            $_province = $this->core->get_province_by_id($_city->province_id);
            $_country = $this->core->get_country_by_id($_province->country_id);
            $_output[] = (object)[
                "value"=>$_city->id,
                "label"=>$_city->name,
                "desc"=>$_country->name.', '.$_province->name.', '.$_city->name,
                "url"=>$_city->url,
                "id"=>$_country->name.', '.$_province->name.', '.$_city->name,
            ];
        }
    }
    echo $_GET["callback"].'('.json_encode($_output).');';