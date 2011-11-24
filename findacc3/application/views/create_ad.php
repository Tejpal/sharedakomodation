<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';
//print_r($adsfullData);
//print_r($adsImages);

?>
<div id="contentContainer">
	<div id="contentHolder">
		<div id="contentLeft">
			<div id="createAdPage">
				<h2 id="createAdPageh2">
				<?php if($editFlag==1){ ?>
				UPDATE 
				<?php }else{ ?>
				CREATE
				<?php } ?>
				AD - SHARING PROVIDER</h2>
                

					
<div class="roundBor3" id="stepshol">
                	<div id="steponetab" class="stepselected stepfirstback">
                    	<h2 class="stephead">Room/Property Details</h2>(Required)
                    </div>
                    <div id="steptwotab" class="stepmidback">
                    	<h2 class="stephead">About Provider</h2>(Required)
                    </div>
                    <div id="stepthreetab" class="stepmidback">
                    	<h2 class="stephead">Provider's Preferences</h2>(Optional but recommended)
                    </div>
                    <div id="stepfourtab" class="steplastback">
                    	<h2 class="stephead">Ad Information</h2>(Required)
                    </div>
                </div>
                
<form action="" name="create_ad" id="create_ad" method="post" enctype="multipart/form-data" />
<input type="hidden" name="editFlag" id="editFlag" value="<?=$editFlag?>" >
<?php
if($editFlag==1)
{
	?>
	<input type="hidden" name="ads_id" id="ads_id" value="<?=(!empty($adsfullData['ads_id']))?$adsfullData['ads_id']:0?>" >						
	<?
}
?>
                <div id="wizardholout">
                	<div id="wizardhol">
                    </div>
                	<p id="loadergr"><img src="<?=$staticurl?>images/ajaxloader.gif" width="32" height="32" /></p>
                </div>
                <div id="prevPostBtnDivc">
                	<input type="button" id="crprevp" class="flLeft roundBor2 createpagebtnad" value="PREV" />
                    <input type="button" id="crprev" name="prevcreate" class="flLeft roundBor2 createpagebtn" onclick="" value="PREV" />
                    <input type="button" id="crprew" name="previewAdSubmit" class="flRight roundBor2 createpagebtn" onclick="this.form.target='_blank'; preview();" value="PREVIEW AD" />
                    <input type="submit" id="crpost" name="postAdSubmit" class="flRight roundBor2 createpagebtn" value="POST MY AD" />
                	<input type="submit" id="crnext" name="nextcreate" class="flRight roundBor2 createpagebtn" onclick="" value="NEXT" />
                    <input type="button" id="crnextp" class="flRight roundBor2 createpagebtnad" value="NEXT" />
                    <br class="clearer" />
                </div>
				</form>
			</div>
		</div>
		
    <br class="clearer">
	</div>
    <br class="clearer">
</div>
<script>
function preview()
{
	document.create_ad.action = '<?=site_url()?>/ads/preview';
	document.create_ad.submit();
}
</script>
<script type="text/javascript" src="<?=$staticurl?>jqryvalidate.js"></script>

<script type="text/javascript">
 
$(document).ready(function(){
	$.ajax({
		url: getbaseurl()+'ads/propertydetails/'+<?=$adsfullData['ads_id']?>,
		cache: false,
		data:"",
		success: function(data) {
			$('#wizardhol').html(data);
		}
	});

	//script for the wizard
	$('#crpost').click(function(){
		var presentid = $('div.creationbox').attr('id');
		var urlcontroller=presentid;
		$('#create_ad').validate();
	//	$( "#create_ad" ).attr( "enctype", "multipart/form-data" );
		if($("#create_ad").valid()){
			var formdata = $('#create_ad').serialize();
			
			//alert(formdata);
			$.ajax({
				
				url: getbaseurl()+'ads/submitad/'+urlcontroller,
				type: "POST",
				data: formdata,
				success: function(data) {
					window.location = getbaseurl()+'myads/manage/?m=1';
				}
			});
			return false;
		}
	});
	
	$('#crnext').click(function(){
		var presentid = $('div.creationbox').attr('id');
		var urlcontroller=presentid;
		$('#create_ad').validate();
	//	$( "#create_ad" ).attr( "enctype", "multipart/form-data" );
		if($("#create_ad").valid()){
			var formdata = $('#create_ad').serialize();
			
			//alert(formdata);
			$.ajax({
				
				url: getbaseurl()+'ads/submitad/'+urlcontroller,
				type: "POST",
				data: formdata,
				success: function(data) {
				//	var presentid = $('div.creationbox').attr('id');
					//alert(presentid);
					var pagecall='';
					switch (presentid) { 
					case 'stepone': 
						pagecall = 'providerdetails/'+<?=$adsfullData['ads_id']?>;
						break;
			
					case 'steptwo': 
						pagecall = 'providerpref/'+<?=$adsfullData['ads_id']?>;
						break; 
			
					case 'stepthree': 
						pagecall = 'adinformation/'+<?=$adsfullData['ads_id']?>;
						break; 
					}
					$('#wizardhol').fadeOut("fast",function(){
						$(this).next('#loadergr').show();
					});
					$.ajax({
						url: getbaseurl()+'ads/'+pagecall,
						data: "",
						cache:false,
						success: function(data) {
							$('#loadergr').hide();
							$('#wizardhol').html(data).fadeIn("fast");
							$('#stepshol').find('div.stepselected').removeClass('stepselected');
							var currentid = $('div.creationbox').attr('id');
							switch (currentid) { 
							case 'stepone': 
								$('#'+currentid+'tab').addClass('stepselected');
								break;
					
							case 'steptwo': 
								$('#'+currentid+'tab').addClass('stepselected');   
								$('#crprev').show();$('#crprevp').hide();
								break; 
					
							case 'stepthree': 
								$('#'+currentid+'tab').addClass('stepselected');
								break; 
					
							case 'stepfour':   
								$('#'+currentid+'tab').addClass('stepselected');
								$('#crnext').hide(); 
								$('#crpost, #crnextp, #crprew').show();
								break; 
								
							/*case 'stepfive':  
								$('#'+currentid+'tab').addClass('stepselected'); 
								$('#crnext').hide(); 
								$('#crpost, #crnextp, #crprew').show();
								break; */
							}
						}
					});
				}
			});
			return false;
		}
	});
	
	$('#crprev').click(function(){
		var presentid = $('div.creationbox').attr('id');
		var pagecall='';
		switch (presentid) { 
		case 'steptwo': 
			pagecall = 'propertydetails/'+<?=$adsfullData['ads_id']?>;
			break; 

		case 'stepthree': 
			pagecall = 'providerdetails/'+<?=$adsfullData['ads_id']?>;
			break; 

		case 'stepfour':   
			pagecall = 'providerpref/'+<?=$adsfullData['ads_id']?>;
			break;  
		
		/*case 'stepfive':   
			pagecall = 'providerpref/'+<?=$adsfullData['ads_id']?>;
			break; */ 
		}
		$('#wizardhol').fadeOut("fast",function(){
			$(this).next('#loadergr').show();
		});
		$.ajax({
			url: getbaseurl()+'ads/'+pagecall,
			type: "POST",
			data: "",
			cache:true,
			success: function(data) {
				$('#loadergr').hide();
				$('#wizardhol').html(data).fadeIn("fast");
				$('#stepshol').find('div.stepselected').removeClass('stepselected');
				var currentid = $('div.creationbox').attr('id');
				switch (currentid) { 
				case 'stepone': 
					$('#'+currentid+'tab').addClass('stepselected');
					$('#crprev').hide();$('#crprevp').show();
					break;
		
				case 'steptwo': 
					$('#'+currentid+'tab').addClass('stepselected');
					break; 
		
				case 'stepthree': 
					$('#'+currentid+'tab').addClass('stepselected');
					$('#crnext').show(); $('#crnextp').hide(); $('#crpost, #crprew').hide();
					break; 
		
				case 'stepfour':   
					$('#'+currentid+'tab').addClass('stepselected');
					break; 
					
				/*case 'stepfive':  
					$('#'+currentid+'tab').addClass('stepselected'); 
					break; */
				}
			}
		});
	});
	
});
</script>
