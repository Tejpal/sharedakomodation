<?php
$baseurl = site_url() . '/';
$base_url = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
//print_R($community);

//echo '<pre>'; print_r($result);echo '</pre>';
//print_r($city);
//print_r($parking_type);
/* if(!empty($result) && count($result)>0)
{
$count=count($result);
$r_ads_id=array();
for($i=0;$i<$count;$i++)
{
$r_ads_id[$i]="'".$result[$i]['ads_id']."'";
}
} */

if(!empty($all_ads_id) && count($all_ads_id)>0)
{
$count=count($all_ads_id);
$r_ads_id=array();
for($i=0;$i<$count;$i++)
{
$r_ads_id[$i]="'".$all_ads_id[$i]."'";
}
}

if(!empty($comm) && count($comm)>0)
{
$count=count($comm);
$comm_array=array();
for($i=0;$i<$count;$i++)
{
$comm_array[$i]=$comm[$i];
}
}
else
{$comm_array=array(0);
}
if(!isset($community_array) || empty($community_array))
$community_array=array();


?>

<!--<script type="text/javascript" src="<?//=$staticurl?>js/filter_com/jquery.js"></script>-->
<script type="text/javascript" src="<?=$staticurl?>js/filter_com/quicksearch-modified.js"></script>
	
	


<div id="contentContainer">
  	<div id="contentHolder">
		<div id="contentLeft">
			<div id="refineSearch" class="roundBor3 ">
				<h2>REFINE SEARCH</h2>
			
		<?php	$pieces = explode(",", $location);?>
		<p>	<?=$pieces['0']?><br />
		<?php if(count($pieces)==2) {
			echo $pieces['1'];}?></p>
				<ul>
                  <li>
                      <a class="accHead accHeadList" href="#">Surrounding Areas</a>  
                      <span>
					  <? if(!empty($city)){?>
					  Included <?} else{?> Not included <?}?></span>                   
                      <div class="accContent refineinbox roundBor3">
					  <form name="sorrounding_form" action="<?=site_url('/ads/refine_sorr/')?>" method="get">
					  <?
					  if(!empty($city))
					  echo displayCheckboxs(array_unique($city), $name='options[]', $selectedlist=array_unique($city), $classes='',$selval='1');?>
					  <input type="hidden" value="<? if (isset($r_ads_id)){ echo implode(',', $r_ads_id); }?>" name="ads_id">
					  <input type="hidden" value="<?=$location?>" name="location">
					  <? if (!empty($city)){?>
					  <input type="submit" name="update" value="update">
					  <? } else {echo 'No sorrundings';}?>
					  </form>
					  </div>
                      
                  </li>
				  <li>
                      <a class="accHead accHeadList" href="#">Community</a>  
                      <span><? if(isset($comm)) {echo 'Communities selected : '.count($comm);}elseif(!empty($community_array)){echo 'Communities selected : '.count($community_array);}else{echo 'Any';}?> </span>                   
                      <div class="accContent refineinbox roundBor3"  style='height:200px; overflow-y:scroll;'>
			
			<form name="community_form" action="<?=site_url('/ads/refine_comm/')?>" method="get"  >
	<table id="comtable" width="50%" cellpadding="0" cellspacing="0" >
		
		<tbody>
		<?php 
		 $comm1=getCommunityList();
foreach($comm1 as $c)
		{
		
		$a=$c['id'];
		if (in_array($a,$community_array))
		{
		echo		"<tr><td style='border-top: 1px solid #FFFFFF;
    padding: 8px;'><input type='checkbox' checked='checked' name='options[]' value=$a></td>
				<td style='border-top: 1px solid #FFFFFF;
    padding: 8px;'>".$c['community']."</td>
				
				
			</tr>";
		}
		elseif(in_array($a,$comm_array))
		{
		echo		"<tr><td style='border-top: 1px solid #FFFFFF;
    padding: 8px;'><input type='checkbox' checked='checked' name='options[]' value=$a></td>
				<td style='border-top: 1px solid #FFFFFF;
    padding: 8px;'>".$c['community']."</td>
				
				
			</tr>";
		}
		else
		{
		echo		"<tr><td style='border-top: 1px solid #FFFFFF;
    padding: 8px;'><input type='checkbox' name='options[]' value=$a></td>
				<td style='border-top: 1px solid #FFFFFF;
    padding: 8px;'>".$c['community']."</td>
				
				
			</tr>";
		}
		}
	
		
		?>	
			
			
		</tbody>
	</table>
	<input type="hidden" value="<? if (isset($r_ads_id)){ echo implode(',', $r_ads_id); }?>" name="ads_id">
	<input type="hidden" value="<?=$location?>" name="location">
	<input type="submit" name="update" value="update">
</form>
					  </div>
                  </li>
                  
                  <li>
				  <?
				  $getPriceRange=getPriceRange();
				  $getRentTypeList=getRentTypeList();
				  
				  ?>
                      <a class="accHead accHeadList" href="#">Price Range</a>
                      <span><?if(isset($min_type) && isset($max_type) && isset($rent_type)){echo '$'.$getPriceRange[$min_type[0]].' - $'.$getPriceRange[$max_type[0]].' '.$getRentTypeList[$rent_type[0]];}else{echo 'Any';}?></span>  
					  <div class="accContent refineinbox roundBor3">
					  <form name="price_range_form" action="<?=site_url('/ads/refine_price/')?>" method="get">
					  <?php 
					  if(!isset($min_type))
					  $min_type=array('0');
					  if(!isset($max_type))
					  $max_type=array('0');
					  if(!isset($rent_type))
					  $rent_type=array('0');
					  
					  echo 'Min'.displayDropdown(getPriceRange(), $name='min_pricerange', $selected=$min_type, $classes='selectFieldnw sf140');
					  echo 'Max'.displayDropdown(getPriceRange(), $name='max_pricerange', $selected=$max_type, $classes='selectFieldnw sf140');
					  echo 'Type'.displayDropdown(getRentTypeList(), $name='rentType', $selected=$rent_type, $classes='selectFieldnw sf140');
					  ?>
					  <input type="hidden" value="<? if (isset($r_ads_id)){ echo implode(',', $r_ads_id); }?>" name="ads_id">
					  <input type="hidden" value="<?=$location?>" name="location">
					  <input type="submit" name="price_range_btn" value="update">
					  </form>
					  </div>
                  </li>
                  <li>
				  <?
				  $getPropertyType = getPropertyType();
				  ?>
                      <a class="accHead accHeadList" href="#">Property Type</a>
                      <span><?if(isset($p_type)){if(count($p_type)==1){echo $getPropertyType[$p_type['0']];}elseif(count($p_type)>1){echo count($p_type).' property types selected ';} }else{ echo 'Any';}?></span>
                      <div class="accContent refineinbox roundBor3">
                      <form name="property_type_form" action="<?=site_url('/ads/refine_property_type/')?>" method="get">
                       <?php  
					   if(!isset($p_type))
					   $p_type=array('0');
						echo displayCheckboxs(getPropertyType(), $name='options[]', $selectedlist=$p_type, $classes='');
						?>
						<input type="hidden" value="<?if (isset($r_ads_id)){ echo implode(',', $r_ads_id); }?>" name="ads_id">
						<input type="hidden" value="<?=$location?>" name="location">
						<input type="submit" name="property_type_btn" value="update">
						
                      </form>
                      </div>
                  </li>
                  <li>
                      <a class="accHead accHeadList" href="#">Bedrooms</a>
                     <span><?if(isset($bedroom_type)){if(count($bedroom_type)==1){if($bedroom_type[0]==0){echo 'Any';}else{echo $bedroom_type[0].' bedrooms';} }}else{echo 'Any';}?></span>
                      <div class="accContent refineinbox roundBor3">
					  <form name="bedroom_form" action="<?=site_url('/ads/refine_bedrooms/')?>" method="get">
						<?php 
						if(!isset($bedroom_type))
						$bedroom_type=array('0');
						echo displayRadio(getNoList(), $name='options[]', $selectedlist=$bedroom_type, $classes='');
						?>
						<input type="hidden" value="<?if (isset($r_ads_id)){ echo implode(',', $r_ads_id); }?>" name="ads_id">
						<input type="hidden" value="<?=$location?>" name="location">
						<input type="submit" name="bedroom_btn" value="update">
						</form>
					  </div>
                  </li>
                  
                  <li>
				  <?
				  $parkingtype = getParkingType();
				  ?>
                      <a class="accHead accHeadList" href="#">Parking</a>
                      <span><?if(isset($parking_type)){if(count($parking_type)==1){echo $parkingtype[$parking_type['0']];}elseif(count($parking_type)>1){echo count($parking_type).' parking types selected ';} }else{echo 'Any';}?></span>
                      <div class="accContent refineinbox roundBor3">
					  <form name="parking_form" action="<?=site_url('/ads/refine_parking/')?>" method="get">
						<?php  
						if(!isset($parking_type))
						$parking_type=array('0');	
						
						echo displayCheckboxs(getParkingType(), $name='options[]', $selectedlist=$parking_type, $classes='');
						?>
						<input type="hidden" value="<?if (isset($r_ads_id)){ echo implode(',', $r_ads_id); }?>" name="ads_id">
						<input type="hidden" value="<?=$location?>" name="location">
						<input type="submit" name="parking_btn" value="update">
						</form>
					  </div>
                  </li>
				</ul>
			</div>
			<div id="searchHeading">
				<?if (isset($r_ads_id)){$sort_ads_id=implode(',', $r_ads_id); } else {$sort_ads_id='';}?>
				<span id="res_found"><?=$total_rows?> results found</span>				

				<a href="<?=$baseurl?>user/savesearch/<?=$_SERVER['QUERY_STRING']?>/<?=$location?>">Save this search</a>
				<select id="listsorter" class="selectField if206" name="listsorter" onChange="document.location.href=this[selectedIndex].value">
                <?if(!isset($sort)){?><option>Sort List</option><?}?>
                	<option value="<?=site_url('/ads/sort_results/1?location='.$location.'&ads_id='.$sort_ads_id)?>" <?if(isset($sort)){if($sort==1) {?>selected="selected"<? }}?>>Price - High to Low</option>
                    <option value="<?=site_url('/ads/sort_results/2?location='.$location.'&ads_id='.$sort_ads_id)?>" <?if(isset($sort)){if($sort==2) {?>selected="selected"<? }}?>>Price - Low to High</option>
                </select>
			</div>
				
			<div id="searchResults">
			<?php 
		$success = $this->session->flashdata('success'); 
		if(!empty($success))
		 {
		echo "$success";
		 }?>
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
							
							if($this->session->userdata('user_id'))
								{
							
									$uid=$this->session->userdata('user_id');
									$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id .'/'.$uid ;
								}
							
								if(!$this->session->userdata('user_id'))
								{
									$full_shortlist_url = $baseurl . 'ads/shortlist/' . $title_url . '/' . $ads_id .'/'.$user_id;
								}
							$full_report_url = $baseurl . 'ads/reportspam/' . $title_url . '/' . $ads_id;
							
							
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
										
									</p>							
									<p><strong><?=character_limiter($provider['bestfeature1'],100)?><br/>
										<?=character_limiter($provider['bestfeature2'],100)?></strong>
									</p>
									<p class="font11">
										<?=character_limiter($provider['description'],435)?>
									</p>
								</div>							
								<div id="listingFooter">
									<div class="availUpdTxt">										
										Available - <?=date('d M Y',strtotime($provider['availability']))?>
										&nbsp;&nbsp;|&nbsp;&nbsp;
										Updated - <?=showupdateddate($provider['updated_date'])?>
									</div>
									<div id="listingLinks">
									  <a href="<?=$full_contact_url?>" alt="Contact Now - <?=$title_s?>"  class='greybox' widt='650'  heigh='535' title="<?php if($provider['sharing_type']==1) {?>Contact Provider<?php } elseif($provider['sharing_type']==0){?> Contact Finder<?php }?>" >Contact Now</a>&nbsp;&nbsp;|&nbsp;&nbsp;
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
			
					<?php
					if(!empty($result) && count($result)>0)
					echo $this->pagination->create_links();
					?>	
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
<script type="text/javascript">
$(document).ready(function() {
	$("#comtable tbody tr").quicksearch({
		//reset: true,
		resetClass: "resetButton",
		//resetLabel: "Reset Table",
		position: 'before',
		attached: 'table#comtable',
		stripeRowClass: ['odd', 'even']
	});
});
</script>