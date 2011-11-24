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
						$n2 = ceil($n/2);
						//$providers = $adslist['providers'];
						for($i=0;($i<$n2);$i++)
						{
							$provider = $result[$i];
							$ads_id = $provider['ads_id'];
							$title = $provider['title'];
							$title_s = addslashes($title);							
							$title_url = encodeurl($title);
							$full_url = $baseurl . 'ads/detail/' . $title_url . '/' . $ads_id;
							$full_contact_url = $baseurl . 'ads/contact/' . $title_url . '/' . $ads_id;
							$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id;
							$full_report_url = $baseurl . 'ads/reportspam/' . $title_url . '/' . $ads_id;
							
							//$image_url = $provider['ads_id'];
							$rentTypeList = getRentTypeList();
							
							// title 	description 	name 	full_url real_path
							if(!empty($provider['name']) && !empty($provider['real_path']))
								$imgurl = $base_url . $provider['real_path'] . $provider['name'];
							else
								$imgurl = $staticurl . 'images/accThumb.jpg';
							?>
							<li>
								<div class="adDetailsColumn floatLeft height52">
									<img src="<?=$imgurl?>" width="115" height="115" />
									<div class="listText2">
										<h3><?=$title?></h3><br/>
										<p>
											<?=$provider['bestfeature1']?><br/>
											<?=$provider['bestfeature2']?> 
										</p>
										<a href="#">Edit Ad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Preview Ad</a>
									 </div>
								</div>
								<div class="adStatusColumn floatLeft height52">
									<p>Status  -  <span class="greenText">ACTIVE</span><br/>
									Created - <span class="boldText"><?//=$provider['addedtime']?><?=date('d M Y',strtotime($provider['addedtime']))?></span><br/>
									Expires - <span class="boldText"><?//=$provider['updated_date']?><?=date('d M Y',strtotime($provider['updated_date']))?></span><br/>
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
							<?						
						}					
					}					
					?>
				</ul>
			
				<!-- pagination start -->
				<div class="pagination">
					<?php				
					if(!empty($resultCount) && $resultCount>0)
					{
					?>
					<div class="pages">Pages : </div>
					<div id="tnt_pagination">
						<?
							// $resultCount;
							// $per_page
							// $current_page
						if(!empty($resultCount) && $resultCount>0)	
						{
							$noOfPages = ceil($resultCount/$per_page);
							
							// previous page
							if($current_page==1)
							{
								?><span class="disabled_tnt_pagination">Prev</span><?
							}
							else
							{
								if(!empty($searchFlag) && $searchFlag==1)
								{
									?><a href="<?=$baseurl . $pageurl . '&page=' . ($current_page-1) . '&total=' . $resultCount?>">Prev</a><?
								}
								else
								{
									?><a href="<?=$baseurl . $pageurl . ($current_page-1) . '/' . $resultCount?>">Prev</a><?
								}
							}
							
							// pages 					
							for($p=1;$p<($noOfPages+1);$p++)
							{	
								if($current_page==$p)
								{
									?><span class="active_tnt_link"><?=$p?></span><?
								}
								else
								{							
									if(!empty($searchFlag) && $searchFlag==1)
									{
										?><a href="<?=$baseurl . $pageurl . '&page=' . ($p) . '&total=' . $resultCount?>"><?=$p?></a><?									
									}
									else
									{
										?><a href="<?=$baseurl . $pageurl . ($p) . '/' . $resultCount?>"><?=$p?></a><?
									}
								}
							}
							
							// next page
							if($current_page==$noOfPages)
							{
								?>
								<span class="disabled_tnt_pagination">Next</span>							
								<?
							}
							else
							{	
								if(!empty($searchFlag) && $searchFlag==1)
								{
									?><a href="<?=$baseurl . $pageurl . '&page=' . ($current_page+1) . '&total=' . $resultCount?>">Next</a><?
								}
								else
								{						
									?><a href="<?=$baseurl . $pageurl . ($current_page+1) . '/' . $resultCount?>">Next</a><?
								}
							}							
							
						}
						?>				
						<!--
						<span class="disabled_tnt_pagination">Prev</span>
						<a href="#10">Prev</a>
						<a href="#1">1</a>
						<a href="#2">2</a>
						<a href="#3">3</a>
						<span class="active_tnt_link">4</span>
						<a href="#5">5</a>
						<a href="#6">6</a>
						<a href="#7">7</a>
						<a href="#8">8</a>
						<a href="#9">9</a>
						<a href="#10">10</a>
						<a href="#forwaed">Next</a>
						-->
					</div>
					<?
					}
					else
					{
						echo "No ads available";
					}
									
					?>				
				</div>
				<!-- pagination end -->						
					
                    
                </div>				
			</div>
		</div>
		<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
        <br class="clearer">
	</div>
    <br class="clearer">
</div>

