<?php
	if($D->SUCCESSFUL){
		if(is_array($D->SUCCESSFUL_MESSAGE)){
			foreach($D->SUCCESSFUL_MESSAGE as $key=>$value){
				?>
				<div class="error successful"><div class="sub_title"><?=$this->lang("successful")?></div><div class="message"><?=$this->lang($value)?></div></div>
				<?php
			}
		}else{
			?>
			<div class="error successful"><div class="sub_title"><?=$this->lang("successful")?></div><div class="message"><?=$this->lang($D->SUCCESSFUL_MESSAGE)?></div></div>
			<?php
		}
	}
	if($D->ERROR){
		if(is_array($D->ERROR_MESSAGE)){
			foreach($D->ERROR_MESSAGE as $key=>$value){
				?>
				<div class="error"><div class="sub_title"><?=$this->lang("error")?></div><div class="message"><?=$this->lang($value)?></div></div>
				<?php
			}
		}else{
			?>
			<div class="error"><div class="sub_title"><?=$this->lang("error")?></div><div class="message"><?=$this->lang($D->ERROR_MESSAGE)?></div></div>
			<?php
		}
	}
?>