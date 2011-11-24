<?php
$baseurl = site_url() . '/';
$staticurl = $this->config->item('static_url');
//print_r($result2);exit;
?>
<?php 
			
		$success = $this->session->flashdata('success'); 
		if(!empty($success))
		 {
		echo "<p id='success_home_Page' class='success_notify'>$success</p>";
		 }
		$alert = $this->session->flashdata('alert'); 
		if(!empty($alert))
		{
			echo "<p id='alert_home_Page' class='alert_notify'>$alert</p>";
		}
		?>
<div id="contentContainer">
  <div id="contentHolder">
    <div id="contentLeft">
		<div id="quickSearch">
            <div id="slideHolder" class="roundBor2">
                <div id="actualSliderBack"></div>
                <div id="actualSlider"></div>
                <p class="clearer"></p>
            </div>
              
            <div id="quickSearchLinks">
            <img src="<?=$staticurl?>images/homemap.png" width="421" height="272" /></div>
      </div>
      <div id="postAd">
		<div id="homePitch">
        <h3>If you are looking to Provide or Find a Shared Accommodation,</h3><br />
		<h3>post a FREE AD on Find Accomodation</h3></div>
        <a href="<?=$baseurl?>ads/create/"><img src="<?=$staticurl?>images/postAd.png" width="225" height="34" border="0" /></a>
        </div>
        <div id="prevPostBtnDiv"></div>
        
        <div id="newAccomodation">
			<div id="providersList">
				<h2>RECENT SHARING PROVIDERS</h2>
				<ul>
				<?php 
				if(!empty($adslist['providers']) && count($adslist['providers'])>0)
				{					
					foreach($adslist['providers'] as $provider)
					{
						$ads_id = $provider['ads_id'];
						$title = $provider['title'];
						
						$title_url = encodeurl($title);
						$full_url = $baseurl . 'ads/detail/' . $title_url . '/' . $ads_id;						
						
						$rentTypeList = getRentTypeList();
						?>
						<li class="roundBor3">
                        	<h1 class="homrectpbar roundBor2">
								<span class="flLeft"><?=$provider['city'].', '.$provider['state'].' '.$provider['postal_code']?></span>
                                <span class="flRight">$<?=$provider['rent']?> / <?=$rentTypeList[$provider['rent_type']]?></span>
                                <br class="clearer" />
                          </h1>
							<div class="homeImage">
								<!--<img src="<?//=$staticurl?>ads_upload/<?//=$provider['name']?>" width="115" height="115" alt="view detail - <?//=$title?>" title="view detail - <?//=$title?>" /><br />-->
						<?php if(!isset($provider['image'][0]['name'])){?><a href="<?=$full_url?>"><img src="<?=$staticurl?>images/accThumb.jpg" alt="view detail - <?=$title?>" /></a><br /><?php } else{?>
						<a href="<?=$full_url?>"><img src="<?=$staticurl?>ads_upload/img2_<?=$provider['image'][0]['name']?>" alt="view detail - <?=$title?>" /><br /><?php }?></a>
							
							</div>
							<div class="listText">
								<p class="homeCatchy padbot7" style="font-size:12px;">
									<a id="homereched" href="<?=$full_url?>" alt="view detail - <?=$title?>" title="view detail - <?=$title?>" ><?=$title?></a>								
								</p>							
								<p class="padbot7 font11"><strong><?=character_limiter($provider['bestfeature1'],40)?><br/>
								<?=character_limiter($provider['bestfeature2'],40)?></strong>
							  </p>
								<p class="font11">
									<?=character_limiter($provider['description'],86)?>
								</p>
							</div>
						</li>						
						<?
					}					
				}				
				?>					
				</ul>
			</div>
			<div id="findersList">
				<h2>RECENT SHARING FINDERS</h2>
				<ul>
				<?php
				if(!empty($adslist['finders']) && count($adslist['finders'])>0)
				{	
					foreach($adslist['finders'] as $finder)
					{
						//$ads_id = $finder['ads_id'];
						$title = $finder['title'];
						$ads_id=$finder['ads_id'];
						$title_url = encodeurl($finder['title']);
						$full_url = $baseurl . 'ads/detail/' . $title_url . '/' .$ads_id ;
						
						$rentTypeList = getRentTypeList();
						?>
						<li class="roundBor3">
							<div class="homeImage">
								<!--<img src="<?=$staticurl?>ads_upload/<?=$finder['name']?>" width="115" height="115" alt="view detail - <?=$title?>" title="view detail - <?=$title?>" /><br />-->
								<?php if(!isset($finder['image'][0]['name'])){?><a href="<?=$full_url?>"><img src="<?=$staticurl?>images/accThumb.jpg" alt="view detail - <?=$title?>" /></a><br /><?php } else{?>
								<a href="<?=$full_url?>"> <img src="<?=$staticurl?>ads_upload/img2_<?=$finder['image'][0]['name']?>" alt="view detail - <?=$title?>" /></a><br /><?}?>
								<a href="<?=$full_url?>" alt="view detail - <?=$title?>" title="view detail - <?=$title?>" >View Full Ad</a>
							</div>
							<div class="listText">
								<h4>$<?=$finder['rent']?>/<?=$rentTypeList[$finder['rent_type']]?> | <?=$finder['city']?></h4>
								<p class="homeCatchy">
									<a href="<?=$full_url?>" alt="view detail - <?=$title?>" title="view detail - <?=$title?>" ><?=$title?></a>								
								</p>							
								<p><strong><?=character_limiter($finder['bestfeature1'],40)?><br/>
								<?=character_limiter($finder['bestfeature2'],40)?></strong></p>
								<p>
									<?=character_limiter($finder['description'],86)?>
								</p>
							</div>
						</li>						
						<?
					}					
				}					
				?>
				</ul>	
			</div>
		</div>
    </div>
    <div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="170" height="502"/>
	  </div>
    <br class="clearer">
	</div>
    <br class="clearer">
</div>
<script type="text/javascript">
	//home page slider
	
	var counter=1;
	function homeslider(){
		$.ajax({
			url: getbaseurl()+'ajax/homeslider/'+counter,
			type: "POST",
			data: "",
			cache: false,
			success: function(data) {
				$('#actualSlider').hide().html(data).fadeIn('slow', function(){
					$('#actualSliderBack').html(data);
				});
			}
		});
		counter++;
		setTimeout(homeslider, 30000);
	}homeslider();
</script>