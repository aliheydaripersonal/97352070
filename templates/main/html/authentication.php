<?php $this->load_template("header.php"); ?>
<?php $this->load_template("message.php"); ?>
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
<?php $this->load_template("footer.php"); ?>