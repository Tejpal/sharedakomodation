<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Find Accomodation - Get Shared Accommodation . Anywhere . Anytime .</title>
<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';

$rentTypeList = getRentTypeList();
$property_type = getPropertyType();

if($this->session->userdata('user_id'))
{

$sender_uid=$this->session->userdata('user_id');
}
else
{$sender_uid=0;}
?>

<link href="<?=$staticurl?>css/find.css" rel="stylesheet" type="text/css" />
<script src="<?=$staticurl?>js/jquery.min.js"></script>
<script src="<?=$staticurl?>js/jquery-ui.min.js"></script>
<script src="<?=$staticurl?>js/cufon-yui.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinMedium_500.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinRegular_400.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/mydocumentready.js" type="text/javascript"></script>


</head>

<body>
<div class="contactFormgray">
	<div class="ctFormform">
	<form action="" name="contactForm" id="contactForm" method="post" >
      <label for="yourEmail" class="normallabel">Your Email ID</label><br />
      <input type="text" id="yourEmail" name="yourEmail" value="<?php if($this->session->userdata('email')){echo $this->session->userdata('email');} ?>" class="if295 inputField" /><p class="validationHolder">&nbsp;<?php echo form_error('yourEmail'); ?></p>
	  
	   <label for="firstName" class="normallabel">Name</label><br />
      <input type="text" id="firstName" name="firstName" value="<?php  if($this->session->userdata('firstname')){ echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname');} ?>" class="if295 inputField" /><p class="validationHolder">&nbsp;<?php echo form_error('firstName'); ?></p>
	 <label for="yourMessage" class="normallabel">Your Message to Provider</label><br />
      <textarea rows="10" name="yourMessage" id="yourMessage"  class="if295 textField"><?php if(isset($_POST['yourMessage'])){echo $_POST['yourMessage'];}?></textarea>
	  <p class="validationHolder">&nbsp;<?php echo form_error('yourMessage'); ?></p>
      <p align="center">
      <input type="checkbox" id="sendCopy" name="sendCopy"/>
      <label for="sendCopy">Send me a copy of this Email</label><br/><br/>
      <input type="submit" name="sendMessBtn" id="sendMessBtn" class="hoverFade" value=""></p>
	  <input type="hidden" name="r_name" value="<?=$rinfo[0]['first_name']?>  <?=$rinfo[0]['last_name']?>">
	  <input type="hidden" name="r_email" value="<?=$rinfo[0]['email']?>">
	  <input type="hidden" name="sender_uid" value="<?=$sender_uid?>">
    </div>
	</form>
    <div class="ctFormdetHol">
   	  <h2 class="ctFormHead">This message is for</h2>
		<?=$rinfo[0]['title']?><br /><br />
        <p class="flLeft"><img src="<?=$staticurl?>images/ctFormphone.gif" /></p>
        <p class="flLeft"><strong><?=$rinfo[0]['first_name']." ".$rinfo[0]['last_name']?></strong><br />
        	<?=$rinfo[0]['phone']?>
        </p>
        <p class="clearer"></p><br />
        <p class="flLeft"><img src="<?=$staticurl?>images/ctFormhome.gif" /></p>
        <p class="flLeft"><?=$rinfo[0]['street_address']?><br />
        	<?=$rinfo[0]['city'].",".$rinfo[0]['state']." ".$rinfo[0]['postal_code'] ?><br /><br />
        	<strong>Rent</strong><br />
			
            $<?=$rinfo[0]['rent']."  ".$rentTypeList[$rinfo[0]['rent_type']]?><br /><br />
			
			<strong>Availability</strong><br />
            <?=$rinfo[0]['availability']?><br /><br />
			
			<strong>Property Type</strong><br />
			<?=$property_type[$rinfo[0]['property_type']]?><br /><br />
        </p>
    </div>
    <p class="clearer"></p>
</div>
</body>
</html>