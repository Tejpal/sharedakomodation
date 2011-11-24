<?php //print_r($result2);exit;
$baseurl = site_url() . '/';
$staticurl = $this->config->item('static_url');

$adslink=$baseurl.'ads/detail/'.$result2[0]['title'].'/'.$result2[0]['ads_id'];

$rentTypeList = getRentTypeList();
		$rent=$result2[0]['rent'];
		$renttype=$result2[0]['rent_type'];
		$city=$result2[0]['city'];
		$street_address=$result2[0]['street_address'];
		$postal_code=$result2[0]['postal_code'];
		$imgname=$result2[0]['name'];
		
		$sliderContent = '<a href="'.$adslink.'"><img src="'.$staticurl.'ads_upload/img1_'.$imgname.'" />
		</a><p class="detailBar">$'.$rent.' '.$rentTypeList[$renttype].' - '.$postal_code.' '.$city.'</p>';
		
		echo $sliderContent;
?>