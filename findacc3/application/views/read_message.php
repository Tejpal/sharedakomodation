<?php $baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';
//print_r($result);
//print_r($_SESSION);
//$user_email=$_SESSION['email'];
$user_email=$this->session->userdata('email');
$msg_from=$result[0]['contact_email'];
 ?>

<script type="text/javascript">
function deletemsg(id)
{
var r=confirm("Do you want delete this message");
if(r==true)
  {window.location = "<?=$base_url?>user/deletemessage_inbox/"+id;
  }
else
  {
  }
}
</script>

<script type="text/javascript">
function deletemsg_sent(id)
{
var r=confirm("Do you want delete this message");
if(r==true)
  {window.location = "<?=$base_url?>user/deletemessage_sent/"+id;
  }
else
  {
  }
}
</script>

<script type="text/javascript">
    function submitform()
    {
		document.forms["reply"].submit();
		return true;
			
    
    }

    </script>


	<?php			if(!empty($message)){
					$message="Message sent";
					
					echo "<p id='success_msg_sent' class='success_notify'>$message</p>";
					
				}
				?>		
			<div id="contentContainer">
	<div id="contentHolder">
		<div id="contentLeft">
		
		  <div id="inboxPage">
		
		  
		  <?php if($user_email==$msg_from){echo '<h2>SENT MESSAGES</h2>'; }
		  else{echo '<h2>RECEIVED MESSAGES</h2>';}?>
		    <div id="accMenu">
					<ul>
						<li <?php if($user_email!=$msg_from){?> class="selected"<?php }?>><a href="<?=$base_url?>user/inbox">Received Messages</a></li>
						<li<?php if($user_email==$msg_from){?> class="selected"<?php }?>><a href="<?=$base_url?>user/sentmessages">Sent Messages</a></li>
					</ul>
			  </div>	
              <div id="mainDetails">
			  	<div class="fullmsgbar">
				
                
				<?php if($user_email!=$msg_from){ ?>
				
				<p class="flmsghead">Message from <?=$result[0]['firstname']?> <?php if($result[0]['contact_email']!='') {?><span>(Email: <a href="#"><?=$result[0]['contact_email']?></a>)</span><?php } ?></p>
				<?php } else { ?>
				<p class="flmsghead">To: <?=$result[0]['r_name']?> <?php if($result[0]['r_email']!='') {?><span>(Email: <a href="mailto:<?=$result[0]['r_email']?>"><?=$result[0]['r_email']?></a>)</span><?php } ?></p>
				<?php } ?>
               	 <?php if($result[0]['contact_email']!='') {?> 
				 <a href="<?=$base_url?>user/thread/<?=$result[0]['thread_id']?>" class="flRight prewactbtn roundBor3">View Complete Thread</a>
				 <?php }?>
				 
				 <?php if($user_email==$msg_from) {?>
                  <a href="javascript:void(0)" onclick="deletemsg_sent(<?php echo $result[0]['ads_message_id'];?>)" class="flRight prewactbtn roundBor3">Delete Message</a>
                 <?php } else { ?>
				 <a href="javascript:void(0)" onclick="deletemsg(<?php echo $result[0]['ads_message_id'];?>)" class="flRight prewactbtn roundBor3">Delete Message</a>
				<?php }?> 
                </div>
                <p class="flmsginfo">
                	<span id="subrep">Subject: <?=$result[0]['subject']?></span>
                    <span id="msgdaterep"><?php if($user_email!=$msg_from){echo "Received:";}else{echo 'Sent:';}?> <?=date('j F, Y',strtotime($result[0]['contact_date']))?>&nbsp;&nbsp;|&nbsp;&nbsp;<?=date('g:i:s A',strtotime($result[0]['contact_date']))?></span><br />
                	<?=$result[0]['message']?> 
                </p>
                
               <?php if(isset($result['img_name'][0]['name'])) { ?>  
			   <p class="flmsgimg">
                <img src="<?=$staticurl?>ads_upload/img2_<?=$result['img_name'][0]['name']?>" /> 
                </p><?php } ?>
              </div>
              <br class="clearer" />	
			  <?php $checksubject=substr($result[0]['subject'],0,2);?>
			  <?php if($result[0]['contact_email']!=''  && $user_email!=$msg_from) {?>
              <div class="flmsgrepbox">
              	<div class="flLeft">
				<form  name="reply" id="reply"  action="" method="POST" >
                	<textarea class="tf508 textField defaultText" name="message"></textarea><br />
					<input type="hidden" value="<?=$result[0]['ads_id']?>" name="adsid">
					<input type="hidden" value="<?=$result[0]['sender_user_id']?>" name="senderid">
					<input type="hidden" value="<?=$result[0]['thread_id']?>" name="threadid">
					<input type="submit" name="reply"  class="marTop10 flLeft prewcntbtn roundBor3" style="color:#fff;" value="Send Reply" />
				</form>
			   </div>
               </div>
                <div class="repldet">
                	<h2 class="reph2" style="padding:0 0 10px 36px;">Reply Here</h2><br class="clearer" />	
                    <p class="replheaders"><strong>Subject: </strong><?=$result[0]['subject']?><br /><br />
                    <strong>From:</strong> <?=$result['rinfo'][0]['firstname'].' '.$result['rinfo'][0]['lastname']?><br /><br />
                    <strong>To:</strong> <?=$result[0]['firstname']?></p>
                </div>
              </div>
			  <?php }?>
              <br class="clearer" />	
			</div>
			
		</div>
   	<div align="right" id="ads">
			<img width="160" height="502" src="<?=$staticurl?>images/ads.jpg">
	  	</div>
         <br class="clearer" />
	</div>
     <br class="clearer" />
</div>
