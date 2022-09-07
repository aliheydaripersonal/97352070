<?php $this->load_template("header.php"); ?>
<h1 class="title"><?=$this->lang($D->title)?></h1>
<?php $this->load_template("message.php"); ?>
<?php if($D->section=="category") { ?>
<form action="" method="post">
    <?=$D->api->html()?>
    <?php if(1==2){ ?>
    <div class="form_group"><center>
        <?php
        $_recaptcha = new \ReCaptcha\ReCaptcha($C->RECAPTCHA->SECRET_KEY);
        echo $_recaptcha->show();
        ?>
    </center></div>
    <?php } ?>
    <input style="width:100%" id="submit_category" class="button" name="submit" type="submit" value="<?=$this->lang("send")?>"></input>
</form>
<?php }else{ ?>
<form action="" method="post">
    <?=$D->api->html()?>
    <?php if(1==2){ ?>
    <div class="form_group"><center>
        <?php
        $_recaptcha = new \ReCaptcha\ReCaptcha($C->RECAPTCHA->SECRET_KEY);
        echo $_recaptcha->show();
        ?>
    </center></div>
    <?php } ?>
    <input style="width:100%" class="button" name="submit" type="submit" value="<?=$this->lang("send")?>"></input>
</form>
<?php } ?>
<?php $this->load_template("footer.php"); ?>