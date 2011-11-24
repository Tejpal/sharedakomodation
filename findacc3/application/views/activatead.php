<?php
$baseurl = site_url() . '/';
$title=$title[0]['title'];


if($c==1){$url=$baseurl.'ads/detail/'.urlencode($title).'/'.$id;}else{$url=$baseurl.'myads/manage';}
?>
<html>
<head>
<script language="JavaScript">


          function redirect_to_parent(){
               parent.parent.window.location = "<?=$url?>";
               parent.parent.GB_hide();
			   parent.parent.window.location = "<?=$url?>";
          }


</script>
</head>
<body>
At the moment your Ad is De-active and does not appear in any listing.
After Activation, Ad will start appearing the listings.
<form action="" name="activateadForm" id="activateadForm" method="post"  onsubmit="redirect_to_parent();">
<input type="submit" name="activatead" value="Activate My Ad Now " onclick="parent.parent.GB_hide();">
Your ad will expire in <?=$days?> days and it will be deactivated automatically. 
You can extend your Ad for another 30 days after expiry.
<!-- <input type="submit" name="cancel" value="Cancel " onclick="parent.parent.GB_hide();"> -->
</form>
</body>
</html>
