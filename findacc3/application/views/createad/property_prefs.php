<?php 
$staticurl = $this->config->item('static_url'); 
$base_url = site_url() . '/';
$baseurl = $this->config->item('base_url');

?>
<link href="<?=$staticurl?>js/post_code/autoSuggest.css" rel="stylesheet" type="text/css" />
<p class="compulsorynote">(Fields marked with * are compulsory)</p>
<div class="creationbox roundBor3" id="stepone">
	<p id="nwErrorBox" class="error-notify"></p>
    <div class="flLeft" id="rpcontenthol">
        <p class="rpicons"><img src="<?=$staticurl?>images/rptag.gif" width="34" height="51" /></p>
        <p class="rpfieldhol">
            <label for="rent" id="rentLbl" class="nwlabel">Rent</label>
            <input type="text" id="rent" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['rent'];}?>" name="rent" class="if140 inputFieldnw"/>
        </p>
        <p class="rpfieldhol">
            <label for="rentDuration" id="rentDurationLbl" class="nwlabel">Rent Duration</label>
          <?php
		  
		  
		  ///start
            if(!empty($adinfo) && !empty($adinfo[0]['rent_type']))
            {
                $rent = $adinfo[0]['rent_type'];
            }
			else
			{
			$rent ='Weekly';
			}
		
			echo displayDropdown(getRentTypeList(), $name='rentDuration', $selected=array($rent), $classes='selectFieldnw sf140');
				
		?>
        </p>

        <p class="rpfieldhol">
            <label for="bondSecurity" class="nwlabel">Bond/Security</label>
            <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['bond'];}?>" id="bondSecurity" name="bondSecurity" class="if140 inputFieldnw" />
        </p>
        <p class="clearer"></p>
        
        
         <p class="rpicons"><img src="<?=$staticurl?>images/rphouse.gif" width="34" height="51" /></p>
        <p class="rpfieldhol">
            <label for="propertyType" class="nwlabel">Property Type</label>
 
            <?php	if(!empty($adinfo) && !empty($adinfo[0]['property_type']))
                    {
                        $property_type = $adinfo[0]['property_type'];
                    }
					else
					{
					$property_type = 'Any';
					}					
		
		echo displayDropdown(getPropertyType(), $name='propertyType', $selected=array($property_type), $classes='selectFieldnw sf140');
					
            ?>	
        </p>
        <p class="rpfieldhol">
            <label for="bedrooms" class="nwlabel">Bedrooms Available</label>
         <?php	if(!empty($adinfo) && !empty($adinfo[0]['bed_rooms']))
                    {
                        $bed_rooms = $adinfo[0]['bed_rooms'];
                    }
				else
					{
					$bed_rooms='Any';
					}					
                    echo displayDropdown(getNoList(), $name='bedrooms', $selected=array($bed_rooms), $classes='selectFieldnw sf140');
            ?>
        </p>
        <p class="rpfieldhol">
            <label class="nwlabel">Parking</label>
         	
			
			<?php	if(!empty($adinfo) && !empty($adinfo[0]['parking']))
                    {
                        $parking = $adinfo[0]['parking'];
                    }
				else
					{
					$parking='Any';
					}					
                    echo displayDropdown(getParkingType(), $name='parking', $selected=array($parking), $classes='selectFieldnw sf140');
            ?>
			
			
			
			
        </p>
        <p class="clearer"></p>
        
        
        <p class="rpicons"><img src="<?=$staticurl?>images/rpkey.gif" width="34" height="51" /></p>

        <p class="rpfieldhol">
            <label for="availability" id="availabilityLbl" class="nwlabel">Availability</label>
            <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['availability'];}?>" id="availability" autocomplete="off" name="availability" class="if140 inputFieldnw" />
        </p>
        <p class="rpfieldhol">
            <label for="minStay" class="nwlabel">Min Stay</label>
         <?php	if(!empty($adinfo) && !empty($adinfo[0]['min_stay']))
                    {
                        $min_stay = $adinfo[0]['min_stay'];
                    }	
					else
					{
					$min_stay ='Any';
					}					
                    echo displayDropdown(getStayList(), $name='minStay', $selected=array($min_stay), $classes='selectFieldnw sf140');
            ?>
        </p>
        <p class="rpfieldhol">
            <label for="maxStay" id="maxStayLbl" class="nwlabel">Max Stay</label>
            

			            <?php	
					if(!empty($adinfo) && !empty($adinfo[0]['max_stay']))
                    {
                        $max_stay = $adinfo[0]['max_stay'];
                    }	
					else
					{
					$max_stay = 'Any';
					}					
                    echo displayDropdown(getStayList(), $name='maxStay', $selected=array($max_stay), $classes='selectFieldnw sf140');
            ?>	
        </p>
        <p class="clearer"></p>
         <p class="rpiconsaddr"><img src="<?=$staticurl?>images/cdaddress.gif" width="34" height="51" /></p>
         <div id="rpaddrhol">

            <p class="rpfieldhol">
                <label for="streetAddress" class="nwlabel">Street Address</label>
                <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['street_address'];}?>" name="streetAddress" id="streetAddress" class="if295 inputFieldnw" />
            </p>
            <p class="clearht5"></p>
            <p class="rpfieldhol">
                <label for="postCode" id="postCodeLbl" class="nwlabel">PostCode</label>
                <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['postal_code'];}?>" name="postCode" id="postCode" class="if140 inputFieldnw" autocomplete="off" />
            <input type="hidden" id="postcodeboxhid" name="postcodeboxhid"  />
			</p>
			
            <p class="rpfieldhol">
                <label for="suburb" id="suburbLbl" class="nwlabel">Suburb</label>
                <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['city'];}?>" name="suburb" id="suburb" class="if140 inputFieldnw" />
            </p>
            <p class="rpfieldhol">
                <label for="state" class="nwlabel">State</label>
                
               <!-- <?php	if(!empty($adinfo) && !empty($adinfo[0]['state']))
                        {
                            $state = $adinfo[0]['state'];
                        }				
						else
						{
						$state = 'Any';
						}						
                        echo displayDropdown(getStateList(), $name='state', $selected=array('Any'), $classes='selectFieldnw sf140');
                ?>	
				-->
				<input type="text"  name="state" id="state" value="<?php if(!empty($adinfo) && !empty($adinfo[0]['state'])) { echo$adinfo[0]['state']; }?>" class="if140 inputFieldnw" />
            </p>
			
        </div>
        <p class="clearer"></p>
    </div>
    <div id="utilfurhol">
        <div class="utilfur roundBor3">
            <label class="utillble nwlabel">Are Utility Bills included in the rent?</label>
            <?php	if(!empty($utl_bills))
                    {
                        
						$utl_bills_count=count($utl_bills);
						for($x=0;$x<=$utl_bills_count-1;$x++)
						{
						$utl_bills2[$x]=$utl_bills[$x]['name'];
						}
                    }
					else
					{
					$utl_bills2=array();
					}		
            ?>	
            <input type="radio" name="utilBills" id="utilBills1" value="1" <?php if(!empty($utl_bills)) {?> checked="checked"<?php }?> />
            <label for="utilBills1" >Yes</label>&nbsp;&nbsp;
            <input type="radio" name="utilBills" id="utilBills2" value="0" <?php if(empty($utl_bills)) {?> checked="checked"<?php }?> />
            <label for="utilBills2" >No</label>
            <div class="radioDropD" id="utilBillContent">
                <strong>Choose which utilities are included:</strong><br />
                <?php   								
						echo displayCheckboxs(getUtilBillsList(), $name='utilBillsList[]', $selectedlist=$utl_bills2, $classes='');
				?>	
                <p class="clearer"></p>
            </div>
        </div>
        <div class="utilfur roundBor3">
            <label class="utillble nwlabel">Is the Room / Property furnished?</label>
			<?php	if(!empty($furinished_list))
					{
						
						$furinished_list_count=count($furinished_list);
						for($y=0;$y<=$furinished_list_count-1;$y++)
						{
						$furinished_list2[$y]=$furinished_list[$y]['name'];
						}
					}	
					else
					{
					$furinished_list2=array();
					}
					
					
					
			?>
            <input type="radio" name="furnish" id="furnish1" value="1" <?php if(!empty($furinished_list)) {?> checked="checked"<?php }?>/>
            <label for="furnish1" >Yes</label>&nbsp;&nbsp;
            <input type="radio" name="furnish" id="furnish2" value="0" <?php if(empty($furinished_list)) {?> checked="checked"<?php }?> />
            <label for="furnish2" >No</label>	
            <div class="radioDropD" id="furnishContent">
                <strong>Choose which things are included:</strong>
			<?php										
					echo displayCheckboxs(getFurnishedList(), $name='furnishList[]', $selectedlist=$furinished_list2, $classes='');
			?>
                <p class="clearer"></p>
            </div>
        </div>
        <br class="clearer" />
  </div>
  <br class="clearer" />
</div>
<script src="<?=$staticurl?>js/post_code/postcode.autoSuggest.js"></script>
<script type="text/javascript">

</script>
<script type="text/javascript">

$(document).ready(function() {

	$("#postCode").autoSuggest({
		
		ajaxFilePath	: "<?=$base_url?>ajax/postcode/", 
		ajaxParams	 	: "dummydata=dummyData", 
		autoFill	 	: false, 
		iwidth		 	: "600px",
		opacity		 	: "1.0",
		ilimit		 	: "10",
		idHolder	 	: "postcodeboxhid"
	});
});
		//utility bills show hide div
	$('#utilBills1').click(function() {
			$("#utilBillContent").slideDown("fast");
	}); 
	$('#utilBills2').click(function() {
			$("#utilBillContent").slideUp("fast");
	}); 
	
	//furnishing show hide div
	$('#furnish1').click(function() {
			$("#furnishContent").slideDown("fast");
	}); 
	$('#furnish2').click(function() {
			$("#furnishContent").slideUp("fast");
	}); 
	
	$("#availability").datepicker();
	
	if($('#utilBills1:checked').length>0){
		$('#utilBillContent').slideDown("fast");
	}
	if($('#furnish1:checked').length>0){
		$('#furnishContent').slideDown("fast");
	}
	
</script>  


