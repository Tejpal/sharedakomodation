<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');


//print_r($contact; exit;
//echo $views; exit;
/*echo '<pre>';
print_r($result); 
echo '</pre>';exit;*/
//echo $result[0]['status']; exit;

?>

<div id="bannerShade">
</div>

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
                <br class="clearer" />
                <div id="myAds">
                	<div id="myAdsHeader">
                    	<div class="adDetailsColumn floatLeft height30">Ad Details</div>
                        <div class="adStatusColumn floatLeft height30">Ad Status</div>
                        <div class="adActionsColumn floatLeft height30">Actions</div>
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
                    <!--
                    <ul id="myAdsList">
                    	<li>
                        	<div class="adDetailsColumn floatLeft height52">
                            	<img src="<?=$staticurl?>images/accThumb.jpg"/>
                                <div class="listText2">
                                    <h3>This is the catchy heading of your Ad 1</h3><br/>
                                    <p>
                                        5 mins walk from the train station<br/>
                                        5 mins walk from filling station 
                                    </p>
                                    <a href="#">Edit Ad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Preview Ad</a>
                                 </div>
                            </div>
                            <div class="adStatusColumn floatLeft height52">
                            	<p>Status  -  <span class="greenText">ACTIVE</span><br/>
                                Created - <span class="boldText">26 Jan 2011</span><br/>
                                Expires - <span class="boldText">26 Feb 2011</span><br/>
                                Ad Visits - <span class="boldText">89</span><br/>
                                Contact Requests - <span class="boldText">23</span><br/>
                                </p>
                            </div>
                            <div class="adActionsColumn floatLeft height52">
                               	<a href="#">Extent Ad</a><br/>
                                <a href="#">De-Activate Ad</a><br/>
                                <a href="#">Activate Ad</a>
                                <img src="<?=$staticurl?>images/extendAdIcon.gif" id="extendAdIcon"/>
                                <img src="<?=$staticurl?>images/deActivateIcon.gif" id="deActivateIcon"/>
                                <img src="<?=$staticurl?>images/activateIcon.gif" id="activateIcon"/>
                            </div>
                    	</li>
                        
						<li>
                        	<div class="adDetailsColumn floatLeft height52">
                            	<img src="<?=$staticurl?>images/accThumb.jpg"/>
                                <div class="listText2">
                                    <h3>This is the catchy heading of your Ad 1</h3><br/>
                                    <p>
                                        5 mins walk from the train station<br/>
                                        5 mins walk from filling station 
                                    </p>
                                    <a href="#">Edit Ad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Preview Ad</a>
                                 </div>
                            </div>
                            <div class="adStatusColumn floatLeft height52">
                            	<p>Status  -  <span class="greenText">ACTIVE</span><br/>
                                Created - <span class="boldText">26 Jan 2011</span><br/>
                                Expires - <span class="boldText">26 Feb 2011</span><br/>
                                Ad Visits - <span class="boldText">89</span><br/>
                                Contact Requests - <span class="boldText">23</span><br/>
                                </p>
                            </div>
                            <div class="adActionsColumn floatLeft height52">
                               	<a href="#">Extent Ad</a><br/>
                                <a href="#">De-Activate Ad</a><br/>
                                <a href="#">Activate Ad</a>
                                <img src="<?=$staticurl?>images/extendAdIcon.gif" id="extendAdIcon"/>
                                <img src="<?=$staticurl?>images/deActivateIcon.gif" id="deActivateIcon"/>
                                <img src="<?=$staticurl?>images/activateIcon.gif" id="activateIcon"/>
                            </div>
                    	</li>
						
					</ul>
					-->
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
							$ads_id = $provider['ads_id'];
							$title = $provider['title'];
							$title_s = addslashes($title);							
							$title_url = encodeurl($title);
							$full_url = $baseurl . 'ads/detail/' . $title_url . '/' . $ads_id;
							$edit_url = $baseurl . 'ads/update/' . $title_url . '/' . $ads_id;
							$full_contact_url = $baseurl . 'ads/contact/' . $title_url . '/' . $ads_id;
							$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id;
							$full_report_url = $baseurl . 'ads/reportspam/' . $title_url . '/' . $ads_id;
							 
							//$image_url = $provider['ads_id'];
							$rentTypeList = getRentTypeList();
							
							// title 	description 	name 	full_url real_path
							
							if(!empty($provider['image'][0]['name']) && !empty($provider['image'][0]['real_path'])){
								$imgurl = $base_url . $provider['image'][0]['real_path'] . $provider['image'][0]['name'];
								//$imgurl = $base_url . $provider['real_path'] . $provider['name'];
							}
							else{
							
								$imgurl = $staticurl . 'images/accThumb.jpg';
							}?>
							<li>
								<div class="adDetailsColumn floatLeft height52"> <a href="<?=$edit_url?>"><img src="<?=$imgurl?>" width="115" height="115" border="0" /></a>
									<div class="listText2">
								    <h3><?=$title?></h3><br/>
										<a href="<?=$edit_url?>">Edit Ad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $full_url;?>">Preview Ad</a>
										<p>
											<?=$provider['bestfeature1']?><br/>
											<?=$provider['bestfeature2']?> 
										</p>										
									 </div>
								</div>
								<div class="adStatusColumn floatLeft height52">
								
									<p>Status  -  <span class="greenText"><?php if($provider['status']=='1') {?>ACTIVE<?php } else {?>NOT ACTIVE<?php } ?></span><br/>
									Created - <span class="boldText"><?//=$provider['addedtime']?><?=date('d M Y',strtotime($provider['addedtime']))?></span><br/>
									Expires - <span class="boldText"><?//=$provider['updated_date']?><?=date('d M Y',strtotime($provider['addedtime'].",+30 days"))?></span><br/>
									Ad Visits - <span class="boldText"><?=$provider['views']?></span><br/>
									Contact Requests - <span class="boldText"><?=$provider['contact']?></span><br/>
									</p>
								</div>
								<div class="adActionsColumn floatLeft height52">
									<a href="/findacc3/index.php/myads/extendad/<?php echo $result[$i]['ads_id'];?>/2">Extent Ad</a><br/>
									<a href="/findacc3/index.php/myads/deactivatead/<?php echo $result[$i]['ads_id'];?>/2">De-Activate Ad</a><br/>
									<a href="/findacc3/index.php/myads/activatead/<?php echo $result[$i]['ads_id'];?>/2">Activate Ad</a>
									<img src="<?=$staticurl?>images/extendAdIcon.gif" id="extendAdIcon"/>
									<img src="<?=$staticurl?>images/deActivateIcon.gif" id="deActivateIcon"/>
									<img src="<?=$staticurl?>images/activateIcon.gif" id="activateIcon"/>
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
		</div>
		<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
	</div>
</div>

