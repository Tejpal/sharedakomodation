<?php $baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';

//print_r($result); exit;
?>


			
<div id="contentContainer">
	<?php
foreach($result as $key => $value)
{
echo '<b>'.$value['firstname']."</b> (".$value['contact_email'].")"." : ".$value['message'].'<br><br>';
}
?>
<br class="clearer">
</div>
