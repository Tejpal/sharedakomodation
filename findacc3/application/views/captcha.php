<html>
<head>
<style>
body{ padding:0; margin:0; }
.captcha{
	width:220px; 
	height:80px; 
	float:left;
	border:#b4b4b4 solid 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;	
}
.captcha-refresh{
	height: 86px; 
	width: 23px; 
	float: left;
	margin-left:3px;
}
.captcha-refresh:hover{
	filter: alpha(opacity=80); 
	-khtml-opacity: 0.8;     
	-moz-opacity: 0.8;     
	opacity: 0.8; 
}
</style>
</head>
<body>
	<?php
	$staticurl = $this->config->item('static_url');
	?>
	<div class="captcha" >
		<?php echo $image; ?>
	</div>
	<div class="captcha-refresh" >
		<a href="" alt="Refresh" title="Refresh"><input type="image" src="<?=$staticurl?>images/reload.png" id="Refresh" name="Refresh" alt="Refresh" title="Refresh" /></a>
	</div>
</body>
</html>