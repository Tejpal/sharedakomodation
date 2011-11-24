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
				<?php
				if($user_activation_flag)
				{				
				?>
					<h2>Welcome, <?=$firstname?></h2>					
					<label class=' validation success_message'>
						You have successfully activated your account!
					</label>					
					<div id="regBtnDiv" >
						Now you have full access to your account.<br>
						After login you can change your any information.<br>
						Now you can post ads.
					</div>	
				<?php
				}
				else
				{
				?>										
					<div class="clear">
						<label class=' validation success_message2'>
						<?=$activation_error_message?>
						</label>
					</div>
					<div class="clear d_h5">
					</div>
					<div class="clear" >
						Check the email and use proper link to activate your account.
					</div>				
				<?php
				}
				?>		
					
				
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
