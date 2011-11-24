<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>
<form action="" name="passwordform" id="passwordform" method="POST" >
	<span id="error" class="d_error_message"></span><span id="error" class="d_error_message"></span><br />
	<label>Current Password</label><br />
	<input type="password" style="width:260px; height:30px;" name="currentpassword" id="currentpassword" /><br />
	<label> New Password</label><br />
	<input type="password" style="width:260px; height:30px;" name="newpassword" id="newpassword"  /><br />
	<label>Re-enter New Password</label><br />
	<input type="password" style="width:260px; height:30px;" name="retypenewpassword" id="retypenewpassword" /><br />	
	<span id="updatecancel" class="d1">
		<input type="button" value="Update" id="updatePassword" name="updatePassword" />
		<input type="button" id="chCancel" value="Cancel" />
	</span>
	<span id="updatecancel-progress" class="d2">
		<span class="processing">Processing please wait...</span>
		<img src="<?=$staticurl?>images/processing.gif">
	</span>
</form>
