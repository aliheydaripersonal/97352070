<?php $this->load_template("header.php"); ?>
</div>
	<div class="home_city_search">
		<div class="container">
		<?php $this->load_template("city_search.php"); ?>
		</div>
	</div>
<div class="container cities">
<?php $this->load_template("message.php"); ?>
<ul class="items">
	<?php foreach($D->result->result as $city){?>
		<li><a href="<?=$city->url?>"><?=$this->lang($city->name)?></a></li>
	<?php } ?>
</ul>
<?php $this->load_template("footer.php"); ?>