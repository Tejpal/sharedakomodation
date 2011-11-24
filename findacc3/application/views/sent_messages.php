<?php $baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';

//print_r($result);exit;
?>

<script type="text/javascript">
function deletemsg(id)
{
var r=confirm("Do you want delete tis message");
if(r==true)
  {window.location = "<?=$base_url?>user/deletemessage_sent/"+id;
  }
else
  {
  }
}
</script>
    <script>
    function checkAll()
    {

        var inputs = document.forms["sent"].getElementsByTagName('input');
        var checkboxes = [];
        for (var i = 0; i < inputs.length; i++) {

              if (inputs[i].type == 'checkbox') {
            if(inputs[i].checked ==true)
			{
			inputs[i].checked =false;
			}
			else {inputs[i].checked =true;}

    }
    }
    }

    </script>
	
	<script type="text/javascript">
    function submitform()
    {

        var inputs = document.getElementsByTagName('input');
        var checkboxes = [];
        for (var i = 0; i < inputs.length; i++) {

              if (inputs[i].type == 'checkbox') {
            
			if(inputs[i].checked ==true)
			{
			document.forms["sent"].submit();
			return true;
			}

    }
    }
	alert('no message selected');
	return false;
    }

    </script>

			
<div id="contentContainer">
	<div id="contentHolder">
		<div id="contentLeft">
		<form name="sent"  onSubmit="return false;" id="sent" action="<?=$base_url?>user/multipledeletemessage_sent" method="POST">
		  <div id="inboxPage">
				<h2>SENT MESSAGES</h2>
				<div id="accMenu">
					<ul>
						<li><a href="<?=$base_url?>user/inbox">Received Messaged</a></li>
						<li class="selected"><a href="<?=$base_url?>user/sentmessages">Sent Messages</a></li>
					</ul>
				</div>
                <br class="clearer" />
                <div id="inboxMessages01">
                	<div id="inboxHeader">
                    	<div class="chkBoxCol floatLeft">
                    		<!--<input type="checkbox" onchange="checkAll()">-->
                        </div>
                    	<div class="fromColumn floatLeft height30">To</div>
                        <div class="messageColumn floatLeft height30">Message</div>
                        <div class="recievedColumn floatLeft height30">Sent</div>
                        <div class="actionsColumn floatLeft height30">Actions</div>
                    </div>
                    
                    
                    <ul id="messagesList">
					<?php foreach($result as $key=>$row){?>
                    	<li>
                        	<div class="chkBoxCol floatLeft">
                    			<input type="checkbox" name="delete[]" value="<?php echo $row['ads_message_id']; ?>">
                        	</div>
                        	<div class="fromColumn floatLeft height52">
                            	<span class="boldText"><?php echo $row['r_name'];?></span><br>
                                <a href="mailto:<?=$row['r_email']?>"><?php echo $row['r_email'];?></a>
                            </div>
                            <div class="messageColumn floatLeft height52">
							<?php $message1=$row['message'];
							$mywtext = word_limiter($message1, 10);?>
                            	<span class="boldText">Subject</span>: <a href="<?=$base_url?>user/readmessage/<?=$row['ads_message_id']?>"><?php echo $row['subject'];?></a><br><?=$mywtext?>
                            </div>
                            <div class="recievedColumn floatLeft height52"><?php echo date('j F Y',strtotime($row['contact_date']))?><br><?php echo date('g:i:s A',strtotime($row['contact_date']))?></div>
                            <div class="actionsColumn floatLeft height52">
							<a href="javascript:void(0)" onclick="deletemsg(<?php echo $row['ads_message_id'];?>)">Delete</a>
                            </div>
                    	</li><?php } ?>
                        
                    </ul>
					<? if(!empty($result)){?>
                    <div id="sentFooter">
                    	<div class="chkBoxCol floatLeft">
                    		<input type="checkbox" onchange="checkAll()">
                        </div>
                        <input type="image" src="<?=$staticurl?>images/deleteBtn.gif"  onclick="submitform()"   id="deleteBtn">
                    </div>
					<? }else{ echo "<p style='padding:10px 0px 0px 30px; margin:0px;'><b>You have not sent any messages yet</b></p>";}?> 
                </div>	
						<?php echo $this->pagination->create_links();?>
				</div>
			</form>
		</div>
   	<div align="right" id="ads">
			<img width="160" height="502" src="<?=$staticurl?>images/ads.jpg">
	  	</div>
        <br class="clearer">
	</div>
	<br class="clearer">
</div>

