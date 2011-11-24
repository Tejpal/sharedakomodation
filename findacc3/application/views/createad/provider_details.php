<?php $staticurl = $this->config->item('static_url'); 
//print_r($adinfo);
//echo '<pre>';print_r($adinfo);echo '</pre>';
?>

<p class="compulsorynote">(Fields marked with * are compulsory)</p>
<div class="creationbox roundBor3" id="steptwo">
    <div class="flLeft" id="rpcontenthol">

        <p class="cdicons"><img src="<?=$staticurl?>images/cdcontact.gif" width="34" height="51" /></p>
        <p class="rpfieldhol">
            <label for="firstName" id="firstNameLbl" class="nwlabel">Firstname</label>
            <input type="text" value="<?php if(!empty($adinfo[0]['first_name'])){ echo $adinfo[0]['first_name'];} else{ echo $firstname;}?>" name="firstName" id="firstName" class="if140 inputFieldnw" />
        </p>
        <p class="rpfieldhol">
            <label for="lastName" id="lastNameLbl" class="nwlabel">Lastname</label>
            <input type="text" value="<?php if(!empty($adinfo[0]['last_name'])){ echo $adinfo[0]['last_name'];} else{ echo $lastname;}?>" name="lastName" id="lastName" class="if140 inputFieldnw" />
        </p>
        <p class="rpfieldhol">
            <label for="phoneNo" class="nwlabel">Phone Number</label>
            <input type="text" value="<?php if(!empty($adinfo)){ echo $adinfo[0]['phone'];}?>" name="phoneNo" id="phoneNo" class="if230 inputFieldnw" /><br />
           
            <input type="checkbox" name="phoneVisible" id="phoneVisible" class="checkboxMargin" value="1" <?php if($adinfo[0]['phone_visibility']==1 || $adinfo[0]['phone_visibility']==NULL ){?> checked="checked" <?php } ?> />
        	<label for="phoneVisible" class="labmartop font12">Make my Phone No. visible to all</label>
        </p>
        <p class="rpfieldhol">
            <label for="emailId" class="nwlabel">Email ID</label>
            <input type="text" value="<?php if(!empty($adinfo[0]['email'])){ echo $adinfo[0]['email'];} else{ echo $auto_email;}?>" name="emailId" id="emailId" class="if230 inputFieldnw" /><br />
            <input type="checkbox" name="emailVisible" id="emailVisible" class="checkboxMargin" value="1" <?php if($adinfo[0]['email_visibility']==1 || $adinfo[0]['email_visibility']==NULL ){?> checked="checked" <?php } ?> />
            <label for="emailVisible" class="labmartop font12">Make my Email ID visible to all</label>
        </p>
        <p class="clearer"></p>
    </div>
    <br class="clearer" />
</div>