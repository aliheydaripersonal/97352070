<?php
if(strpos($C->FULL_URL_FOR_PAGING,"page:")!==false){
    $exploded = explode("/",$C->FULL_URL_FOR_PAGING);
    foreach($exploded as $key=>$value){
        if(substr($value,0,5)=="page:"){
                unset($exploded[$key]);
        }
    }
    $C->FULL_URL_FOR_PAGING = implode("/",$exploded).'/';
}
if(count($D->result->result) == 0){
    echo alert($this->lang(!isset($D->custom_notfound)?'notFound':$D->custom_notfound),$this->lang(!isset($D->custom_notfound_message)?'nothing':$D->custom_notfound_message,array('#site_url#' => $C->SITE_URL)),isset($D->custom_notfound_link)?$D->custom_notfound_link:false,isset($D->custom_notfound_link_text)?$this->lang($D->custom_notfound_link_text):false,isset($D->custom_notfound_link_blank)&&$D->custom_notfound_link_blank?true:false);
}
if($D->result->page_count > 0){
	$paged_result = "";
    ?>
<div class="paging">
    <?php
    if($D->page > 1){
        $paged_result .= '<a class="item"  href="'.make_pagination_url($C->FULL_URL_FOR_PAGING,1).'">'.$this->lang("first").'</a>'."\n";                            
    }
    if($D->page> 1){
        $paged_perv = $D->page- 1;
        $paged_result .= '<a class="item" href="'.make_pagination_url($C->FULL_URL_FOR_PAGING,$paged_perv).'">'.$this->lang("previous").'</a>'."\n";
    }
    $D->result->middle_page = $D->page + 4;
    $D->result->start_page = $D->result->middle_page - 4;
    for ($i=$D->result->start_page-2; $i<=$D->result->middle_page; $i++){
        if ($i > 0 && $i <= $D->result->page_count){
            if($i == $D->page){
                $paged_result .= '<a class="item active" href="'.make_pagination_url($C->FULL_URL_FOR_PAGING,$i).'">'.$i.'</a>'."\n";
            }
            else{
                $paged_result .= '<a class="item" href="'.make_pagination_url($C->FULL_URL_FOR_PAGING,$i).'">'.$i.'</a>'."\n";
            }
        }
    }
    if($D->page<= $D->result->page_count - 1){
        $paged_next = $D->page+ 1;
        $paged_result .= '<a class="item" href="'.make_pagination_url($C->FULL_URL_FOR_PAGING,$paged_next).'">'.$this->lang("next").'</a>'."\n";
    }
    if($D->page<= $D->result->page_count - 1){
        $paged_result .= '<a class="item" href="'.make_pagination_url($C->FULL_URL_FOR_PAGING,$D->result->page_count).'">'.$this->lang("last").'</a>'."\n";
    }
    echo $paged_result; 
    ?>
</div>
    <?php
}
