<?php

$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
//print_r($adinfo);
if(!empty($communities))
{
$commnames=json_encode($communities);
}
?>
<LINK href="<?=$staticurl?>css/jquery-ui.css" type="text/css" rel="stylesheet" />
<link href="<?=$staticurl?>js/community/css/ui.multiselect.css" rel="stylesheet" type="text/css" />




<p class="compulsorynote">&nbsp;</p>
<div class="creationbox roundBor3" id="stepthree">
	 <div class="flLeft" style="padding-left:10px;">
     <p class="padbot10">
        <label for="gender" class="nwlabel">Gender</label>
        
       <?php
        if(!empty($adinfo) && !empty($adinfo[0]['gender']))
        {
            $gender = $adinfo[0]['gender'];
        }	
		else
		{
		$gender = 'Any';
		}		
        echo displayDropdown(getGenderList(), $name='gender', $selected=array($gender), $classes='selectFieldnw sf250');
        ?>	
        </p>
     	<p class="padbot10">
        <label for="smoker" class="nwlabel">Smoker</label>
        
        <?php	if(!empty($adinfo) && !empty($adinfo[0]['smoker']))
                {
                    $smoker =$adinfo[0]['smoker'];
                }
				else
				{
				$smoker ='Any';
				}				
                echo displayDropdown(getSmokerList(), $name='smoker', $selected=array($smoker), $classes='selectFieldnw sf250');
        ?>	
        </p>
        <p class="padbot10">
            <label for="age" id="ageLbl" class="nwlabel">Age Group</label>
            
           <?php	if(!empty($adinfo) && !empty($adinfo[0]['age']))
                    {
                        $age = $adinfo[0]['age'];
                    }		
					else
					{
					$age ='Any';
					}					
                    echo displayDropdown(getAgeGroupList(), $name='age', $selected=array($age), $classes='selectFieldnw sf250');
            ?>	
        </p>
        <p class="padbot10">
            <label for="orientation" class="nwlabel">Orientation</label>
           
            <?php	if(!empty($adinfo) && !empty($adinfo[0]['orientation']))
                    {
                        $orientation = $adinfo[0]['orientation'];
                    }	
					else
					{
					$orientation = 'Any';
					}								
                    echo displayDropdown(getOrientationList(), $name='orientation', $selected=array($orientation), $classes='selectFieldnw sf250');
            ?>		
        </p>
        <p class="padbot10">
            <label for="diet" id="dietLbl" class="nwlabel">Diet</label>
            
            <?php	if(!empty($adinfo) && !empty($adinfo[0]['diet']))
                    {
                        $diet = $adinfo[0]['diet'];
                    }	
					else
					{
					$diet = 'Any';
					}							
                    echo displayDropdown(getDietList(), $name='diet', $selected=array($diet), $classes='selectFieldnw sf250');
            ?>	
        </p>
        <p class="padbot10">
            <label for="occupation" class="nwlabel">Occupation</label>
            <select name="occupation" id="occupation" class="selectFieldnw sf250">
                    
                    <option value="0">Student</option>
                    <option value="1">Professional</option>
                </select>
     
        </p>
     </div>
 	 <div class="roundBor3 cmboxhol">
        <label for="gender" class="commlabl">Is there any Preferred Community?</label>
        <input type="hidden" id="community" name="community" class="if250 inputFieldnw"/>
        <p class="bortopcomm">
        <span id="pcspan">Select preferred communities</span>
        <span class="flLeft">Your selected communities</span>
        <br class="clearer" />
        </p>
        <div class="communityContentDrop" id="commprefnw">
            <select id="communities" class="multiselect" multiple="multiple" name="communities[]" style="height:160px; width:480px;">
                <?php
                $cmlist = getCommunityList();
                if(!empty($cmlist) && is_array($cmlist) && count($cmlist)>0)
                {
                    foreach($cmlist as $cm)
                    {
                        // country 	community
                        ?>
                        <option value="<?=$cm['id']?>" ><?=$cm['community']?></option>
                        <?php
                    }
                }
                ?>          
              
            </select>
        </div>
        <p class="commhintpp">Mentioning your preferred community can rank your Ad higher in search results for 
        those Sharing Finders who are looking to Share Accommodation in a particular community.
        </p>
    </div>
    <p class="clearer"></p>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(".multiselect").multiselect();
	$(".communityContentDrop").show();
	$('.selCommunitiesHead').hide();
	$('.remove-all').css({ 'float':'left', 'padding-left': '10px', 'line-height': '18px'}).html('Clear All Selected');
  
	var communitynames = <?=$commnames?>;
	if(communitynames[0]!='no communities'){
		$('li.ui-state-default').each(function(){

			for(var i=0;i<communitynames.length;i++){
				//alert(i);
				if($(this).attr('title') == communitynames[i])
					$(this).children('a.action').click();
			}
		});
	}
  
});
</script>  
