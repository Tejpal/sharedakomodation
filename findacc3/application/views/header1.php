<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Find Accomodation - Get Shared Accommodation . Anywhere . Anytime .</title>
<?php
//print_r($_SESSION);
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';


if(!empty($adsdata)){

$s_add=$adsdata['street_address'];
$city=$adsdata['city'];
$state=$adsdata['state'];
$country=$adsdata['country'];
$madd=$adsdata['street_address']." ".$adsdata['city']." ".$adsdata['state']." ".$adsdata['country'];
//echo $madd; exit;
}
//if(isset($_SESSION['user_id']))
if($this->session->userdata('user_id'))
{
//$user_id =$_SESSION['user_id'];
$user_id =$this->session->userdata('user_id');
}
//print_r($result1);exit;
?>


<link href="<?=$staticurl?>css/find.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/dev.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>js/newSelect/msdropdown/dd.css" rel="stylesheet" type="text/css" />
<LINK href="<?=$staticurl?>css/jquery-ui.css" type="text/css" rel="stylesheet" />
<link href="<?=$staticurl?>js/community/css/ui.multiselect.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>js/location/styles/autoSuggest.css" rel="stylesheet" type="text/css" />

<script src="<?=$staticurl?>js/jquery.min.js"></script>
<script src="<?=$staticurl?>js/jquery-ui.min.js"></script>

<script src="<?=$staticurl?>js/community/js/ui.multiselect.js" type="text/javascript"></script>



<script src="<?=$staticurl?>js/cufon-yui.js" type="text/javascript"></script>

<script src="<?=$staticurl?>js/dinMedium_500.font.js" type="text/javascript"></script>

<script src="<?=$staticurl?>js/dinRegular_400.font.js" type="text/javascript"></script>

<script src="<?=$staticurl?>js/newSelect/msdropdown/js/jquery.dd.js" type="text/javascript"></script>

<script src="<?=$staticurl?>js/mydocumentready.js" type="text/javascript"></script>

<script type="text/javascript" src="<?=$staticurl?>js/greybox/greybox.js"></script>

<link href="<?=$staticurl?>js/greybox/greybox.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=$staticurl?>js/jquery.hoverIntent.minified.js"></script>

<style type="text/css">


</style>


<script type="text/javascript">
$(document).ready(function() {

});
</script>  
     

<script type="text/javascript">
		function getbaseurl(){
		return "<?=$base_url?>";
	}
	function getstaticurl(){
		return "<?=$staticurl?>";
	}
	
</script>





</head>
<body>
<?php
$login = false;
//if( !empty($_SESSION['user_id']) && $_SESSION['user_id']>0)
if($this->session->userdata('user_id') && $this->session->userdata('user_id')>0)
{
	$login = true;
}
if(empty($tabon))
	$tabon = 0;
?>
<div id="topBarContainer">
	<div id="topBarHolder" >
		<div class="navBox">
			<ul>
				<li <?=($tabon==0)?'class="selected"':''?>>
				<?php if($this->session->userdata('user_id')) {?>
				<?php echo anchor('/user/profile/', " ", 'class="homeBtn",title="Home",alt="Home"'); ?>				
				<?php } else { echo anchor($base_url, " ", 'class="homeBtn",title="Home",alt="Home"'); }?></li>
				<li <?=($tabon==1)?'class="selected"':''?>>
				<?php echo anchor('/ads/create/', " ", 'class="freeAdBtn",title="Create Free Ad",alt="Create Free Ad"'); ?>				
				</li>				
				<li <?=($tabon==2)?'class="selected"':''?>>
				<?php echo anchor('/search', " ", 'class="advSearchBtn",title="Search",alt="Search"'); ?>				
				</li>
				<li <?=($tabon==3)?'class="selected"':''?>>
				<?php echo anchor('/work', " ", 'class="worksBtn",title="Search",alt="Search"'); ?>				
				</li>
			</ul>
		</div>
		<div class="loginBox" align="right">

			<?php
			if($login)
			{
				?>               
                
                <div class="navBoxRt">
                <ul id="topnav" class="mainNav">
                    <li><a href="<?=site_url("/user/signout/")?>" class="navlogout"></a></li>
                    <li <?=($tabon==4)?'class="selected"':''?>><a href="<?=site_url("/user/account/")?>" class="navmyaccount"></a></li>
                    <li <?=($tabon==5||$tabon==6)?'class="selected"':''?>><a href="<?=site_url("/myads/manage/")?>" class="navmyads"></a>
                    	<div class="sub">
                        <p class="menushdwo"><img src="<?=$staticurl?>images/menushadow.png" width="150" height="11" /></p>
                        <p id="myadsmark"></p>
                        <ul>
                          <li><a href="<?=site_url("/myads/manage/")?>" class="manageads"></a></li>
                            <li><a href="<?=site_url("/myads/shortlisted/")?>" class="shortlistedads"></a></li>
                            <li><a href="<?=site_url("/myads/matching/")?>" class="matchingads"></a></li>
                        </ul>
                        </div>
                    </li>
                  <li><div id="welMsg">Welcome <?php echo $this->session->userdata('firstname'); ?> !</div>
                    <div id="navInbox">
                    <a href="<?=site_url("/user/inbox")?>">
                    <?php if(!empty($result1)){ ?>
                    <img src="<?=$staticurl?>images/navinboxyel.gif" border="0" title="<?php echo $result1."unread messages";?>" alt="Inbox" id="inboxiconlight" />
                    <?php }else{ ?>
                    <img src="<?=$staticurl?>images/navinbox.gif" border="0" title="0 unread messages" alt="Inbox" id="inboxiconnolt" />
                    <?php } ?>
					<span id="msgIndicator"><?php if(!empty($result1)){echo $result1;}?></span>
                    </a>
                    </div>
                  </li>
                </ul>
                </div>
				<?php
			}
			else
			{
				?>
				<form action="<?=site_url("/user/signin/")?>" name="loginform-head" id="loginform-head" method="post" >
				<div id="signFields">
					<input type="text" class="topLoginFields topBarField" title="email" name="email"  /></div>
				<div id="signFields">	<input type="password" class="topLoginFields topBarField" title="password" name="userpassword"  />
				</div>
				<div id="signTopBtn">
					<input type="image" src="<?=$staticurl?>images/signin.gif" width="67" height="16" border="0" alt="Login - Signin" title="Login - Signin" />				
				</div>		
				<div class="welcomename fl_left">
					<?php echo anchor('/user/signup/', "Signup", 'title="Signup",alt="Signup"'); ?>												
				</div>				
			</form>
				<?php
			}
			?>
        </div>
	</div>
</div>
 
<div id="mainBarContainerAlt">
<p id="bannershado"></p>
<div id="mainBarHolder">
	<div id="logoBoxAlt">
        <a href="<?=site_url()?>" alt="Shared Akomodation" title="Shared Akomodation">
        <img src="<?=$staticurl?>images/logo.png" border="0" /></a>
    </div>	
</div>	
</div>