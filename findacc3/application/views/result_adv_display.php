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
				<p>Parramatta<br />
                NSW 2150</p>
				
				<ul>
                  <li>
                      <a class="accHead accHeadList" href="#">Surrounding Areas</a>  
                      <span>Included</span>                   
                      <div class="accContent">Content for this tab</div>
                  </li>
                  <li>
                      <a class="accHead accHeadList" href="#">Community</a>
                      <span>Any</span>  
                      <div class="accContent">Content for this tab</div>
                  </li>
                  <li>
                      <a class="accHead accHeadList" href="#">Price Range</a>
                      <span>Any</span>  
                      <div class="accContent">Content for this tab</div>
                  </li>
                  <li>
                      <a class="accHead accHeadList" href="#">Property Type</a>
                      <span>Any</span>  
                      <div class="accContent">Content for this tab</div>
                  </li>
                  <li>
                      <a class="accHead accHeadList" href="#">Bedrooms</a>
                      <span>Any</span>  
                      <div class="accContent">Content for this tab</div>
                  </li>
                  <li>
                      <a class="accHead accHeadList" href="#">Bathrooms</a>
                      <span>Any</span>  
                      <div class="accContent">Content for this tab</div>
                  </li>
                  <li>
                      <a class="accHead accHeadList" href="#">Parking</a>
                      <span>Any</span>  
                      <div class="accContent">Content for this tab</div>
                  </li>
				</ul>
			</div>
			<div id="searchHeading">
<!--					<?php
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
						$strname = $location;
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

	-->			<h3><?=$total_rows?> results found</h3>					

<!--		<a href="<?=$baseurl?>user/savesearch/<?=$_SERVER['QUERY_STRING']?>/<?=$location?>">Save this search</a>-->
				<select id="listsorter" class="selectField if206" name="listsorter">
                	<option>Sort List</option>
                	<option>Price - High to Low</option>
                    <option>Price - Low to High</option>
                </select>
			</div>
			
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
									$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id .'/'.$user_id;
								}
							$full_report_url = $baseurl . 'ads/reportspam/' . $title_url . '/' . $ads_id;
							
							//$image_url = $provider['ads_id'];
							$rentTypeList = getRentTypeList();
							
							// title 	description 	name 	full_url real_path
							if(!empty($provider['image'][0]['name']) && !empty($provider['image'][0]['real_path']))
							{
								$imgurl = $base_url . $provider['image'][0]['real_path'] .'img2_'.$provider['image'][0]['name'];
							
							}
							else
							{
								$imgurl = $staticurl . 'images/accThumb.jpg';
							}	
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
			<?php echo $this->pagination->create_links();?>	
				
			</div>
			
    	</div>
		
	 	<div id="ads" align="left">
		<div class="recentsbox">
        <h2 class="boxeshead">RECENT SEARCHES</h2>
          <ul>  
		<?php
		if(!empty($_COOKIE['cookie_search'])){
		
		$cookie_search_count=count($_COOKIE['cookie_search']);
		if($cookie_search_count>4)
		{$cookie_search_count=3;}
		else
		{$cookie_search_count=$cookie_search_count-1;}
		for($z=$cookie_search_count;$z>=0;$z--){
		?>
		<li><a href="<?php echo $_COOKIE['cookie_search'][$z]['1'];?>"><?php echo $_COOKIE['cookie_search'][$z]['0'];?></a></li>
		<?php }}else {?>
		<li>No recent search</li>
		<?php }?>
		</ul>
		 
                <p class="clearer"></p>
        </div>  
		<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
        <br class="clearer">
	</div>
    <br class="clearer">
</div>
