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
					<h2>Reset New Password</h2>
				<?php
				if($user_activation_flag)
				{				
				?>								
					<label class=' validation success_message'>
						You have change your password successfully!
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
					<?php						
					if(!empty($activation_error_message)){
						echo "<label class='error_message validation'>$activation_error_message</label>";
						//echo "<br/><br/>";
					}
					?>
					<div id="signinForm" >
						<form action="" name="loginform" id="loginform" method="post">

							<label for="userPassword3" ><span class="replace">New Password</span></label>
							<input type="password" id="userPassword3" name="userpassword" value="<?php echo set_value('userpassword'); ?>" /><br/>
							<?php echo form_error('userpassword'); ?><br/><br/>
							<label for="confirmPassword" ><span class="replace">Confirm New Password</span></label>
							<input type="password" id="confirmPassword" name="confirmpassword" value="<?php echo set_value('userpassword'); ?>" /><br/>
							<?php echo form_error('confirmpassword'); ?><br/><br/>						
							<!--
							<label for="email" ><span class="replace">Email </span></label>

							<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>"  /><br/>

							<?php //echo form_error('email'); ?><br/><br/>
							-->
							
							<input type="image" src="<?=$staticurl?>images/signin2.gif" id="signinBtn" /><br/><br/>

							<a href="<?=$baseurl?>user/signin/"> 
								Signin 
							</a>
							&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$baseurl?>user/forgotpassword/" >Forgot username?</a>
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
		</form>
		<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
		</div>
        <br class="clearer">
	</div>
    <br class="clearer">
</div>
