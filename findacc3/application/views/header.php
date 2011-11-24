<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Find Accomodation - Get Shared Accommodation . Anywhere . Anytime .</title>

<?php
//print_r($_COOKIE);
//print_r($community_array);
 
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';
/* $commnames=array("no communities");
$commnames = json_encode($commnames); */
if(!empty($communities))
{//print_r($communities);
$commnames=$communities;
$commnames = json_encode($commnames);

}
else if(!empty($_COOKIE['community']))
{

$commnames=$_COOKIE['community'];
//print_r($commnames);
$commnames = json_encode($commnames);

}
else{
$commnames=array("no communities");
$commnames = json_encode($commnames);	
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
<LINK href="<?=$staticurl?>css/jquery-ui.css" type="text/css" rel="stylesheet" />
<link href="<?=$staticurl?>js/community/css/ui.multiselect.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>js/location/styles/autoSuggest.css" rel="stylesheet" type="text/css" />


<script src="<?=$staticurl?>js/jquery.min.js"></script>
<script src="<?=$staticurl?>js/jquery-ui.min.js"></script>
<script src="<?=$staticurl?>js/community/js/ui.multiselect.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/location/js/jquery.autoSuggest.js"></script>
<!--<script src="<?=$staticurl?>js/location/js/jquery.js"></script>-->
<script src="<?=$staticurl?>js/cufon-yui.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinMedium_500.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinRegular_400.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/mydocumentready.js" type="text/javascript"></script>

<script type="text/javascript" src="<?=$staticurl?>js/greybox/greybox.js"></script>
<link href="<?=$staticurl?>js/greybox/greybox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	var GB_ANIMATION = true;
</script>
<script type="text/javascript" src="<?=$staticurl?>js/jquery.hoverIntent.minified.js"></script>     
<script type="text/javascript">


		function getbaseurl(){
		return "<?=$base_url?>";
	}
	function getstaticurl(){
		return "<?=$staticurl?>";
	}
</script>
<script type="text/javascript">

$(document).ready(function() {
	$(".multiselect").multiselect();
	var communitynames = <?=$commnames?>;
	//alert(communitynames.length);
	if(communitynames[0]!='no communities'){
		$('li.ui-state-default').each(function(){

			for(var i=0;i<communitynames.length;i++){
				//alert(i);
				if($(this).attr('title') == communitynames[i])
					$(this).children('a.action').click();
			}
		});
	}
	
    $("#community").click(function(){
		if ($(".communityContentDrop").is(':hidden'))
			$(".communityContentDrop").show("fast");
		else{
			$(".communityContentDrop").hide("fast");
		}
		return false;
	});

	$('.communityContentDrop').click(function(e) {
		e.stopPropagation();
	});
	$(document).click(function() {
		if($('.communityContentDrop').is(':visible')){
			$('.communityContentDrop').hide("fast");
		}
	});
	
	$("#location").autoSuggest({
		ajaxFilePath	: "<?=$base_url?>ajax/locations2/", 
		ajaxParams	 	: "dummydata=dummyData", 
		autoFill	 	: false, 
		iwidth		 	: "600px",
		opacity		 	: "1.0",
		ilimit		 	: "10",
		idHolder	 	: "locationboxhid"
	});
});
</script>  

</head>
<body>
<p>
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
</p>
<div id="topBarContainer">
  <div id="topBarHolder" >
		<div class="navBox">
			<ul>
				<li <?=($tabon==0)?'class="selected"':''?>>
				<!--<?php //if(isset($_SESSION['user_id'])) {?>-->
				<?php if($this->session->userdata('user_id')) {?>
				<?php echo anchor('/user/profile/', " ", 'class="homeBtn",title="Home",alt="Home"'); ?>				
				<?php } else { echo anchor($base_url, " ", 'class="homeBtn",title="Home",alt="Home"'); }?></li>
				<li <?=($tabon==1)?'class="selected"':''?>>
				<?php echo anchor('/ads/create/', " ", 'class="freeAdBtn",title="Create Free Ad",alt="Create Free Ad"'); ?>				
				</li>				
				<li <?=($tabon==2)?'class="selected"':''?>>
				<?php echo anchor('ads/advsearch', " ", 'class="advSearchBtn",title="Search",alt="Search"'); ?>				
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
                  <!--<li><div id="welMsg">Welcome <?php// echo $_SESSION['firstname']; ?> !</div>-->
                  <li><div id="welMsg">Welcome <?php echo $this->session->userdata('firstname') ?> !</div>
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
 
<div id="mainBarContainer">
	<p id="bannershado"></p>
	<div id="mainBarHolder">
	  <div id="logoBox">
			<a href="<?=site_url()?>" alt="Shared Akomodation" title="Shared Akomodation">
            <img src="<?=$staticurl?>images/logo.png" border="0" /></a>
		  <h3 class="countryHolder roundBor3">AUSTRALIA</h3>
		</div>
		
		<div id="searchForm" >
			<form action="<?=site_url("/ads/search/")?>" name="search-head" id="search-head" method="GET">
            
            <div id="banfieldsholnw">
            	<div id="locationBlock">
					<label class="flLeft"><h2 class="bannerlabelsh2">LOCATION *</h2></label>
					<label for="surrAreas" id="surrAreasLbl">Include surrounding areas</label>
					<input type="checkbox" id="surrAreas"  value="1" name="surrAreas" <?php if(!empty($_REQUEST['surrAreas'])){?> checked="checked"<?php } elseif(!empty($city)) {?> checked="checked"<?}?> />
					<br class="clearer" />
					<input type="text" id="location" name="location" class="banBarField roundBor2" autocomplete="off" <?php if(isset($location)){?> value="<?=$location ?>" <?php } ?>   title="Enter Suburb / City / Postocde" />
					<input type="hidden" id="locationboxhid" name="locationboxhid" class="banBarField" />
				</div>	
                
                
                	
				<div id="communityBlock"> 
					<label class="flLeft"><h2 class="bannerlabelsh2">PREFERED COMMUNITY</h2></label><br class="clearer" />
					<input type="text" id="community" name="community" readonly="readonly" class="bannercomm"/>
                  <div class="communityContentDrop">
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
                         <p id="commshadow"><img src="<?=$staticurl?>images/communityshdw.png" /></p>   
                    </div>
					<div class="fieldHint">Helps finding accommodation in your own/preferred community.</div>
					<br/>					
				</div>	
                
                
            </div>
            <div id="searchoptnshol" class="roundBor5">
            	<p id="bannerarrow"><img src="<?=$staticurl?>images/bannerarrow.gif" /></p>
                <p id="advsrchhol"><a href="<?=site_url('ads/advsearch')?>">Advanced Search</a></p>
            	<p id="banRadio">
                    <label><input type="radio" name="memberType" id="memberType1" value="1" <?php if(isset($memberType)) {if($memberType==1) {?> checked="checked" <?php }} else {?>checked="checked" <? }?>/>
                    &nbsp;&nbsp;Search Sharing Providers</label><br /><br />
                    <label><input type="radio" name="memberType" id="memberType2" value="0"  <?php if(isset($memberType)) { if($memberType==0) {?> checked="checked" <?php }} ?> />
                    &nbsp;&nbsp;Search Sharing Finders</label>
                </p>
                <p id="banFind">
                    <input type="submit" value="" id="head_findBtn" name="head_findBtn" class="imgBtnHover" />
                    <input type="hidden" name="searchFrom" id="searchFrom" value="1" />
                </p>
            </div>
			</form>
		</div>
		
	</div>		
</div>