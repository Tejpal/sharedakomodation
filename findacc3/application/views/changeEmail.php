<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>
<form action="" name="emailform" id="emailform" method="POST">
	<label>Enter New Email</label><span id="error" class="d_error_message"></span><br />
	<input type="text" style="width:260px; height:30px;" name="email" id="email"  /><br />
	<span id="updatecancel" class="d1">
		<input type="button" value="Update" id="updateEmail" name="updateEmail" />
		<input type="button" id="chCancel" value="Cancel" />
	</span>
	<span id="updatecancel-progress" class="d2">
		<span class="processing">Processing please wait...</span>
		<img src="<?=$staticurl?>images/processing.gif">
	</span>
	
</form>

