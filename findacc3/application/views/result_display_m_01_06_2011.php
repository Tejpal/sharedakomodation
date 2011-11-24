<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
?>
<div id="contentContainer">
  	<div id="contentHolder">
		<div id="contentLeft">
			<div id="refineSearch">
				<h2>REFINE SEARCH</h2>
				<h3>Parramatta<br/>Harris Park<br/>2150</h3>
				<ul>
					<li><a href="#">Surrounding Areas</a><br/>Included</li>
					<li><a href="#">Community</a><br/>Any</li>
					<li><a href="#">Price Range</a><br/>Any</li>
					<li><a href="#">Property Type</a><br/>Any</li>
					<li><a href="#">Bedrooms</a><br/>Any</li>
					<li><a href="#">Bathrooms</a><br/>Any</li>
					<li><a href="#">Parking</a><br/>Any</li>
				</ul>
			</div>
			<div id="searchHeading">
					<?php
					// search  
					if(!empty($searchFlag) && $searchFlag==1)
					{
						$pageurl = 'ads/search/result/?';
						$requestLists = array_merge($searchFields,$searchCommonFields);
						$requestSTR = '';
						foreach($requestLists as $requestList)
						{
							if(!empty($$requestList)){
								if(empty($requestSTR))
									$requestSTR = "$requestList=". $$requestList;
								else
									$requestSTR .= "&$requestList=". $$requestList;
							}
						}
						$pageurl .= $requestSTR;
						
						//echo $pageurl;						
						if(!empty($resultCount) && ($resultCount)>0)
						{
							?>							
							<label><?=count($resultCount)?> Sharing Ads Found</label>							
							<?
						}						
					}
					else
					{
						$strname = $city;
						$pageurl = 'city';
						if(!empty($state))
						{
							$strname = $state;
							$pageurl = 'state';
						}
						else if(!empty($country))
						{
							$strname = $country;
							$pageurl = 'country';	
						}
						$pageurl = 'ads/' . $pageurl . '/' . $strname . '/';
						if(!empty($result) && count($result)>0)
						{
							?>
							<label> <?=count($result)?> Sharing Ads Found In "<?=($strname)?>"</label>							
							<?
						}
					}
					?>				
				<a href="">Save Search</a>
				<input type="text" id="saveSearch" name="saveSearch" />	
			</div>
			
			<div id="searchResults">
				<ul>
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
								<h4>$<?=$provider['rent']?>/<?=$rentTypeList[$provider['rent_type']]?> | <?=$provider['city']?></h4>
								<div class="homeImage">
									<img src="<?=$imgurl?>" width="115" height="115"/><br />
								</div>
								<div class="listText3">
									<p class="homeCatchy">
										<?=$title?>
										<!--
										<a href="<?=$full_url?>" alt="view detail - <?=$title?>" title="view detail - <?=$title?>" ><?=$title?></a>	
										-->
									</p>							
									<p><strong><?=$provider['bestfeature1']?><br/>
										<?=$provider['bestfeature2']?></strong>
									</p>
									<p class="font11">
										<?=$provider['description']?> 
									</p>
								</div>							
								<div id="listingFooter">
									<div class="availUpdTxt">										
										Available - <?=date('d M Y',strtotime($provider['availability']))?>
										&nbsp;&nbsp;|&nbsp;&nbsp;
										Updated - <?=showupdateddate($provider['updated_date'])?>
									</div>
									<div id="listingLinks">
									  <a href="<?=$full_contact_url?>" alt="Contact Now - <?=$title_s?>" title="Contact Now - <?=$title_s?>" >Contact Now</a>&nbsp;&nbsp;|&nbsp;&nbsp;
									  <a href="<?=$full_shortlist_url?>" alt="Shortlist Ad - <?=$title_s?>" title="Shortlist Ad - <?=$title_s?>" >Shortlist Ad</a>&nbsp;&nbsp;|&nbsp;&nbsp;									 
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
						echo "No Ads found for '$strname'";
					}
									
					?>				
				</div>
				<!-- pagination end -->				
			</div>
			
    	</div>
	 	<div id="ads" align="left">
        <div id="refineSearch">
				<h2>REFINE SEARCH</h2>
				<ul>
					<li><a href="#">Surrounding Areas</a></li>
				</ul>
			</div>
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
        <br class="clearer">
	</div>
    <br class="clearer">
</div>
