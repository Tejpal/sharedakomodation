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
			   parent.parent.window.location = "<?=$url?>";
          }
         

</script>
</head>
<body>
At the moment your Ad is Active and appears in the public listings.
After De-Activation your Ad will not appear in the listing.
<form action="" name="deactivateadForm" id="deactivateadForm" method="post"  onsubmit="redirect_to_parent();">
<input type="submit" name="deactivatead" value="Deactivate My Ad Now " onclick="parent.parent.GB_hide();">
Your ad will expire in <?=$days?> days. 
You can extend your Ad for another 30 days after expiry.
<!-- <input type="submit" name="cancel" value="Cancel " onclick="parent.parent.GB_hide();"> -->
</form>
</body>
</html>
