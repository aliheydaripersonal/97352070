<?php $this->load_template("header.php"); ?>
<h1 class="title"><?=$D->post->title?></h1>
<?php $this->load_template("message.php"); ?>
<?php if($this->user->check_login()){ $my_favorite = $this->network->is_favorite_post($this->user->id,$D->post->id);?>
        <a href="javascript:;" class="toggle_favorite" post_id="<?=$D->post->id?>"><i id="favorite_<?=$D->post->id?>" <?=$my_favorite?'style="display:none"':"" ?> class="fa-regular fa-heart"></i><i id="unfavorite_<?=$D->post->id?>" <?=$my_favorite?"":'style="display:none"'?> class="fa-solid fa-heart"></i></a>
<?php }else{ ?>
    <a href="<?=$C->SITE_URL?>authentication/"><i class="fa-regular fa-heart"></i></a> 
<?php } ?>
<div class="post">
<?php if(count($D->post->media)>0){ ?>
    <div class="gallery">
        <div class="main-photo">
            <img id="main-photo" src="<?=$D->post->media[0]->url?>" />
        </div>
        <div class="thumbnails">
            <ul>
            <?php foreach($D->post->media as $_media){ ?>
                <li onclick="MainPhoto('<?=$_media->url?>')"><img src="<?=$_media->thumbnail_url?>" /></li>
            <?php } ?>
            </ul>
        </div>
        <script>
            function MainPhoto($url){
                document.getElementById("main-photo").src = $url;
            }
        </script>
    </div>
<?php } ?>
<div class="contact">
    <ul class="values">
        <li><label><?=$this->lang("phone")?></label><span><?=$D->post->phone?></span></li>
        <li><label><?=$this->lang("mail")?></label><span><?=$D->post->mail?></span></li>
    </ul>
</div>
<ul class="values">
    <?php foreach($D->post->values as $field_id=>$_value){ $_field = $this->core->get_field_by_id($field_id); ?>
        <li><label><?=$this->lang($_field->name)?></label><span><?=$_value?></span></li>        
    <?php } ?>
</ul>
<div class="content">
    <p><?=str_replace("_br_","<br />",htmlspecialchars($D->post->content))?></p>
</div>
</div>
<?php $this->load_template("footer.php"); ?>