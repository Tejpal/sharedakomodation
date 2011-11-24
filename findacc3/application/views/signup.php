<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');

?>
<div id="bannerShade">
</div>

<div id="contentContainer">
  	<div id="contentHolder">
		<form action="" name="registerform" id="registerform" method="post">
			<div id="contentLeft">			
				<div id="registerPage">
					<h2>REGISTER</h2>
                  <div class="already-signin">
						  Already Registered?&nbsp;&nbsp;
						  <a href="<?=$baseurl?>user/signin/">
							  Signin Now
						  </a>
				    </div>
                    <p class="clearer"></p>	
                
					
					<?php						
					if(!empty($signup_error_message)){
						echo "<label class='error_message validation'>$signup_error_message</label>";
					
					}
					?>
                    
                    
                    
                    
<div class="creationboxsml roundBor3">
    <div id="regfieldhollt">
        <p class="regsmlflds">
            <label class="nwlabel" for="firstname">Firstname *</label>
            <input type="text" id="firstName3" name="firstname" class="if140 inputFieldnw" value="<?php echo set_value('firstname'); ?>" />
            <span class="validationHolder"><?php echo form_error('firstname'); ?><?php echo form_error('firstname_check'); ?></span>
        </p>
        <p class="regsmlflds" id="regsurnam">
            <label class="nwlabel" for="lastname">Lastname *</label>
            <input type="text" id="lastName3" name="lastname" class="if140 inputFieldnw" value="<?php echo set_value('lastname'); ?>" />
            <span class="validationHolder"><?php echo form_error('lastname'); ?><?php echo form_error('lastname_check'); ?></span>
        </p>
        <br class="clearer" />
        <p class="regsmlflds">
            <label class="nwlabel" for="emailid">Email ID *</label>
            <input type="text" id="emailid" name="emailid" class="if285 inputFieldnw" value="<?php echo set_value('emailid'); ?>" />
            <span class="validationHolder"><?php echo form_error('emailid'); ?></span>
        </p>
    </div>
    <div id="regfieldholrt">
    	 <p class="regsmlflds">
            <label class="nwlabel" for="userpassword">Password *</label>
            <input type="password" id="userPassword3" class="if285 inputFieldnw" name="userpassword" value="<?php echo set_value('userpassword'); ?>" />
            <span class="validationHolder"><?php echo form_error('userpassword'); ?></span>
        </p>
        <br class="clearer" />
        <p class="regsmlflds">
            <label class="nwlabel" for="confirmpassword">Confirm Password *</label>
            <input type="password" id="confirmPassword" class="if285 inputFieldnw" name="confirmpassword" value="<?php echo set_value('confirmpassword'); ?>" />
            <span class="validationHolder"><?php echo form_error('confirmpassword'); ?></span>
        </p>
    </div>
    <br class="clearer" />
    <div class="rgutilfur roundBor3">
        <iframe src="<?=$baseurl?>user/captcha/34534534534" frameborder="0" height="86" width="275" scrolling="no" id="captchaFrm"></iframe>
        <p class="verifieldhol">
            <label class="nwlabel" for="verifycode">Enter Verification Code *</label>
            <input type="text" id="verifycode" name="verifycode" class="if250 inputFieldnw" /><br/>
             <span class="validationHolder"><?php echo form_error('verifycode'); ?>
            <?php echo form_error('verification'); ?></span>
        </p>
        <br class="clearer" />
    </div>
</div>
	<div id="prevPostBtnDiv">
		<input type="image" src="<?=$staticurl?>images/register.gif" id="registerBtn" name="registerbtn" class="imgBtnHover" />
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
