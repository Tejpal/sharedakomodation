<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Find Accomodation - Get Shared Accommodation . Anywhere . Anytime .</title>
<?php
$baseurl = $this->config->item('base_url');
$staticurl = $this->config->item('static_url');
$base_url = site_url() . '/';
/*$this->assetlibpro->add_css('css/find.css');
$this->assetlibpro->add_css('css/dev.css');

$this->assetlibpro->add_css('js/checklist/doc/smoothness/jquery-ui-1.8.4.custom.css');
$this->assetlibpro->add_css('js/newSelect/msdropdown/dd.css');
$this->assetlibpro->add_css('css/jquery-ui.css');

$this->assetlibpro->add_css('js/autocomplete/jquery.autocomplete.css');


$this->benchmark->mark('AssetLib_Pro_start_CSS');
echo $this->assetlibpro->output('css');
$this->benchmark->mark('AssetLib_Pro_end_CSS');


$this->assetlibpro->add_js('js/jquery.min.js');
$this->assetlibpro->add_js('js/jquery-ui.min.js');

$this->assetlibpro->add_js('js/cufon-yui.js');
$this->assetlibpro->add_js('js/dinMedium_500.font.js');
$this->assetlibpro->add_js('js/dinRegular_400.font.js');

$this->benchmark->mark('AssetLib_Pro_start_JS');
echo $this->assetlibpro->output('js');
$this->benchmark->mark('AssetLib_Pro_end_JS');*/


?>

<link href="<?=$staticurl?>css/find.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>css/dev.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>js/newSelect/msdropdown/dd.css" rel="stylesheet" type="text/css" />
<LINK href="<?=$staticurl?>css/jquery-ui.css" type="text/css" rel="stylesheet" />
<link href="<?=$staticurl?>js/community/css/ui.multiselect.css" rel="stylesheet" type="text/css" />
<link href="<?=$staticurl?>js/autosuggest/styles/autoSuggest.css" rel="stylesheet" type="text/css" />

<script src="<?=$staticurl?>js/jquery.min.js"></script>
<script src="<?=$staticurl?>js/jquery-ui.min.js"></script>
<script src="<?=$staticurl?>js/community/js/ui.multiselect.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/autosuggest/js/jquery.autoSuggest.js"></script>
<script src="<?=$staticurl?>js/cufon-yui.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinMedium_500.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/dinRegular_400.font.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/newSelect/msdropdown/js/jquery.dd.js" type="text/javascript"></script>
<script src="<?=$staticurl?>js/mydocumentready.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
	$(function() {
		$("#location").autoSuggest({
			ajaxFilePath	: "<?=$base_url?>ajax/locations2/", 
			ajaxParams	 	: "dummydata=dummyData", 
			autoFill	 	: false, 
			iwidth		 	: "600px",
			opacity		 	: "1.0",
			ilimit		 	: "10",
			idHolder	 	: "locationboxhid",
			match		 	: "contains"
		});
	}); 	
});
</script>

</head>
<body>
<?php
$login = false;
if( !empty($_SESSION['user_id']) && $_SESSION['user_id']>0)
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
				<?php echo anchor('', " ", 'class="homeBtn",title="Home",alt="Home"'); ?>				
				</li>
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
                <ul>
                    <li><a href="<?=site_url("/user/signout/")?>" class="navlogout"></a></li>
                    <li><a href="<?=site_url("/user/account/")?>" class="navmyaccount"></a></li>
                    <li><a href="<?=site_url("/myads/manage/")?>" class="navmyads"></a></li>
                  <li><div id="welMsg">Welcome <?php echo $_SESSION['username']; ?> !</div>
                    <div id="navInbox">
                    <a href="<?=site_url("/myads/manage/")?>"><img src="<?=$staticurl?>images/navinbox.gif" border="0" title="2 Unread Messages" alt="Inbox" /></a>
                    <a href="<?=site_url("/myads/manage/")?>" id="msgIndicator">2</a>
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
					<input type="text" class="topLoginFields topBarField" title="username" name="username"  /></div>
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
	<div id="mainBarHolder">
		<div id="logoBox">
			<a href="<?=site_url()?>" alt="Shared Akomodation" title="Shared Akomodation">
            <img src="<?=$staticurl?>images/logo.png" border="0" /></a>
		  <h3 class="countryHolder">AUSTRALIA</h3>
		</div>
		
		<div id="searchForm" >
			<form action="<?=site_url("/ads/search/result/")?>" name="search-head" id="search-head" method="GET" >
				<div id="locationBlock">
					<label for="location" id="banLocation">
						<img src="<?=$staticurl?>images/banLocation.gif" width="220" height="19" /> 
					</label>
					<label for="surrAreas" id="surrAreasLbl">Include surrounding areas</label>
					<input type="checkbox" id="surrAreas" name="surrAreas"/>
								
					<input type="text" id="location" name="location" class="banBarField" title="Enter Suburb / City / Postocde" />
					<input type="hidden" id="locationboxhid" name="locationboxhid" class="banBarField" />
				</div>				
				<div id="communityBlock"> 

					<p>
						<img src="<?=$staticurl?>images/bancommunity.gif" width="154" height="19" />
					</p>
					<input type="text" id="community" name="community" readonly="readonly"/>
                    <div class="communityContentDrop">
                    <select id="communities" class="multiselect" multiple="multiple" name="communities[]" style="height:160px; width:480px;">
                            <option value="AFG">Afghanistan</option>
                            <option value="ALB">Albania</option>
                            <option value="DZA">Algeria</option>
                            <option value="AND">Andorra</option>
                            <option value="ARG">Argentina</option>
                            <option value="ARM">Armenia</option>
                            <option value="ABW">Aruba</option>
                            <option value="AUS">Australia</option>
                            <option value="AUT">Austria</option>
                    
                            <option value="AZE">Azerbaijan</option>
                            <option value="BGD">Bangladesh</option>
                            <option value="BLR">Belarus</option>
                            <option value="BEL">Belgium</option>
                            <option value="BIH">Bosnia and Herzegovina</option>
                            <option value="BRA">Brazil</option>
                            <option value="BRN">Brunei</option>
                            <option value="BGR">Bulgaria</option>
                            <option value="CAN">Canada</option>
                          </select>
                          
                          </div>
					<br/>
					<div class="fieldHint">Helps finding shared accommodation in <br />your own/preferred community.</div>
					<br/>					
				</div>		 
				<div id="findBlock">
                <div id="banRadio">
                    <label><input type="radio" name="memberType" id="memberType1" value="1" checked="checked" />
                    &nbsp;&nbsp;Search Sharing Providers</label><br /><br />
                    <label><input type="radio" name="memberType" id="memberType2" value="0" />
                    &nbsp;&nbsp;Search Sharing Finders</label>
                </div>
					<div id="banFind">
						<input type="image" src="<?=$staticurl?>images/findnow.gif" id="head_findBtn" name="head_findBtn" class="imgBtnHover" />
						<input type="hidden" name="searchFrom" id="searchFrom" value="1" />
					</div>
				</div>
			</form>
		</div>
	</div>		
</div>