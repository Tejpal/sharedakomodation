<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>
<div id="contentContainer">
  	<div id="contentHolder">
		<form action="" name="registerform" id="registerform" method="post">
			<div id="contentLeft">			
				<div class="regsuccess">				
					<h2>Welcome, <?=$firstname?></h2>
					<!--<div><?php //echo validation_errors(); ?></div>-->
					<label class=' validation success_message'>
						You have successfully registered!
					</label>
					
					<div id="regBtnDiv" >
						We have send an activation email to your provided email.<br>
						You must have to activate to get full access.<br>
						Click to activate on provide link in mail.
					</div>					
				
				</div>
			</div>
		</form>
		<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
		</div>
        <br class="clearer">
	</div>
    <br class="clearer">
</div>
