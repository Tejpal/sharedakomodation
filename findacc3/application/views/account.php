<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';
//print_r($this->session->all_userdata());

?>
<script type="text/javascript">
  $(document).ready(function(){
	var changeCaller='';
	var processing = false;
	
	var sharingtype = <?=$this->session->userdata('sharing_type')?>;
	
	// on change click
	$(".changeDetails").click(function(e)
	{
		e.preventDefault();
		var getId = $(this).attr('id');
		if(changeCaller != getId){
			changeCaller=getId;
			$.ajax({
				url: baseurl + 'user/' + getId+'',
				type: "POST",
				cache: true,
				success: function(data) {
				
					$('#changesContainer').hide().html(data).slideDown("fast");
					
					// on cancel click
					$("#chCancel").click(function(e){
						changeCaller='';
						$(this).parents('div#changesContainer').slideUp("fast");	
					});					
					
					// on update username click
					$("#updateUsername").click(function(e)
					{
						//$(this).parents('div#changesContainer').slideUp("fast");
						$('#updatecancel').removeClass('d1').addClass('d2');
						$('#updatecancel-progress').removeClass('d2').addClass('d1');
						// update records	
						var formdata = $("#usernameform").serialize();
						// console.log(formdata);
						$.ajax({
							url: baseurl + 'user/updateUsername',
							type: 'POST',
							dataType: 'json',
							data: formdata,
							cache: false,
							success: function(data) {
								//$('#changesContainer').hide().html(data).slideDown("fast");
								// console.log(data);
								//$('#updatecancel-progress').removeClass('d1').addClass('d2');
								
								if(data.status==0)
								{
									$('#error').html(data.message);
									
									$('#updatecancel').removeClass('d2').addClass('d1');
									$('#updatecancel-progress').removeClass('d1').addClass('d2');								
								}
								else
								{
									$('#msg_error').html(data.message);
									$('#lbl_username').html($('#username').val());
									
									changeCaller='';
									//$(this).parents('div#changesContainer').slideUp("fast");
									$('#changesContainer').hide();
								}
								
							},
							error:function(data) {
								//$('#changesContainer').hide().html(data).slideDown("fast");
								// console.log(data);
								$('#updatecancel').removeClass('d2').addClass('d1');
								$('#updatecancel-progress').removeClass('d1').addClass('d2');
							}		
						});					
					});	

					// on update password click
					$("#updatePassword").click(function(e)
					{
						//$(this).parents('div#changesContainer').slideUp("fast");
						$('#updatecancel').removeClass('d1').addClass('d2');
						$('#updatecancel-progress').removeClass('d2').addClass('d1');
						// update records	
						var formdata = $("#passwordform").serialize();
						// console.log(formdata);
						$.ajax({
							url: baseurl + 'user/updatePassword',
							type: 'POST',
							dataType: 'json',
							data: formdata,
							cache: false,
							success: function(data) {
								//$('#changesContainer').hide().html(data).slideDown("fast");
								// console.log(data);
								//$('#updatecancel-progress').removeClass('d1').addClass('d2');
								
								if(data.status==0)
								{
									$('#error').html(data.message);
									
									$('#updatecancel').removeClass('d2').addClass('d1');
									$('#updatecancel-progress').removeClass('d1').addClass('d2');								
								}
								else
								{
									$('#msg_error').html(data.message);
									$('#lbl_username').html($('#username').val());
									
									changeCaller='';
									//$(this).parents('div#changesContainer').slideUp("fast");
									$('#changesContainer').hide();
								}
								
							},
							error:function(data) {
								//$('#changesContainer').hide().html(data).slideDown("fast");
								// console.log(data);
								$('#updatecancel').removeClass('d2').addClass('d1');
								$('#updatecancel-progress').removeClass('d1').addClass('d2');
							}		
						});					
					});						
					
					// on update email click
					$("#updateEmail").click(function(e)
					{
						//$(this).parents('div#changesContainer').slideUp("fast");
						$('#updatecancel').removeClass('d1').addClass('d2');
						$('#updatecancel-progress').removeClass('d2').addClass('d1');
						// update records	
						var formdata = $("#emailform").serialize();
						// console.log(formdata);
						$.ajax({
							url: baseurl + 'user/updateEmail',
							type: 'POST',
							dataType: 'json',
							data: formdata,
							cache: false,
							success: function(data) {
								//$('#changesContainer').hide().html(data).slideDown("fast");
								// console.log(data);
								//$('#updatecancel-progress').removeClass('d1').addClass('d2');
								
								if(data.status==0)
								{
									$('#error').html(data.message);
									
									$('#updatecancel').removeClass('d2').addClass('d1');
									$('#updatecancel-progress').removeClass('d1').addClass('d2');								
								}
								else
								{
									$('#msg_error').html(data.message);
									$('#lbl_email').html($('#email').val());
									
									changeCaller='';
									//$(this).parents('div#changesContainer').slideUp("fast");
									$('#changesContainer').hide();
								}
								
							},
							error:function(data) {
								//$('#changesContainer').hide().html(data).slideDown("fast");
								// console.log(data);
								$('#updatecancel').removeClass('d2').addClass('d1');
								$('#updatecancel-progress').removeClass('d1').addClass('d2');
							}		
						});					
					});	
					
				}		
			});
		}
	});	
	
	// on click switch sharing account
	
	$("#cls_switch_sharing").click(function(e)
	{
		// console.log('cls_switch_sharing');
		if(processing)
		{			
			alert('Please wait!');			
		}
		else
		{			
			processing = true;
			
			$('#cls_switch_sharing').hide();
			$('#updatecancel-progress-1').show();
			// update records	
			
			if(sharingtype==1)			
				var formdata = {'sharing_type':0};
			else
				var formdata = {'sharing_type':1};
			// console.log(formdata);
			$.ajax({
				url: baseurl + 'user/switchAccount',
				type: 'POST',
				dataType: 'json',
				data: formdata,
				cache: false,
				success: function(data) {
					
					// console.log(data);
					
					if(data.status==0)
					{
						$('#error2').html(data.message);
						
						$('#cls_switch_sharing').show();
						$('#updatecancel-progress-1').hide();								
					}
					else
					{
						$('#msg_error2').html(data.message);						
						
						var txt1 = '';
						var txt2 = '';
						var txt3 = '';
						
						
						if(sharingtype==1)		
						{
							txt1 = 'Sharing Finder';							
							txt2 = 	'You have a Sharing Finder account' 
									+' with Shared Akomodation.com at the moment. If you' 
									+' wish to switch to Sharing Provider account then click on the button on the right.';							
							txt3 = 'SWITCH TO SHARING PROVIDER ACCOUNT';
						}
						else
						{	
							txt1 = 'Sharing Provider';
							txt2 = 	'You have a Sharing Provider account' 
									+' with Shared Akomodation.com at the moment. If you' 
									+' wish to switch to Sharing Finder account then click on the button on the right.';							
							txt3 = 'SWITCH TO SHARING FINDER ACCOUNT';										
						}
						$('#lbl_sharing_type').html(txt1);
						$('#switch_sharing_text').html(txt2);
						$('#cls_switch_sharing').html(txt3);
						
						changeCaller='';
						//$(this).parents('div#changesContainer').slideUp("fast");
						//$('#changesContainer').hide();
						
						if(sharingtype==1)			
							sharingtype = 0;
						else
							sharingtype = 1;
						$('#cls_switch_sharing').show();
						$('#updatecancel-progress-1').hide();							
						
					}
					processing = false;
				},
				error:function(data) {
					//$('#changesContainer').hide().html(data).slideDown("fast");
					// console.log(data);
					$('#cls_switch_sharing').show();
					$('#updatecancel-progress-1').hide();
					processing = false;
				}		
			});				
			
		}
	});		
	
	// on click switch sharing account
	$("#cls_update_email_alerts").click(function(e)
	{
		// console.log('cls_update_email_alerts-1');
		// console.log($("input:radio[checked=false]").val());
		// console.log($('input:radio:not(:checked)').val());
		
		// console.log($("input[name='yesNo1']:checked"))
		// console.log($("input[name='yesNo2']:checked"))
		
		// console.log($("input[name='yesNo1']:checked").val())
		// console.log($("input[name='yesNo2']:checked").val())
		
		if( typeof $("input[name='yesNo1']:checked").val() == 'undefined' && typeof $("input[name='yesNo2']:checked").val() == 'undefined' )
		{
			$('#error3').html('Please select at least one.');	
		}
		else
		{
		
			// console.log('cls_update_email_alerts-2');
			if(processing)
			{			
				alert('Please wait!');			
			}
			else
			{			
				processing = true;	


				$('#cls_update_email_alerts').hide();	
				$('#updatecancel-progress-2').show();
				// update records	
				
				var formdata = $("#email_alertsform").serialize();
				// console.log(formdata);
				$.ajax({
					url: baseurl + 'user/updateNewsAndAlerts',
					type: 'POST',
					dataType: 'json',
					data: formdata,
					cache: false,
					success: function(data) {
						
						// console.log(data);
						
						if(data.status==0)
						{
							$('#msg_error3').html(data.message);
							
							$('#cls_update_email_alerts').show();
							$('#updatecancel-progress-2').hide();								
						}
						else
						{
							$('#msg_error3').html(data.message);						

							$('#cls_update_email_alerts').show();
							$('#updatecancel-progress-2').hide();							
							
						}
						processing = false;
					},
					error:function(data) {
						//$('#changesContainer').hide().html(data).slideDown("fast");
						// console.log(data);
						$('#cls_update_email_alerts').show();
						$('#updatecancel-progress-2').hide();
						processing = false;
					}		
				});	
				
			}
		}
		
	});	
	
	
  });
  
</script>

<div id="contentContainer">
  	<div id="contentHolder">
		<div id="contentLeft">
			<div id="accSettingsPage">
				<h2>MY ACCOUNT</h2>
                <p class="clearer"></p>
				<div id="userDetails" >
					<h3>User Details</h3>
					<span id="msg_error" class="d_error_message2"></span>
					<div>
						
						<label class="boldText">Email - </label><label id="lbl_email"><?=$this->session->userdata('email')?$this->session->userdata('email'):''?></label>
                        <a href="#" class="changeDetails" id="changeEmail">Change</a><br/><br/>
						<label class="boldText">Password - </label><label>******</label>
                        <a href="#" class="changeDetails" id="changePassword">Change</a><br/><br/>
                        
                    
						
					</div>
					<div id="changesContainer">
						
					</div>
                    <p class="clearer"></p>
				</div>
			
				<div id="alertsEmails">
					<h3>Alerts and Emails</h3><span id="error3" class="d_error_message"></span>
					<span id="msg_error3" class="d_error_message2"></span>
					<?php
					
					?>
					<div class="divOne">
                    <p class="flLeft">
                    	<label for="yesNo1">Receive the Matching Ads in your email?</label><br /><br />
                    	<label for="yesNo1">Receive Shared Akomodation newsletter in your email?</label>
                    </p>
                    <p class="flLeft">	
						<form action="" name="email_alertsform" id="email_alertsform" method="POST">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="yesNo1" id="yesNo1-1" value="1" <?=($this->session->userdata('matching_alerts') && $this->session->userdata('matching_alerts')=='1')?'checked="checked"':''?> />&nbsp;Yes&nbsp;&nbsp;
							<input type="radio" name="yesNo1" id="yesNo1-2" value="0" <?=($this->session->userdata('matching_alerts')=='0' )?'checked="checked"':''?> />&nbsp;No<br/><br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="yesNo2" id="yesNo2-1" value="1" <?=($this->session->userdata('news_letter') && $this->session->userdata('news_letter')=='1' )?'checked="checked"':''?> />&nbsp;Yes&nbsp;&nbsp;
							<input type="radio" name="yesNo2" id="yesNo2-2" value="0" <?=($this->session->userdata('news_letter')=='0' )?'checked="checked"':''?> />&nbsp;No
						</form>
                    </p>
					</div>
					<div class="divTwo" align="right">
						<p><br /><a href="javascript: return false;" id="cls_update_email_alerts">UPDATE THE ALERTS AND EMAILS</a></p>
						<span id="updatecancel-progress-2" class="d2">
							<span class="processing">Processing please wait...</span>
							<img src="<?=$staticurl?>images/processing.gif">
						</span>	
					</div>
					<p class="clearer"></p>
				</div>
				<a href="<?=$base_url?>user/savedsearch" ><h4>Your saved searches</h4></a>
			</div>
		</div>
    	
	 	<div id="ads" align="right">
			<img src="<?=$staticurl?>images/ads.jpg" width="160" height="502"/>
	  	</div>
        <br class="clearer">
	</div>
	<br class="clearer">
</div>
