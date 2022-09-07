<li>
    <div class="item-image"><a href="<?=$D->post->url?>"><span class="item-thumbnail" ><img width="180" height="180" src="<?=$D->post->media[0]->thumbnail_url?>" /><?php if($D->post->media_count){ ?><span class="image-count"><?=$D->post->media_count?></span><?php } ?></span></a></div>
    <div class="item-information">
    <span class="item-title"><a href="<?=$D->post->url?>"><?=htmlspecialchars($D->post->title)?></a></span>
    <span class="item-date"><?=$this->system_date->date("Y-m-d H:i",$D->post->renewal_date) ?></span>
    <span class="item-location"><?php $_city=$this->core->get_city_by_id($D->post->city_id); ?><?=$_city->name?></span>
    <?php $_fields = $this->core->get_list_category_fields($D->post->categories[0]);foreach($_fields as $field){?>
    <span class="item-value"><?=$this->lang($field->name)?> : <?=$D->post->values[$field->id]?></span>
    <?php } ?>
    <?php if($this->user->check_login()){ $my_favorite = $this->network->is_favorite_post($this->user->id,$D->post->id);?>
        <a href="javascript:;" class="toggle_favorite" post_id="<?=$D->post->id?>"><i id="favorite_<?=$D->post->id?>" <?=$my_favorite?'style="display:none"':"" ?> class="fa-regular fa-heart"></i><i id="unfavorite_<?=$D->post->id?>" <?=$my_favorite?"":'style="display:none"'?> class="fa-solid fa-heart"></i></a>
    <?php }else{ ?>
        <a href="<?=$C->SITE_URL?>authentication/"><i class="fa-regular fa-heart"></i></a> 
    <?php } ?>
    <span class="item-button">
    <?php if($this->user->check_login() && $this->user->id == $D->post->user_id){ ?>
        <a href="<?=$C->SITE_URL?>panel/post/section:remove/id:<?=$D->post->id?>/"><button><?=$this->lang("delete") ?></button></a>
        <a href="<?=$C->SITE_URL?>panel/post/section:edit/id:<?=$D->post->id?>/"><button><?=$this->lang("edit") ?></button></a>
    <?php } ?>
    <a href="<?=$D->post->url?>"><button><?=$this->lang("show") ?></button></a>
    </span>
    </div>
</li>