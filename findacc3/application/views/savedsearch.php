<?php
$baseurl = site_url() . '/';
?>
<html>
<h1>Your saved searches</h1>
<?php foreach($result as $key => $value) {?>
<a href="<?=$baseurl.'ads/search?'.$value['url']?>"><?=$value['location']?></a><br>
<?php }?>
</html>