<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>
<div id="contentContainer">
	<div id="contentHolder">
		<div id="contentLeft">
			<div id="signinPage">
				<h2>Forgot Password</h2>
				
				<?php
				if($signin_error_flag)
				{				
				?>
					<label class=' validation success_message2'>
						<?=$signin_error_message?>
					</label>					
					<div id="regBtnDiv" >
						Check your email, we have send an email to set new password!.
					</div>				
				<?php
				}
				else
				{
				?>										
					<?php						
					if(!empty($signin_error_message)){
						echo "<label class='error_message validation'>$signin_error_message</label>";
						//echo "<br/><br/>";
					}
					?>
					<div id="signinForm" >
						<form action="" name="loginform" id="loginform" method="post">					
						
							<label for="email" ><span class="replace">Email </span></label>

							<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>"  /><br/>

							<?php echo form_error('email'); ?><br/><br/>

							
							<input type="image" src="<?=$staticurl?>images/signin2.gif" id="signinBtn" /><br/><br/>

							<a href="<?=$baseurl?>user/signin/"> 
								Signin 
							<!--</a>
							&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$baseurl?>user/forgotusername/" >Forgot username?</a>-->
						</form>
					</div>				
				<?php
				}
				?>	

				<div id="notRegistered">

					<h3>NOT REGISTERED YET?</h3><br/>
					<a href="<?=$baseurl?>user/signup/">
						<input type="image" src="<?=$staticurl?>images/registerNow.gif" id="registerNowBtn">
					</a>
					<ul>

						<li>1. Click Register Now button</li>

						<li>2. Fill the Registration Form</li>
						<li>3. Check your Email</li>
						<li>4. Click on Activation Link</li>

					</ul>

					<p>After following the steps above, your account should be activated 
					and you can go ahead and fill in the details of your ad and POST IT.

					</p>

				</div>

			</div>

		</div>

		<div id="ads" align="right">

			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>

	  	</div>
<br class="clearer">
	</div>
<br class="clearer">
</div>