<?php
	header("HTTP/1.0 404 Not Found");
	$this->load_template("header.php");
?>
<div class="page-404">
	<div class="show-404">404</div>
	<div class="description"><?=$this->lang("pageNotfoundDescription")?></div>
</div>
<?php
	$this->load_template("footer.php");
?>