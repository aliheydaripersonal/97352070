<?php
$_cache_unique = "provinces_country_30";
$D->result = $this->cache->get($_cache_unique);
if(!$D->result){
    $D->result = $this->core->get_list_province("all",null,null,null,"`name` ASC",null,30);
    $this->cache->set($_cache_unique,$D->result,$C->CACHE_EXPIRE_DATE);
}
$this->load_template("home.php");
?>