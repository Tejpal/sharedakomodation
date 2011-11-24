<?php

function encodeurl($adTitle)
{
	$adTitle = str_replace(' ','-',$adTitle);
	$adTitle = str_replace(',','-',$adTitle);
	$adTitle = str_replace('\'','-',$adTitle);
	$adTitle = str_replace('"','-',$adTitle);
	
	$adTitle = urlencode($adTitle);
	return $adTitle;
}

?>