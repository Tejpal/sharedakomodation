<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>
<form action="" name="usernameform" id="usernameform" method="POST">
	<label>Enter New Username</label> <span id="error" class="d_error_message"></span><br />
	<input type="text" style="width:260px; height:30px;" name="username" id="username" /><br />
	<span id="updatecancel" class="d1">
		<input type="button" value="Update" id="updateUsername" name="updateUsername" />
		<input type="button" id="chCancel" value="Cancel" />
	</span>
	<span id="updatecancel-progress" class="d2">
		<span class="processing">Processing please wait...</span>
		<img src="<?=$staticurl?>images/processing.gif">
	</span>
</form>