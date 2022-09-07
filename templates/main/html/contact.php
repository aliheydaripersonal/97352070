<?php $this->load_template("header.php"); ?>
<h1 class="title"><?=$this->lang("contact")?></h1>
<?php $this->load_template("message.php"); ?>
<p>
<?=$this->lang($D->description)?>
</p>
<form action="" method="post">
	<div class="form_group">
		<label><?=$this->lang("department")?> : </label>
		<select class="form_field" name="department">
			<?php foreach($D->departments as $key=>$value){ ?>
				<option value="<?=$key?>"><?=$this->lang($value->label)?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form_group">
		<label><?=$this->lang("subject")?> : </label>
		<input class="form_field" name="subject" value="<?=$D->data->subject?>"></input>
	</div>
	<div class="form_group">
		<label><?=$this->lang("mail")?> : </label>
		<input class="form_field" name="mail" value="<?=$D->data->mail?>"></input>
	</div>
	<div class="form_group">
		<label><?=$this->lang("phone")?> : </label>
		<input class="form_field" name="phone" value="<?=$D->data->phone?>"></input>
	</div>
	<div class="form_group">
		<label><?=$this->lang("message")?> : </label>
		<textarea class="form_field" name="message" ><?=$D->data->message?></textarea>
	</div>
	<div class="form_group">
		<label><?=$this->lang("captcha")?> : </label>
		<?php
		$_recaptcha = new \ReCaptcha\ReCaptcha($C->RECAPTCHA->SECRET_KEY);
		echo $_recaptcha->show();
		?>
	</div>
	<div class="form_group">
		<input class="button" type="submit" name="submit" value="<?=$this->lang("submit")?>"></input>
	</div>
</form>
<?php $this->load_template("footer.php"); ?>