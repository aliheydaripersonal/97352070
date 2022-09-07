<?php $this->load_template("header.php"); ?>
<?php $this->load_template("message.php"); ?>
<ul class="tabs">
	<li <?=$D->tab=="main"?"class=\"active\"":""?>><a href="<?=$C->SITE_URL?>panel/"><?=$this->lang("my posts")?></a></li>
	<li <?=$D->tab=="favorites"?"class=\"active\"":""?>><a href="<?=$C->SITE_URL?>panel/tab:favorites/"><?=$this->lang("my favorites")?></a></li>
</ul>
<ul class="items">
	<?php foreach($D->result->result as $post){$D->post = $post;?>
		<?php $this->load_template("single_post.php"); ?>
	<?php } ?>
</ul>
<?php $this->load_template("paging.php"); ?>
<?php $this->load_template("footer.php"); ?>