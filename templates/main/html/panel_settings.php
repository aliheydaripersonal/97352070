<?php $this->load_template("header.php"); ?>
<h1 class="title"><?=$this->lang($D->title)?></h1>
<?php $this->load_template("message.php"); ?>
<form action="" method="post">
    <?=$D->api->html()?>
    <input style="width:100%" class="button" name="submit" type="submit" value="<?=$this->lang("submit")?>"></input>
</form>
<?php $this->load_template("footer.php"); ?>