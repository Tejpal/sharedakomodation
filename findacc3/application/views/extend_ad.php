<?php
$baseurl = site_url() . '/';
$title=$title[0]['title'];

if($c==1)
{$url=$baseurl.'ads/detail/'.$title.'/'.$id;}
else
{$url=$baseurl.'myads/manage';}
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
<form action="" name="extendadForm" id="extendadForm" method="post"  onsubmit="redirect_to_parent();">
<input type="radio" name="extendradio" value='1' checked="checked">Extend for another 30 days<br>
<input type="submit" name="extendad" value="Extend Ad" onclick="parent.parent.GB_hide();">
</form>

</body>
</html>
