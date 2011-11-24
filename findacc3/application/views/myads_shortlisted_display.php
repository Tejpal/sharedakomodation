<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');


?>

<div id="contentContainer">
  	<div id="contentHolder">
		<div id="contentLeft">
				<div id="shortlistedAdsPage">
					<h2>SHORTLISTED ADS</h2>
					<div id="accMenu">
						<ul>						
							<li <?=(($page_about==1)?'class="selected"':'')?> ><a href="<?=site_url("/myads/manage/")?>">Manage Ads</a></li>
							<li <?=(($page_about==2)?'class="selected"':'')?> ><a href="<?=site_url("/myads/shortlisted/")?>">Shortlisted Ads</a></li>
							<li <?=(($page_about==3)?'class="selected"':'')?> ><a href="<?=site_url("/myads/matching/")?>">Matching Ads</a></li>						
						</ul>
					</div>
					<p class="clearer"></p>
                </div>
				<div id="refineSearchSl">
					<h2>REFINE ADS LIST</h2>
					<ul>
					  <li><a href="#">Community</a><br/>Any</li>
						<li><a href="#">Price Range</a><br/>Any</li>
						<li><a href="#">Property Type</a><br/>Any</li>
						<li><a href="#">Bedrooms</a><br/>Any</li>
						<li><a href="#">Bathrooms</a><br/>Any</li>
						<li><a href="#">Parking</a><br/>Any</li>
					</ul>
				</div>
				<div id="searchHeadingSl">
					<label>You have <?=count($result)?> Shortlisted Ads</label>
					<!--<input type="text" id="sortBy" />-->
				</div>
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
				<div id="searchResults">
					<ul>
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
							$ads_id = $provider['ads_id'];
							$user_id = $provider['user_id'];
							$title = $provider['title'];
							$title_s = addslashes($title);							
							$title_url = encodeurl($title);
							$full_url = $baseurl . 'ads/detail/' . $title_url . '/' . $ads_id;
							$full_contact_url = $baseurl . 'ads/contact/' . $title_url . '/' . $ads_id;
							$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id.'/'.$user_id;
							$full_report_url = $baseurl . 'ads/reportspam/' . $title_url . '/' . $ads_id;
							
							//$image_url = $provider['ads_id'];
							$rentTypeList = getRentTypeList();
							
							// title 	description 	name 	full_url real_path
							if(!empty($provider['image'][0]['name']) && !empty($provider['image'][0]['real_path']))
								$imgurl = $base_url . $provider['image'][0]['real_path'] . $provider['image'][0]['name'];
							else 
								$imgurl = $staticurl . 'images/accThumb.jpg';
							?>
							<li>
								<h4>
									$<?=$provider['rent'].' '.$rentTypeList[$provider['rent_type']]?> | <?=$provider['city']?>
								</h4>
								<div class="homeImage">
									<img src="<?=$imgurl?>" width="115" height="115"/><br />
								</div>
								<div class="listText2">
									<p class="homeCatchy"><?=$title?></p>							
									<p><strong><?=$provider['bestfeature1']?><br/>
											<?=$provider['bestfeature2']?></strong>
									</p>
									<p class="font11">
										<?=$provider['description']?>
									</p>
								</div>
								
								<div id="listingFooter">
									<div class="availUpdTxt">Available - <?=date('d M Y',strtotime($provider['availability']))?>
									&nbsp;&nbsp;|&nbsp;&nbsp;Updated - <?=showupdateddate($provider['updated_date'])?></div>
									<div id="listingLinks">										  
										  <a href="<?=$full_contact_url?>" alt="Contact Now - <?=$title_s?>" title="Contact Now - <?=$title_s?>" widt='650'  heigh='535' class="greybox">Contact Now</a>&nbsp;&nbsp;|&nbsp;&nbsp;
										 <!-- <a href="<?=$full_shortlist_url?>" alt="Shortlist Ad - <?=$title_s?>" title="Shortlist Ad - <?=$title_s?>" >Shortlist Ad</a>&nbsp;&nbsp;|&nbsp;&nbsp;-->									 
										  <a href="<?=$full_url?>" alt="View Full Ad - <?=$title_s?>" title="View Full Ad - <?=$title_s?>" >View Full Ad</a>&nbsp;&nbsp;|&nbsp;&nbsp;	
										  <a href="<?=$full_report_url?>" alt="Report Spam - <?=$title_s?>" title="Report Spam - <?=$title_s?>" >Report Spam</a>										  
									</div>
									<p class="clearer"></p>
								</div>
							</li>							
							<?						
						}					
					}					
					?>			

					</ul>
				</div>
			<?php echo $this->pagination->create_links();?>
								
			
		</div>
    	
	 	<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
        <br class="clearer">
   </div>
   <br class="clearer">
</div>
