<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>

<div id="contentContainer">
	<div id="contentHolder">
		<div id="contentLeft">
			<div id="signinPage">
				<h2>SIGN IN</h2>
					
				
			<?php	$alert = $this->session->flashdata('alert'); 
		if(!empty($alert))
		{
			echo $alert;
		}?>
				<div id="signinForm" >
<form action="" name="loginform" id="loginform" method="post">					

<label for="email" >Email </label>

<input type="text" id="email" name="email" class="if270 inputField" value="<?php echo set_value('email'); ?>"  />

<p class="validationHolder">&nbsp;<?php echo form_error('email'); ?></p>

<label for="userpassword" >Password </label>

<input type="password" id="userpassword" name="userpassword" class="if270 inputField" />

<p class="validationHolder">&nbsp;<?php echo form_error('userpassword'); ?></p>

<input type="checkbox" id="rememberMe" name="rememberMe" value="1" />

<label for="rememberMe" id="rememberMeLbl">Keep me signed in </label><br/><br/>

<input type="image" src="<?=$staticurl?>images/signin2.gif" id="signinBtn" class="imgBtnHover" /><br/><br/>

<!--<a href="<?//=$baseurl?>user/forgotusername/" >Forgot username?</a>
&nbsp;&nbsp;|&nbsp;&nbsp;-->
<a href="<?=$baseurl?>user/forgotpassword/" >Forgot password?</a>
</form><br /><br /><br />

				</div>

				<div id="notRegistered">

					<h3>NOT REGISTERED YET?</h3><br/>
					<a href="<?=$baseurl?>user/signup/">
						<input type="image" src="<?=$staticurl?>images/registerNow.gif" id="registerNowBtn" class="imgBtnHover">
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