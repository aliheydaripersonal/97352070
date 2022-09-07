<?php $this->load_template("header.php"); ?>
<h1 class="title"><?=$this->lang($D->title)?></h1>
<?php $this->load_template("message.php"); ?>
<div class="search_box">
    <div class="categories">
        <ul>
            <?php foreach($D->display_categories as $_category){ ?>
            <li><a href="<?=$D->city->url.$_category->uri?>"><?=$this->lang($_category->name)?></a></li>
            <?php } ?>
        </ul>
    </div>
    <form action="" method="get">
        <?=$D->api->html()?>
        <?php if(1==2){ ?>
        <div class="form_group"><center>
            <?php
            $_recaptcha = new \ReCaptcha\ReCaptcha($C->RECAPTCHA->SECRET_KEY);
            echo $_recaptcha->show();
            ?>
        </center></div>
        <?php } ?>
        <input style="width:100%" class="button" name="submit" type="submit" value="<?=$this->lang("search")?>"></input>
    </form>
</div>
<div class="search_result">
    <ul class="items">
        <?php foreach($D->result->result as $post){$D->post = $post;?>
            <?php $this->load_template("single_post.php"); ?>
        <?php } ?>
    </ul>
    <?php $this->load_template("paging.php"); ?>
</div>
<?php $this->load_template("footer.php"); ?>