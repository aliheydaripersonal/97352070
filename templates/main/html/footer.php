			</main>
</div>
<footer><br /><br /><br /><br />
<?php if(!isset($D->disable_footer_template)){ ?>
		<div class="footer">
			<div class="copyright"><?=$this->lang("copyright")?></div>
		</div>
<?php } ?>
<?php
	if( $C->DEBUG_MODE ) { $this->load_template('footer_debuginfo.php'); }
?>

<script>
	$('.toggle_favorite').click(function() {
		$post_id = $(this).attr('post_id'); 
		var req = $.get( SITE_URL+"ajax/post/type:toggle_favorite/id:"+$post_id, function(data) {
			mydata = JSON.parse(data);
			if(mydata.message=="favorited"){
				$("#favorite_"+$post_id).hide();
				$("#unfavorite_"+$post_id).show();
			}else{
				$("#favorite_"+$post_id).show();
				$("#unfavorite_"+$post_id).hide();
			}
		});
	});
	
	function show_loading(){}
	function hide_loading(){}
</script>
</footer>	
	</body>
</html>
