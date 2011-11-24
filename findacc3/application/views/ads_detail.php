<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
if(!empty($adsdata)){

$s_add=$adsdata['street_address'];
$city=$adsdata['city'];
$state=$adsdata['state'];
$country=$adsdata['country'];
//print_r($adsdata);
$madd=$adsdata['street_address']." ".$adsdata['city']." ".$adsdata['state']." ".$adsdata['country'];
//echo $madd; //exit;
}



//print_r($var1); exit;

//print_r($adsdata);
$provider = $adsdata;
$ads_id = $provider['ads_id'];
$user_id = $provider['user_id'];
$title = $provider['title'];
$title_s = addslashes($title);							
$title_url = encodeurl($title);
$full_url = $baseurl . 'ads/detail/' . $title_url . '/' . $ads_id;
if($provider['sharing_type']==1)
$edit_url = $baseurl . 'ads/update/' . $ads_id;
if($provider['sharing_type']==0)
$edit_url = $baseurl . 'ads/update_finder/' . $ads_id;
$full_contact_url = $baseurl . 'ads/contact/' . $title_url . '/' . $ads_id .'/'.$user_id;
$extend_ad_url = $baseurl . 'myads/extendad/'. $ads_id .'/1';

//if(isset($_SESSION['user_id']))
if($this->session->userdata('user_id'))
{
//$uid=($_SESSION['user_id']);
$uid=$this->session->userdata('user_id');
$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id .'/'.$uid ;
}
//if(!isset($_SESSION['user_id']))
if(!$this->session->userdata('user_id'))
{
$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id .'/'.$user_id ;
}
$full_report_url = $baseurl . 'ads/reportspam/' . $title_url . '/' . $ads_id;


$rentTypeList = getRentTypeList();
$parkingtype = getParkingType();



$utl_bills2 = array();
if(!empty($utl_bills) && is_array($utl_bills))
{
	foreach($utl_bills as $utl_bill)
	{
		$utl_bills2[] = $utl_bill['value'];
	}
}
//print_r($utl_bills2);
$furinished_list2 = array();
if(!empty($furinished_list) && is_array($furinished_list))
{
	foreach($furinished_list as $furinished_list3)
	{
		$furinished_list2[] = $furinished_list3['value'];
	}
}	
//print_r($furinished_list2);	


// title 	description 	name 	full_url real_path
if(!empty($provider['name']) && !empty($provider['real_path']))
	$imgurl = $base_url . $provider['real_path'] . $provider['name'];
else
	$imgurl = $staticurl . 'images/fullAd1.jpg';

?>

 <?php 
// $date=date("Y-m-d");echo $date; exit;
//echo $adsdata['addedtime'];
 $end_ts = strtotime($adsdata['expiry_date']);
  $start_ts = strtotime(date("y-m-d"));
  $diff = $end_ts - $start_ts;
  $days =round($diff / 86400);
?>


<script type="text/javascript"> 
$(document).ready(function(){

});
</script>	

<div id="contentContainer">
  <div id="contentHolder">
    <div id="contentLeft">
    	<div id="mainDetailsHeading">
        <!--	<?php// if(!empty($_SESSION['user_id']) && $_SESSION['user_id']==$provider['user_id']){ ?>-->
        	<?php if($this->session->userdata('user_id') && $this->session->userdata('user_id')==$provider['user_id']){ ?>
        	<div class="previewMenu roundBor3">
            	<p class="flLeft"><img src="<?=$staticurl?>images/editpenSml.png" width="12" height="12" class="previewIcns" /></p>
                <p class="flLeft prMenLink"><a href="<?=$edit_url?>">Edit Ad</a></p>
                <p class="flLeft"><img src="<?=$staticurl?>images/deactivateicn.png" width="12" height="12" class="previewIcns" /></p>
				<?php  if($provider['status']==0) {if($days>=0){?><p class="flLeft prMenLink "><a href="<?=$baseurl?>myads/activatead/<?php echo $adsdata['ads_id'];?>/1/<?=$days?>" class="greybox">Activate Ad</a></p><?php } }?>
				<?php if($provider['status']==1) {if($days>=0){?>  <p class="flLeft prMenLink "><a href="<?=$baseurl?>myads/deactivatead/<?php echo $adsdata['ads_id'];?>/1/<?=$days?>" class="greybox">Deactivate Ad</a></p><?php } }?>
				<?php if($days<=7) {?>  <a class="flLeft prMenLink greybox " href="<?=$extend_ad_url;?>" widt='650'  heigh='500'> Extend Ad</a><?php } ?>
			   <p class="flRight">Expiry - <?echo date('j F Y',strtotime($adsdata['expiry_date']))?>&nbsp;&nbsp;|&nbsp;&nbsp;
                Status - <strong><?php if($provider['status']==1){echo "Active";}else{echo "Not-Active";} ?></strong></p>
                <p class="clearer"></p>
            </div>
			
			<?php } ?>
			
			
			
			
			<?php 
			
		$success = $this->session->flashdata('success'); 
		if(!empty($success))
		 {
		echo "<p id='success_ads_detail' class='success_notify'>$success</p>";
		
		 }
		$alert = $this->session->flashdata('alert'); 
		if(!empty($alert))
		{
			echo "<p id='notify_alert_ads_detail' class='alert_notify'>$alert</p>";
		}?>
			
			
   		  <h2 class="fullAdhd flLeft">
			<? if($provider['street_address']){ $space=', ';}else{$space='';}?>
				<?=$provider['street_address'].$space?><span class="capitalTxt"><?=$provider['city'].', '?></span><?=$provider['state'].' '.$provider['postal_code']?></h2>
			<h2 class="flRight">$<?=$provider['rent'].' '.$rentTypeList[$provider['rent_type']]?></h2>
            <br class="clearer" />
    	</div>
            <p class="clearer"></p>
		<div id="mainDetails">
            <div id="imgHolder"> 
				<!--
				<img class="detailimg" src="<?=$imgurl?>" />
				-->
				<?php
				// print_r($adsImages);
				if(!empty($adsImages) && is_array($adsImages) && count($adsImages)>0)
				{
					?>
					<img class="detailimg" src="<?=$staticurl?>ads_upload/img1_<?=$adsImages[0]['name']?>" />
					<?php										
				}
				else
				{
					?>
					<img class="detailimg" src="<?=$staticurl?>images/dumimage2.jpg" />
					<?
				}
				?>				
            	<div class="imageLinksHol">
					<span class="floatLeft">
						<img src="<?=$staticurl?>images/cameraIcon.png" width="15" height="11" />
						&nbsp;<a href="#">Photos(<?=(!empty($adsImages))?count($adsImages):0?>)</a>&nbsp;&nbsp;&nbsp;
					</span>  
					<span class="viewcntr">&nbsp;<?=$adsviews?> Ad Views</span>  
                    <span id="viewicon"><img src="<?=$staticurl?>images/adviews.png" /></span>          	
					<br class="clearer" />
				</div>
                <div class="prevbtnhol">
                	<a href="<?=$full_shortlist_url?>" class="prewactbtn roundBor3">Shortlist</a>
                    <a href="#" class="prewactbtn roundBor3">Print</a>
                    <a href="#" class="prewactbtn roundBor3">Email Friend</a>
                    <a href="#" class="prewactbtn roundBor3">Share</a>
                    <a href="#" class="prewactbtn roundBor3">Report Spam</a>
                </div> 
            </div>
            
			<?php
			$getPropertyType = getPropertyType();
			?>
            <div id="detailsArea">
            	<div id="detailsHeading">
				
					<span class="proptyep"><?=$getPropertyType[$provider['property_type']]?></span>
                    <span class="floatLeft"><img src="<?=$staticurl?>images/bedIcon.gif" width="21" height="14" id="faBedIcon" /></span>
                    <span class="floatLeft boldText lessdark"><?=$provider['bed_rooms']?></span>
                  <!--  <span class="floatLeft"><img src="<?=$staticurl?>images/tubIcon.gif" width="21" height="14" id="faTubIcon" /></span>
                    <span class="floatLeft boldText lessdark" ><?=$provider['bath_rooms']?></span>-->
                    <a href='<?=$full_contact_url;?>' widt='650'  heigh='535'  title='<?php if($adsdata['sharing_type']==1) {?>Contact Provider<?php } elseif($adsdata['sharing_type']==0){?> Contact Finder<?php }?>'  class='flRight prewcntbtn roundBor3 greybox' style='color:#fff;'><?php if($adsdata['sharing_type']==1) {?>Contact Provider<?php } elseif($adsdata['sharing_type']==0){?> Contact Finder<?php }?></a>
                   <br class="clearer" />
           	  </div>
              <div id="upddethol" class="roundBor3">
            	<p class="floatLeft" >Available - <?=date('d M Y',strtotime($provider['availability']))?></p>
                <p id="updatedfld">Ad Updated: <?=showupdateddate($provider['updated_date'])?></p>
            	<br class="clearer" />
          </div>
              	<h2 class="padTop10 font16"><?=$title?></h2><br/>						
			<p class="lessdark">
				<strong><?=$provider['bestfeature1']?><br/>
				<?=$provider['bestfeature2']?>
				</strong>
			</p><br/>
			<p id="prewdesc">
				<?=$provider['description']?> 
			</p>
              	
		  </div>
                <p class="clearer"></p>
          
      </div>
	  
      <ul class="prefboxes prefmar">
             	  	<li><h3>ROOM/PROPERTY DETAILS</h3></li>
                  <li><span class="boldText">Rent</span> - $<?=$provider['rent'].' '.$rentTypeList[$provider['rent_type']]?></li>
                  <li><span class="boldText">Bond</span> - $<?=$provider['bond']?></li>
                  <li><span class="boldText">Availability</span> - <?=date('d M, Y',strtotime($provider['availability']))?></li>
                  <li><span class="boldText">Min Stay</span> - <?=$provider['min_stay']?> months</li>
                  <li><span class="boldText">Max Stay</span> - <?=$provider['max_stay']?> months</li>
                  <li><span class="boldText">Utilities Included</span> - 
					<?php
					
					if(!empty($utl_bills2))
					{$utilBillsListText = '';
						if(is_array($utl_bills2) && count($utl_bills2)>0)
						{ 
						foreach($utl_bills2 as $utl_bills1)
							{
								if($utilBillsListText!='')
									$utilBillsListText .= ', ';
								$utilBillsListText .= $utl_bills1;		
							}
						}
						//$mywtext1 = character_limiter($utilBillsListText,15);
						
					
                                         
                      
						echo "Yes"." "."<a id='flip1'>View list</a><br>";
						echo '<p id="panel1">'.$utilBillsListText.'</p>';
						//echo $mywtext1;
					}
					else
					{
						echo "No";
					}
					?>				  
				  </li>
                  <li><span class="boldText">Furnished</span> - 
					<?php
					if(!empty($furinished_list2))
					{	
						$utilBillsListText = '';
						if(is_array($furinished_list2) && count($furinished_list2)>0)
						{
							foreach($furinished_list2 as $utl_bills1)
							{
								if($utilBillsListText!='')
									$utilBillsListText .= ', ';
								$utilBillsListText .= $utl_bills1;		
							}
						}
						//$mywtext2 = character_limiter($utilBillsListText,15);
						
						echo "Yes"." "."<a id='flip2'>View list</a><br>";
						echo '<p id="panel2">'.$utilBillsListText.'</p>';
						//echo $mywtext2;
					}
					else
					{
						echo "No";
					}
					?>				  
				  </li>
                  
                  <li><span class="boldText">Parking</span> - <?=$parkingtype[$provider['parking']]?></li>
   	  </ul>
      <ul class="prefboxes prefmar" >
                  <li><h3>PROVIDER'S PREFERENCES</h3></li>
                  <li><span class="boldText">Community</span> -<? if($provider['community']){echo "<a id='flip3'>View list</a><br>"; echo '<p id="panel3">'.getList1(getCommunityList(),$provider['community']).'</p>';}else {echo 'NIL';}?></li>
                  <li><span class="boldText">Gender</span> - <?=displayList(getGenderList(), array($provider['gender']))?></li>
                  <li><span class="boldText">Smoker</span> - <?=displayList(getSmokerList(), array($provider['smoker']))?></li>
                  <li><span class="boldText">Age Group</span> - <?=displayList(getAgeGroupList(), array($provider['age']))?></li>
                  <li><span class="boldText">Orientation</span> - <?=displayList(getOrientationList(), array($provider['orientation']))?></li>
				  <li><span class="boldText">Diet</span> - <?=displayList(getDietList(), array($provider['diet']))?> </li>
				  <li><span class="boldText">Occupation</span> - <?=displayList(getOccupationType(), array($provider['occupation']))?> </li>
              	</ul>
      <ul class="prefboxes" >
                  <li><h3>ABOUT PROVIDER</h3></li>
                  <li><span class="boldText">Name</span> - <?=$provider['first_name'].' '.$provider['last_name']?></li>
                  <?php if($provider['phone_visibility']==1) { ?>
                  <li><span class="boldText">Email ID</span> -<a href="mailto:<?=$provider['email']?>"><?=$provider['email']?></a></li>
				  <?php } if($provider['email_visibility']==1) { ?>
				  <li><span class="boldText">Phone Number</span> - <?=$provider['phone']?></li>
				  <?php } ?>
				  
				</ul>
      <p class="clearer"></p>

		

			
			<div id="googleMap"></div>

				
		
		</div>
        <div id="ads">
     		
			<img src="<?=$staticurl?>images/ads.jpg" width="170" height="502"/>
	  </div>
    </div>
    
     
    <br class="clearer">
	</div>
    <br class="clearer">
</div>


<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">

var map;
var geocoder;
function initialize() {
 geocoder = new google.maps.Geocoder();
  var myOptions = {
	zoom: 16,
	mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
  codeAddress();
}
google.maps.event.addDomListener(window, 'load', initialize);
  
  function codeAddress() {
  var address = "<?if(isset($madd)){ echo $madd;} else {echo 'sydney';}?>";
  geocoder.geocode( { 'address': address}, function(results, status) {
	if (status == google.maps.GeocoderStatus.OK) {
	  map.setCenter(results[0].geometry.location);
	  var marker = new google.maps.Marker({
		  map: map, 
		  position: results[0].geometry.location
	  });
	} else {
	  //alert("Geocode was not successful for the following reason: " + status);
	}
  });
}

function afterclose() {
   window.location.reload();
}   
$("#flip1").click(function(){
  $("#panel1").toggle("fast");
}); 
$("#flip2").click(function(){
  $("#panel2").toggle("fast");
});
$("#flip3").click(function(){
  $("#panel3").toggle("fast");
});
</script>