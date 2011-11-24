<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');

?>

 
	<div id="contentContainer">
	<div id="contentHolder">
		<div id="contentLeft">
		
			<div id="myPostedAdsPage">
			
				<h2>MANAGE ADS</h2>
				
				<div id="accMenu">
                <ul>						
                    <li <?=(($page_about==1)?'class="selected"':'')?> ><a href="<?=site_url("/myads/manage/")?>">Manage Ads</a></li>
                    <li <?=(($page_about==2)?'class="selected"':'')?> ><a href="<?=site_url("/myads/shortlisted/")?>">Shortlisted Ads</a></li>
                    <li <?=(($page_about==3)?'class="selected"':'')?> ><a href="<?=site_url("/myads/matching/")?>">Matching Ads</a></li>						
                </ul>
				</div>
				<?php 
		$success = $this->session->flashdata('success'); 
		if(!empty($success))
		 {
		echo "<br><br><p id='success_manage_ad_Page' class='success_notify'>$success</p>";
		 }
		if(isset($_GET['m']))
		 {
			if($this->session->userdata('editFlag')==1)
			{
				echo "<br><br><p id='success_manage_ad_Page1' class='success_notify'>Your ad has been updated successfully</p>";
			}
			else
			{
			echo "<br><br><p id='success_manage_ad_Page2' class='success_notify'>Your ad has been posted successfully</p>";
			}
		 }
	?>
				
                <br class="clearer" />
                <?php if(empty($result)) { ?>
				<p id="ma_noads">You have not posted any ads yet</p>
                <?php } ?>
				
				<?
					if ($page_about == 1)
						$pageurl = 'myads/manage/';
					else if ($page_about == 2)
						$pageurl = 'myads/shortlisted/';
					else if ($page_about == 3)
						$pageurl = 'myads/matching/';					
					else if ($page_about == 1)
						$pageurl = 'myads/manage/';						
					?>
				<ul id="myAdsList">
					<?php
					$n=0;
					$i=0;			
					if(!empty($result) && count($result)>0)
					{
						$n=count($result);
						$n2 = ceil($n);
						//$providers = $adslist['providers'];
						for($i=0;($i<$n2);$i++)
						{
							$provider = $result[$i];
							//echo $provider['expiry_date'];
							$ads_id = $provider['ads_id'];
							$user_id = $provider['user_id'];
							$title = $provider['title'];
							
							$end_ts = strtotime($provider['expiry_date']);
							$start_ts = strtotime(date("y-m-d"));
							$diff = $end_ts - $start_ts;
							$days =round($diff / 86400);
							
							$title_s = addslashes($title);							
							$title_url = encodeurl($title);
							$full_url = $baseurl . 'ads/detail/' . $title_url . '/' . $ads_id;
							if($provider['sharing_type']==1)
							$edit_url = $baseurl . 'ads/update/' . $ads_id;
							if($provider['sharing_type']==0)
							$edit_url = $baseurl . 'ads/update_finder/' . $ads_id;
							$full_contact_url = $baseurl . 'ads/contact/' . $title_url . '/' . $ads_id;
							$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id;
							$full_report_url = $baseurl . 'ads/reportspam/' . $title_url . '/' . $ads_id;
							$deactivate_url = $baseurl . 'myads/deactivatead/'.$result[$i]['ads_id'].'/2/'.$days;
						//	$activate_url = $baseurl . 'myads/activatead/'.$result[$i]['ads_id'].'/2';
							$activate_url = $baseurl . 'myads/activatead/'.$result[$i]['ads_id'].'/2/'.$days;
							$extend_ad_url = $baseurl . 'myads/extendad/'. $ads_id .'/2';
							$delete_ad_url = $baseurl . 'myads/deletead/'. $ads_id .'/'.$user_id;
							
							
							
							
							
							
							
							$rentTypeList = getRentTypeList();
							
							// title 	description 	name 	full_url real_path
							
							if(!empty($provider['image'][0]['name']) && !empty($provider['image'][0]['real_path'])){
								$imgurl = $base_url . $provider['image'][0]['real_path'] .'img2_'. $provider['image'][0]['name'];
								
								
							}
							else{
							
								$imgurl = $staticurl . 'images/accThumb.jpg';
							} ?>
<li>
	<div class="mnaimghol"><a href="<?=$full_url?>"><img src="<?=$imgurl?>" border="0" /></a></div>
    <div class="mnacontent">
    	<p class="mnahead">
        	<?=$title?> &nbsp;&nbsp;&nbsp;<span>
            <?php if($provider['status']=='1') {?><img src="<?=$staticurl?>images/activegrp.gif" width="50" height="12" /><?php 
			}else{?>
            <img src="<?=$staticurl?>images/inactivegrp.gif" width="50" height="12" />
			<?php } ?>
        	</span>
        </p>
        <p class="mnaactions">
		<a href=<?=$delete_ad_url?> class="mnabutton mnadeac flRight roundBor2 ">Delete Ad</a>
       <?php if($days<=7) {?> <a href=<?=$extend_ad_url?> class="mnabutton mnadeac flRight roundBor2 greybox">Extend Ad</a><?php }?>
        	<?php if($days>=0)  { if($provider['status']=='1') {?><a href="<?=$deactivate_url?>" class="mnabutton mnadeac flRight roundBor2 greybox">De-Activate</a>
           <?php } else{?> <a href="<?=$activate_url?>" class="mnabutton mnaact flRight roundBor2 greybox">Activate</a>
          <?php } }?>
			<a href="<?php echo $full_url;?>" class="mnabutton mnaprew flRight roundBor2" >Preview</a>
            
			<a href="<?=$edit_url?>" class="mnabutton mnaedit flRight roundBor2">Edit</a>
            <br class="clearer" />
            <span class="mnadates">Created -<?=date('d M Y',strtotime($provider['addedtime']))?>&nbsp;&nbsp;|
           
			 &nbsp;&nbsp;Expires - <?echo date('d M Y',strtotime($provider['expiry_date']))?></span>
        </p>
        <p class="mnabar roundBor2">
        <span class="flLeft"><strong>Total Views: <?=$provider['views']?>&nbsp;&nbsp;|
        &nbsp;&nbsp;Contact Requests: <?=$provider['contact']?></strong></span>
        <span class="mnaupd">Last Updated: <?=showupdateddate($provider['updated_date'])?></span>
        <br class="clearer" />
        </p>
    </div>
    <br class="clearer" />
</li>							
					<?						
						}					
					}					
					?>
				</ul>		
			<?php echo $this->pagination->create_links();?>			 
			</div>
		</div>
		<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
        <br class="clearer" />
	</div>
    <br class="clearer" />
</div>

