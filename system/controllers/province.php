<?php
if(!isset($this->params->province_id))
    $this->redirect("/");
$_cache_unique = "cities_province_".$this->params->province_id;
$D->result = $this->cache->get($_cache_unique);
if(!$D->result){
    $D->result = $this->core->get_list_city("all",null,null,null,"`name` ASC",null,null,$this->params->province_id);
    $this->cache->set($_cache_unique,$D->result,$C->CACHE_EXPIRE_DATE);
}
$D->title = "province";
$D->description = "province";
$this->load_template("province.php");
?>